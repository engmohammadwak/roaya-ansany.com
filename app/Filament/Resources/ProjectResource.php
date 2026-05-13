<?php
namespace App\Filament\Resources;
use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model          = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel= '\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639';
    protected static ?string $navigationGroup= '\u0625\u062f\u0627\u0631\u0629 \u0627\u0644\u0635\u0641\u062d\u0627\u062a';
    protected static ?int    $navigationSort = 11;
    protected static bool    $shouldRegisterNavigation = false;

    public static function form(Form $form): Form {
        return $form->schema(CampaignResource::projectForm());
    }
    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\ImageColumn::make('image')->label('\u0627\u0644\u0635\u0648\u0631\u0629'),
            Tables\Columns\TextColumn::make('title_ar')->label('\u0627\u0644\u0645\u0634\u0631\u0648\u0639')->searchable(),
            Tables\Columns\IconColumn::make('is_active')->label('\u0646\u0634\u0637')->boolean(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }
    public static function getPages(): array {
        return [
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
