<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class SiteSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'إعدادات الموقع';
    protected static ?string $title = 'إعدادات الموقع';
    protected static ?int $navigationSort = 99;
    protected static string $view = 'filament.pages.site-settings';

    public array $data = [];

    public function mount(): void
    {
        $keys = [
            'site_name', 'site_favicon', 'site_logo',
            'primary_color', 'secondary_color',
            'footer_description_ar', 'footer_description_en',
            'footer_copyright_ar', 'footer_copyright_en',
            'contact_phone', 'contact_email', 'whatsapp_number',
            'admin_username', 'admin_email',
        ];

        foreach ($keys as $key) {
            $this->data[$key] = Setting::get($key);
        }

        // Admin user info
        $admin = User::first();
        if ($admin) {
            $this->data['admin_username'] = $admin->name;
            $this->data['admin_email']    = $admin->email;
        }
    }

    public function save(): void
    {
        $keys = [
            'site_name', 'site_favicon', 'site_logo',
            'primary_color', 'secondary_color',
            'footer_description_ar', 'footer_description_en',
            'footer_copyright_ar', 'footer_copyright_en',
            'contact_phone', 'contact_email', 'whatsapp_number',
        ];

        foreach ($keys as $key) {
            if (isset($this->data[$key]) && $this->data[$key] !== null) {
                Setting::set($key, $this->data[$key]);
            }
        }

        // Update admin credentials
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
