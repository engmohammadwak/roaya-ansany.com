<?php
namespace App\Filament\Resources;
use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use App\Models\FaqCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'الأسئلة الشائعة';
    protected static ?string $navigationGroup = 'إدارة الصفحات';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Select::make('faq_category_id')
                    ->label('التصنيف')
                    ->options(FaqCategory::orderBy('sort_order')->pluck('name_ar','id'))
                    ->searchable()->nullable(),
                Forms\Components\Toggle::make('is_active')->label('نشط')->default(true),
                Forms\Components\Textarea::make('question_ar')->label('السؤال (عربي)')->required()->rows(2),
                Forms\Components\Textarea::make('question_en')->label('السؤال (إنجليزي)')->rows(2),
                Forms\Components\RichEditor::make('answer_ar')->label('الإجابة (عربي)')->required()->columnSpan(1),
                Forms\Components\RichEditor::make('answer_en')->label('الإجابة (إنجليزي)')->columnSpan(1),
                Forms\Components\TextInput::make('sort_order')->label('الترتيب')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table {
        return $table->columns([
            Tables\Columns\TextColumn::make('category.name_ar')->label('التصنيف'),
            Tables\Columns\TextColumn::make('question_ar')->label('السؤال')->limit(60)->searchable(),
            Tables\Columns\IconColumn::make('is_active')->label('نشط')->boolean(),
            Tables\Columns\TextColumn::make('sort_order')->label('الترتيب')->sortable(),
        ])->defaultSort('sort_order')
          ->reorderable('sort_order')
          ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
          ])->headerActions([Tables\Actions\CreateAction::make()]);
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
