<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
            'site_name', 'site_favicon', 'site_logo', 'maintenance_mode',
            'color_primary', 'color_secondary',
            'color_text_dark', 'color_text_muted', 'color_text_label', 'color_placeholder',
            'color_bg_body', 'color_bg_light', 'color_bg_card',
            'color_warning', 'color_danger', 'color_step_active',
            'footer_description_ar', 'footer_description_en',
            'footer_copyright_ar',   'footer_copyright_en',
            'contact_phone',   'contact_phone_2',   'contact_phone_3',
            'contact_email',   'contact_email_2',   'contact_email_3',
            'whatsapp_number',   'whatsapp_number_2',   'whatsapp_number_3',
            'whatsapp_text_1',   'whatsapp_text_2',     'whatsapp_text_3',
            'social_facebook', 'social_instagram', 'social_twitter', 'social_whatsapp',
            'navbar_links_enabled',
            'navbar_sticky_only',
            'hero_label_ar', 'hero_label_en',
            'hero_label_top', 'hero_label_left', 'hero_label_right',
        ];

        foreach ($keys as $key) {
            $default = match($key) {
                'navbar_links_enabled' => '1',
                'navbar_sticky_only'   => '0',
                'maintenance_mode'     => '0',
                'hero_label_top'       => '12px',
                'hero_label_left'      => '0',
                'hero_label_right'     => '0',
                default                => '',
            };
            $this->data[$key] = Setting::get($key, $default);
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
            $filename = 'site/' . uniqid() . '.' . $this->logo_upload->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($this->logo_upload->getRealPath()));
            $this->data['site_logo'] = $filename;
        }

        if ($this->favicon_upload) {
            $filename = 'site/' . uniqid() . '.' . $this->favicon_upload->getClientOriginalExtension();
            Storage::disk('public')->put($filename, file_get_contents($this->favicon_upload->getRealPath()));
            $this->data['site_favicon'] = $filename;
        }

        $keys = [
            'site_name', 'site_favicon', 'site_logo', 'maintenance_mode',
            'color_primary', 'color_secondary',
            'color_text_dark', 'color_text_muted', 'color_text_label', 'color_placeholder',
            'color_bg_body', 'color_bg_light', 'color_bg_card',
            'color_warning', 'color_danger', 'color_step_active',
            'footer_description_ar', 'footer_description_en',
            'footer_copyright_ar',   'footer_copyright_en',
            'contact_phone',   'contact_phone_2',   'contact_phone_3',
            'contact_email',   'contact_email_2',   'contact_email_3',
            'whatsapp_number',   'whatsapp_number_2',   'whatsapp_number_3',
            'whatsapp_text_1',   'whatsapp_text_2',     'whatsapp_text_3',
            'social_facebook', 'social_instagram', 'social_twitter', 'social_whatsapp',
            'navbar_links_enabled',
            'navbar_sticky_only',
            'hero_label_ar', 'hero_label_en',
            'hero_label_top', 'hero_label_left', 'hero_label_right',
        ];

        $boolKeys = ['navbar_links_enabled', 'navbar_sticky_only', 'maintenance_mode'];

        foreach ($keys as $key) {
            if (array_key_exists($key, $this->data)) {
                $value = $this->data[$key];
                if (in_array($key, $boolKeys, true)) {
                    $value = ($value === true || $value === '1' || $value === 1) ? '1' : '0';
                }
                Setting::set($key, $value ?? '');
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
