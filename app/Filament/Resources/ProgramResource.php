<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model          = Program::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel= 'البرامج';
    protected static ?string $navigationGroup= 'إدارة الصفحات';
    protected static ?int    $navigationSort = 8;
    protected static bool    $shouldRegisterNavigation = false;

    public static function form(Form $form): Form {
        return $form->schema(CampaignResource::programForm());
    }
    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->label('الصورة'),
            Tables\Columns\TextColumn::make('title_ar')->label('البرنامج')->searchable(),
            Tables\Columns\IconColumn::make('is_active')->label('نشط')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }
    public static function getPages(): array {
        return [
            'index'  => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit'   => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
