<?php
namespace App\Filament\Resources;
use App\Filament\Resources\PrivacyPolicyResource\Pages;
use App\Models\PrivacyPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrivacyPolicyResource extends Resource
{
    protected static ?string $model = PrivacyPolicy::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'سياسة الخصوصية';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 9;

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
            'index'  => Pages\ListPrivacyPolicies::route('/'),
            'create' => Pages\CreatePrivacyPolicy::route('/create'),
            'edit'   => Pages\EditPrivacyPolicy::route('/{record}/edit'),
        ];
    }
}
