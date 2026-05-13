<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use PDO;

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

    private function loadBackups(): void
    {
        $files = Storage::disk('local')->files('backups');
        $list  = [];
        foreach ($files as $file) {
            if (str_ends_with($file, '.sql') || str_ends_with($file, '.sql.gz')) {
                $list[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $this->formatBytes(Storage::disk('local')->size($file)),
                    'date' => date('Y-m-d H:i', Storage::disk('local')->lastModified($file)),
                ];
            }
        }
        // Sort newest first
        usort($list, fn($a, $b) => $b['date'] <=> $a['date']);
        $this->backups = $list;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 2)    . ' KB';
        return $bytes . ' B';
    }

    // =========================================================
    // 1. Create DB backup
    // =========================================================
    public function createBackup(): void
    {
        try {
            $db   = config('database.connections.' . config('database.default'));
            $name = 'backups/backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

            $sql = $this->dumpDatabase($db);

            Storage::disk('local')->put($name, $sql);
            $this->loadBackups();

            Notification::make()
                ->title('تم إنشاء النسخة الاحتياطية بنجاح ✅')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('خطأ: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function dumpDatabase(array $db): string
    {
        $pdo    = DB::connection()->getPdo();
        $dbName = $db['database'];
        $sql    = "-- Backup: {$dbName} | " . now()->toDateTimeString() . "\nSET FOREIGN_KEY_CHECKS=0;\n\n";

        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Drop + create
            $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_ASSOC);
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $create['Create Table'] . ";\n\n";

            // Data
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

    // =========================================================
    // 2. Download a backup file
    // =========================================================
    public function downloadBackup(string $path)
    {
        if (!Storage::disk('local')->exists($path)) {
            Notification::make()->title('الملف غير موجود')->danger()->send();
            return;
        }
        return response()->download(
            Storage::disk('local')->path($path),
            basename($path)
        );
    }

    // =========================================================
    // 3. Delete a backup
    // =========================================================
    public function deleteBackup(string $path): void
    {
        Storage::disk('local')->delete($path);
        $this->loadBackups();
        Notification::make()->title('تم حذف النسخة ✅')->success()->send();
    }

    // =========================================================
    // 4. Upload & restore a .sql backup
    // =========================================================
    public function restoreBackup(): void
    {
        $this->validate([
            'backup_file' => 'required|file|mimes:sql,txt|max:102400',
        ], [
            'backup_file.required' => 'يرجى اختيار ملف النسخة.',
            'backup_file.mimes'    => 'يجب أن يكون الملف بصيغة .sql',
        ]);

        try {
            $sql = file_get_contents($this->backup_file->getRealPath());

            // Save uploaded file to backups folder
            $stored = 'backups/restored_' . now()->format('Y-m-d_H-i-s') . '.sql';
            Storage::disk('local')->put($stored, $sql);

            // Execute SQL statements
            DB::unprepared($sql);

            $this->backup_file = null;
            $this->loadBackups();

            Notification::make()
                ->title('تم استعادة قاعدة البيانات بنجاح ✅')
                ->success()
                ->send();
        } catch (\Throwable $e) {
            Notification::make()
                ->title('خطأ أثناء الاستعادة: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
