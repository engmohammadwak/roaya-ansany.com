<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class SiteSettings extends Page
{
    use WithFileUploads;

    protected static ?string $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'إعدادات الموقع';
    protected static ?string $title           = 'إعدادات الموقع';
    protected static ?int    $navigationSort  = 99;
    protected static string  $view            = 'filament.pages.site-settings';

    public array $data           = [];
    public       $logo_upload    = null;
    public       $favicon_upload = null;

    public function mount(): void
    {
        $keys = [
            // هوية
            'site_name', 'site_favicon', 'site_logo',
            // ألوان رئيسية
            'color_primary', 'color_secondary',
            // ألوان نصوص
            'color_text_dark', 'color_text_muted', 'color_text_label', 'color_placeholder',
            // خلفيات
            'color_bg_body', 'color_bg_light', 'color_bg_card',
            // خاصة
            'color_warning', 'color_danger', 'color_step_active',
            // فوتر
            'footer_description_ar', 'footer_description_en',
            'footer_copyright_ar',   'footer_copyright_en',
            // تواصل
            'contact_phone', 'contact_email', 'whatsapp_number',
        ];
        foreach ($keys as $key) {
            $this->data[$key] = Setting::get($key);
        }
        $admin = User::first();
        if ($admin) {
            $this->data['admin_username'] = $admin->name;
            $this->data['admin_email']    = $admin->email;
        }
    }

    public function save(): void
    {
        if ($this->logo_upload) {
            $path = $this->logo_upload->store('site', 'public');
            $this->data['site_logo'] = asset('storage/' . $path);
        }
        if ($this->favicon_upload) {
            $path = $this->favicon_upload->store('site', 'public');
            $this->data['site_favicon'] = asset('storage/' . $path);
        }

        $keys = [
            'site_name', 'site_favicon', 'site_logo',
            'color_primary', 'color_secondary',
            'color_text_dark', 'color_text_muted', 'color_text_label', 'color_placeholder',
            'color_bg_body', 'color_bg_light', 'color_bg_card',
            'color_warning', 'color_danger', 'color_step_active',
            'footer_description_ar', 'footer_description_en',
            'footer_copyright_ar',   'footer_copyright_en',
            'contact_phone', 'contact_email', 'whatsapp_number',
        ];
        foreach ($keys as $key) {
            if (array_key_exists($key, $this->data)) {
                Setting::set($key, $this->data[$key] ?? '');
            }
        }

        $admin = User::first();
        if ($admin) {
            $update = [
                'name'  => $this->data['admin_username'] ?? $admin->name,
                'email' => $this->data['admin_email']    ?? $admin->email,
            ];
            if (!empty($this->data['admin_password'])) {
                $update['password'] = Hash::make($this->data['admin_password']);
            }
            $admin->update($update);
        }

        Cache::flush();

        Notification::make()
            ->title('تم حفظ الإعدادات بنجاح ✅')
            ->success()
            ->send();
    }
}
