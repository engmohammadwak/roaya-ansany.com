<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;
    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'الحملات';
    protected static ?string $modelLabel = 'حملة';
    protected static ?string $pluralModelLabel = 'الحملات';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('translations')->tabs([
                Forms\Components\Tabs\Tab::make('العربية')->schema([
                    Forms\Components\TextInput::make('title_ar')->label('العنوان بالعربية')->required(),
                    Forms\Components\Textarea::make('description_ar')->label('الوصف بالعربية')->required()->rows(4),
                ]),
                Forms\Components\Tabs\Tab::make('English')->schema([
                    Forms\Components\TextInput::make('title_en')->label('Title in English')->required(),
                    Forms\Components\Textarea::make('description_en')->label('Description in English')->required()->rows(4),
                ]),
            ])->columnSpanFull(),

            Forms\Components\FileUpload::make('image')
                ->label('الصورة')
                ->image()
                ->disk('public')
                ->directory('campaigns')
                ->visibility('public')
                ->maxSize(5120)
                ->columnSpanFull(),

            Forms\Components\TextInput::make('target_amount')->label('المبلغ المستهدف')->numeric()->required(),
            Forms\Components\TextInput::make('collected_amount')->label('المبلغ المجموع')->numeric()->default(0),
            Forms\Components\DatePicker::make('end_date')->label('تاريخ الانتهاء'),
            Forms\Components\Toggle::make('is_active')->label('نشطة')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('الصورة')->disk('public'),
                Tables\Columns\TextColumn::make('title_ar')->label('العنوان')->searchable(),
                Tables\Columns\TextColumn::make('target_amount')->label('المستهدف')->money('USD'),
                Tables\Columns\TextColumn::make('collected_amount')->label('المجموع')->money('USD'),
                Tables\Columns\IconColumn::make('is_active')->label('نشطة')->boolean(),
                Tables\Columns\TextColumn::make('end_date')->label('ينتهي')->date(),
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
            'index'  => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit'   => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
