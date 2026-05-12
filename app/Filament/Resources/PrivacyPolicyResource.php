<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PrivacyPolicyResource\Pages;
use App\Models\PrivacyPolicy;
use App\Models\PrivacySection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrivacyPolicyResource extends Resource
{
    protected static ?string $model = PrivacyPolicy::class;
    protected static ?string $navigationIcon  = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'إعدادات الصفحات';
    protected static ?string $navigationLabel = 'سياسة الخصوصية';
    protected static ?int    $navigationSort  = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('قسم الهيرو')
                ->schema([
                    Forms\Components\TextInput::make('title_ar')->label('العنوان (عربي)')->required(),
                    Forms\Components\TextInput::make('title_en')->label('العنوان (إنجليزي)'),
                    Forms\Components\Textarea::make('hero_subtitle_ar')->label('الوصف (عربي)')->rows(3),
                    Forms\Components\Textarea::make('hero_subtitle_en')->label('الوصف (إنجليزي)')->rows(3),
                ])->columns(2),

            Forms\Components\Section::make('بنود سياسة الخصوصية')
                ->description('أضف بنوداً بالترتيب — ستظهر تلقائياً مرقّمة على الصفحة')
                ->schema([
                    Forms\Components\Repeater::make('sections')
                        ->relationship('sections')
                        ->schema([
                            Forms\Components\TextInput::make('title_ar')->label('عنوان البند (عربي)')->required(),
                            Forms\Components\TextInput::make('title_en')->label('عنوان البند (إنجليزي)'),
                            Forms\Components\Textarea::make('body_ar')->label('نص البند (عربي)')->rows(3)->required(),
                            Forms\Components\Textarea::make('body_en')->label('نص البند (إنجليزي)')->rows(3),
                            Forms\Components\Hidden::make('sort_order'),
                        ])
                        ->columns(2)
                        ->orderColumn('sort_order')
                        ->reorderableWithButtons()
                        ->addActionLabel('➕ أضف بنداً جديداً')
                        ->cloneable()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_ar')->label('العنوان'),
                Tables\Columns\TextColumn::make('updated_at')->label('آخر تعديل')->dateTime()->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrivacyPolicies::route('/'),
            'edit'  => Pages\EditPrivacyPolicy::route('/{record}/edit'),
        ];
    }
}
