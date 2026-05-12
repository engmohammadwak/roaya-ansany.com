<?php
namespace App\Filament\Resources;
use App\Filament\Resources\TermsOfUseResource\Pages;
use App\Models\TermsOfUse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TermsOfUseResource extends Resource
{
    protected static ?string $model = TermsOfUse::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'شروط الاستخدام';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title_ar')->label('العنوان (عربي)'),
                Forms\Components\TextInput::make('title_en')->label('العنوان (إنجليزي)'),
                Forms\Components\DateTimePicker::make('last_updated')->label('تاريخ آخر تحديث'),
            ]),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\RichEditor::make('content_ar')->label('المحتوى (عربي)')->required(),
                Forms\Components\RichEditor::make('content_en')->label('المحتوى (إنجليزي)')->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('title_ar')->label('العنوان'),
            Tables\Columns\TextColumn::make('last_updated')->label('آخر تحديث')->dateTime('Y-m-d')->sortable(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListTermsOfUses::route('/'),
            'create' => Pages\CreateTermsOfUse::route('/create'),
            'edit'   => Pages\EditTermsOfUse::route('/{record}/edit'),
        ];
    }
}
