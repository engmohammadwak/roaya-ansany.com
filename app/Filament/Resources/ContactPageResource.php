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
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'صفحة اتصل بنا';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Tabs::make()->tabs([
                Forms\Components\Tabs\Tab::make('Hero')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('hero_title_ar')->label('العنوان عربي'),
                        Forms\Components\TextInput::make('hero_title_en')->label('العنوان إنجليزي'),
                        Forms\Components\Textarea::make('hero_subtitle_ar')->label('النص الفرعي عربي')->rows(3),
                        Forms\Components\Textarea::make('hero_subtitle_en')->label('النص الفرعي إنجليزي')->rows(3),
                    ]),
                ]),
                Forms\Components\Tabs\Tab::make('معلومات التواصل')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('email')->label('البريد الإلكتروني')->email(),
                        Forms\Components\TextInput::make('phone')->label('الهاتف'),
                        Forms\Components\TextInput::make('whatsapp')->label('واتساب'),
                        Forms\Components\Textarea::make('address_ar')->label('العنوان عربي')->rows(2),
                        Forms\Components\Textarea::make('address_en')->label('العنوان إنجليزي')->rows(2),
                    ]),
                ]),
                Forms\Components\Tabs\Tab::make('السوشيال ميديا')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('facebook')->label('Facebook')->url(),
                        Forms\Components\TextInput::make('twitter')->label('Twitter/X')->url(),
                        Forms\Components\TextInput::make('instagram')->label('Instagram')->url(),
                        Forms\Components\TextInput::make('youtube')->label('YouTube')->url(),
                    ]),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('email')->label('البريد'),
            Tables\Columns\TextColumn::make('phone')->label('الهاتف'),
            Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->dateTime('Y-m-d H:i'),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListContactPages::route('/'),
            'create' => Pages\CreateContactPage::route('/create'),
            'edit'   => Pages\EditContactPage::route('/{record}/edit'),
        ];
    }
}
