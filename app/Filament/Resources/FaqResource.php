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
    protected static ?string $navigationIcon  = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'الأسئلة';
    protected static ?string $navigationGroup = 'المحتوى';
    protected static ?int    $navigationSort  = 31;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('📂 التصنيف والحالة')
                ->schema([
                    Forms\Components\Select::make('faq_category_id')
                        ->label('الفئة')
                        ->options(FaqCategory::orderBy('sort_order')->pluck('name_ar', 'id'))
                        ->searchable()
                        ->nullable(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('نشط')
                        ->default(true),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('الترتيب')
                        ->numeric()
                        ->default(0),
                ])->columns(3),

            Forms\Components\Section::make('❓ السؤال')
                ->schema([
                    Forms\Components\Textarea::make('question_ar')
                        ->label('السؤال (عربي)')
                        ->required()
                        ->rows(2),
                    Forms\Components\Textarea::make('question_en')
                        ->label('السؤال (إنجليزي)')
                        ->rows(2),
                ])->columns(2),

            Forms\Components\Section::make('💡 الإجابة')
                ->schema([
                    Forms\Components\RichEditor::make('answer_ar')
                        ->label('الإجابة (عربي)')
                        ->required(),
                    Forms\Components\RichEditor::make('answer_en')
                        ->label('الإجابة (إنجليزي)'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name_ar')
                    ->label('الفئة')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('question_ar')
                    ->label('السؤال')
                    ->limit(70)
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('نشط'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('الترتيب')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('➕ إضافة سؤال'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit'   => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
