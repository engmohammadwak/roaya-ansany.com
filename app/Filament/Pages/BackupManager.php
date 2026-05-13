<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use PDO;
use ZipArchive;

class BackupManager extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon  = 'heroicon-o-archive-box-arrow-down';
    protected static ?string $navigationLabel = 'النسخ الاحتياطية';
    protected static ?string $title           = 'إدارة النسخ الاحتياطية';
    protected static ?int    $navigationSort  = 98;
    protected static string  $view            = 'filament.pages.backup-manager';

    public $backup_file = null;
    public array $backups = [];

    public function mount(): void
    {
        $this->loadBackups();
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────
    private function loadBackups(): void
    {
        $files = Storage::disk('local')->files('backups');
        $list  = [];
        foreach ($files as $file) {
            if (str_ends_with($file, '.zip')) {
                $list[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $this->formatBytes(Storage::disk('local')->size($file)),
                    'date' => date('Y-m-d H:i', Storage::disk('local')->lastModified($file)),
                ];
            }
        }
        usort($list, fn($a, $b) => $b['date'] <=> $a['date']);
        $this->backups = $list;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576)    return round($bytes / 1048576, 2)    . ' MB';
        if ($bytes >= 1024)       return round($bytes / 1024, 2)       . ' KB';
        return $bytes . ' B';
    }

    // ─────────────────────────────────────────────
    // 1. Create full backup (DB + storage images)
    // ─────────────────────────────────────────────
    public function createBackup(): void
    {
        try {
            $timestamp  = now()->format('Y-m-d_H-i-s');
            $backupDir  = storage_path('app/backups');
            $zipPath    = $backupDir . '/backup_' . $timestamp . '.zip';
            $sqlPath    = $backupDir . '/db_temp_' . $timestamp . '.sql';

            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            // 1. Dump database to temp SQL file
            file_put_contents($sqlPath, $this->dumpDatabase());

            // 2. Create ZIP
            $zip = new ZipArchive();
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('تعذر إنشاء ملف ZIP');
            }

            // Add DB sql
            $zip->addFile($sqlPath, 'database/database.sql');

            // Add all files from storage/app/public (uploaded images, etc.)
            $publicStoragePath = storage_path('app/public');
            if (is_dir($publicStoragePath)) {
                $this->addDirectoryToZip($zip, $publicStoragePath, 'storage');
            }

            $zip->close();

            // Remove temp SQL
            @unlink($sqlPath);

            $this->loadBackups();

            Notification::make()
                ->title('تم إنشاء النسخة الاحتياطية بنجاح ✅ (DB + الصور)')
                ->success()
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('خطأ: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function addDirectoryToZip(ZipArchive $zip, string $dir, string $zipFolder): void
    {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isFile()) continue;
            $realPath    = $file->getRealPath();
            $relativePath = $zipFolder . '/' . ltrim(str_replace($dir, '', $realPath), DIRECTORY_SEPARATOR);
            $zip->addFile($realPath, $relativePath);
        }
    }

    private function dumpDatabase(): string
    {
        $pdo    = DB::connection()->getPdo();
        $dbName = config('database.connections.' . config('database.default') . '.database');
        $sql    = "-- Backup: {$dbName} | " . now()->toDateTimeString() . "\nSET FOREIGN_KEY_CHECKS=0;\n\n";

        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $create['Create Table'] . ";\n\n";

            $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
                $values = array_map(fn($v) => $v === null ? 'NULL' : $pdo->quote($v), $row);
                $sql   .= "INSERT INTO `{$table}` VALUES (" . implode(', ', $values) . ");\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        return $sql;
    }

    // ─────────────────────────────────────────────
    // 2. Download backup ZIP
    // ─────────────────────────────────────────────
    public function downloadBackup(string $path)
    {
        $fullPath = Storage::disk('local')->path($path);
        if (!file_exists($fullPath)) {
            Notification::make()->title('الملف غير موجود')->danger()->send();
            return;
        }
        return response()->download($fullPath, basename($path));
    }

    // ─────────────────────────────────────────────
    // 3. Delete backup
    // ─────────────────────────────────────────────
    public function deleteBackup(string $path): void
    {
        Storage::disk('local')->delete($path);
        $this->loadBackups();
        Notification::make()->title('تم حذف النسخة ✅')->success()->send();
    }

    // ─────────────────────────────────────────────
    // 4. Upload & Restore full ZIP backup
    // ─────────────────────────────────────────────
    public function restoreBackup(): void
    {
        $this->validate([
            'backup_file' => 'required|file|mimes:zip|max:512000',
        ], [
            'backup_file.required' => 'يرجى اختيار ملف النسخة.',
            'backup_file.mimes'    => 'يجب أن يكون الملف بصيغة .zip',
        ]);

        try {
            $tmpPath   = $this->backup_file->getRealPath();
            $timestamp = now()->format('Y-m-d_H-i-s');
            $backupDir = storage_path('app/backups');
            $savedZip  = $backupDir . '/restored_' . $timestamp . '.zip';

            if (!is_dir($backupDir)) mkdir($backupDir, 0755, true);

            // Save zip permanently
            copy($tmpPath, $savedZip);

            $zip = new ZipArchive();
            if ($zip->open($savedZip) !== true) {
                throw new \RuntimeException('تعذر فتح ملف ZIP');
            }

            // ── Restore DB ──
            $sqlContent = null;
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (str_ends_with($name, '.sql')) {
                    $sqlContent = $zip->getFromIndex($i);
                    break;
                }
            }

            if ($sqlContent) {
                DB::unprepared($sqlContent);
            }

            // ── Restore storage files ──
            $publicStoragePath = storage_path('app/public');
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);
                if (!str_starts_with($name, 'storage/')) continue;
                if (str_ends_with($name, '/')) continue; // skip dirs

                $relativePath = substr($name, strlen('storage/'));
                $destPath     = $publicStoragePath . '/' . $relativePath;
                $destDir      = dirname($destPath);

                if (!is_dir($destDir)) mkdir($destDir, 0755, true);
                file_put_contents($destPath, $zip->getFromIndex($i));
            }

            $zip->close();

            $this->backup_file = null;
            $this->loadBackups();

            Notification::make()
                ->title('تمت استعادة النسخة بنجاح ✅ (DB + الصور)')
                ->success()
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->title('خطأ: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
