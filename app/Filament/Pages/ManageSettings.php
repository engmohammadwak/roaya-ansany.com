<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'إعدادات الموقع';
    protected static ?string $title = 'إعدادات الموقع';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'filament.pages.manage-settings';

    public array $data = [];

    public function mount(): void
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الموقع')->schema([
                    Forms\Components\TextInput::make('site_name_ar')->label('اسم الموقع بالعربية'),
                    Forms\Components\TextInput::make('site_name_en')->label('اسم الموقع بالإنجليزية'),
                    Forms\Components\FileUpload::make('logo')->label('الشعار')->image()->directory('settings'),
                    Forms\Components\FileUpload::make('favicon')->label('الفافيكون')->image()->directory('settings'),
                ])->columns(2),

                Forms\Components\Section::make('بيانات التواصل')->schema([
                    Forms\Components\TextInput::make('site_email')->label('البريد الإلكتروني')->email(),
                    Forms\Components\TextInput::make('site_phone')->label('رقم الهاتف'),
                    Forms\Components\TextInput::make('site_address_ar')->label('العنوان بالعربية'),
                    Forms\Components\TextInput::make('site_address_en')->label('العنوان بالإنجليزية'),
                ])->columns(2),

                Forms\Components\Section::make('روابط السوشيال ميديا')->schema([
                    Forms\Components\TextInput::make('facebook_url')->label('Facebook')->url(),
                    Forms\Components\TextInput::make('twitter_url')->label('Twitter/X')->url(),
                    Forms\Components\TextInput::make('instagram_url')->label('Instagram')->url(),
                    Forms\Components\TextInput::make('youtube_url')->label('YouTube')->url(),
                ])->columns(2),

                Forms\Components\Section::make('الصفحة الرئيسية - Hero')->schema([
                    Forms\Components\TextInput::make('hero_title_ar')
                        ->label('العنوان الرئيسي (عربي)'),
                    Forms\Components\TextInput::make('hero_title_en')
                        ->label('Main Title (English)'),
                    Forms\Components\Textarea::make('hero_desc_ar')
                        ->label('الوصف (عربي)')
                        ->rows(2),
                    Forms\Components\Textarea::make('hero_desc_en')
                        ->label('Description (English)')
                        ->rows(2),
                    Forms\Components\TextInput::make('hero_label_ar')
                        ->label('النص فوق الصورة (عربي)')
                        ->placeholder('تبرعك سينقذ الكثير من الأشخاص'),
                    Forms\Components\TextInput::make('hero_label_en')
                        ->label('Image Label (English)')
                        ->placeholder('Your donation will save many lives'),
                    Forms\Components\TextInput::make('hero_label_top')
                        ->label('موضع النص: Top')
                        ->placeholder('12px')
                        ->default('12px'),
                    Forms\Components\TextInput::make('hero_label_left')
                        ->label('موضع النص: Left')
                        ->placeholder('0 أو 351px')
                        ->default('0'),
                    Forms\Components\TextInput::make('hero_label_right')
                        ->label('موضع النص: Right')
                        ->placeholder('0')
                        ->default('0'),
                    Forms\Components\FileUpload::make('hero_image')
                        ->label('صورة الـ Hero')
                        ->image()
                        ->directory('hero')
                        ->columnSpanFull(),
                ])->columns(2),

                Forms\Components\Section::make('من نحن')->schema([
                    Forms\Components\RichEditor::make('about_text_ar')->label('نص من نحن بالعربية')->columnSpanFull(),
                    Forms\Components\RichEditor::make('about_text_en')->label('نص من نحن بالإنجليزية')->columnSpanFull(),
                ]),

                Forms\Components\Section::make('الصفحات القانونية')->schema([
                    Forms\Components\RichEditor::make('privacy_policy_ar')->label('سياسة الخصوصية بالعربية')->columnSpanFull(),
                    Forms\Components\RichEditor::make('privacy_policy_en')->label('سياسة الخصوصية بالإنجليزية')->columnSpanFull(),
                    Forms\Components\RichEditor::make('terms_ar')->label('الشروط والأحكام بالعربية')->columnSpanFull(),
                    Forms\Components\RichEditor::make('terms_en')->label('الشروط والأحكام بالإنجليزية')->columnSpanFull(),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('تم حفظ الإعدادات بنجاح')
            ->success()
            ->send();
    }
}
