<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ContactPageResource\Pages;
use App\Models\ContactPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactPageResource extends Resource
{
    protected static ?string $model = ContactPage::class;
    protected static ?string $navigationIcon  = 'heroicon-o-phone';
    protected static ?string $navigationGroup = 'إعدادات الصفحات';
    protected static ?string $navigationLabel = 'صفحة تواصل معنا';
    protected static ?int    $navigationSort  = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('قسم الهيرو')
                ->schema([
                    Forms\Components\TextInput::make('hero_title_ar')->label('عنوان الهيرو (عربي)')->required(),
                    Forms\Components\TextInput::make('hero_title_en')->label('عنوان الهيرو (إنجليزي)'),
                    Forms\Components\Textarea::make('hero_subtitle_ar')->label('نص الهيرو (عربي)')->rows(3),
                    Forms\Components\Textarea::make('hero_subtitle_en')->label('نص الهيرو (إنجليزي)')->rows(3),
                ])->columns(2),

            Forms\Components\Section::make('بيانات التواصل')
                ->schema([
                    Forms\Components\TextInput::make('email')->label('البريد الإلكتروني')->email(),
                    Forms\Components\TextInput::make('phone')->label('رقم الموبايل'),
                    Forms\Components\TextInput::make('fax')->label('فاكس'),
                    Forms\Components\TextInput::make('whatsapp')->label('واتساب (رقم كامل مع الكود)'),
                    Forms\Components\TextInput::make('work_hours_ar')->label('ساعات العمل (عربي)'),
                    Forms\Components\TextInput::make('work_hours_en')->label('ساعات العمل (إنجليزي)'),
                ])->columns(2),

            Forms\Components\Section::make('روابط التواصل الاجتماعي')
                ->schema([
                    Forms\Components\TextInput::make('facebook')->label('Facebook')->url(),
                    Forms\Components\TextInput::make('instagram')->label('Instagram')->url(),
                    Forms\Components\TextInput::make('twitter')->label('X / Twitter')->url(),
                    Forms\Components\TextInput::make('youtube')->label('YouTube')->url(),
                ])->columns(2),

            Forms\Components\Section::make('البطاقة الجانبية')
                ->schema([
                    Forms\Components\Textarea::make('card_text_ar')->label('نص البطاقة (عربي)')->rows(3),
                    Forms\Components\Textarea::make('card_text_en')->label('نص البطاقة (إنجليزي)')->rows(3),
                ])->columns(2),

            Forms\Components\Section::make('رسائل النموذج')
                ->schema([
                    Forms\Components\TextInput::make('success_msg_ar')->label('رسالة النجاح (عربي)'),
                    Forms\Components\TextInput::make('success_msg_en')->label('رسالة النجاح (إنجليزي)'),
                    Forms\Components\TextInput::make('fail_msg_ar')->label('رسالة الفشل (عربي)'),
                    Forms\Components\TextInput::make('fail_msg_en')->label('رسالة الفشل (إنجليزي)'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')->label('البريد'),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف'),
                Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactPages::route('/'),
            'edit'  => Pages\EditContactPage::route('/{record}/edit'),
        ];
    }
}
