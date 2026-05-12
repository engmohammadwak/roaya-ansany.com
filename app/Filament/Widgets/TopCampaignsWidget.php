<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Campaign;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopCampaignsWidget extends BaseWidget
{
    protected static ?string $heading    = '🏆 أعلى الحملات تبرعاً';
    protected static ?int    $sort       = 5;
    protected int | string | array $columnSpan = 'full';
    protected static ?int    $maxItems   = 5;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Campaign::query()
                    ->withSum(['donations as total_amount' => fn (Builder $q) =>
                        $q->whereIn('status', ['success', 'completed'])
                    ], 'amount')
                    ->withCount(['donations as donations_count' => fn (Builder $q) =>
                        $q->whereIn('status', ['success', 'completed'])
                    ])
                    ->orderByDesc('total_amount')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title_ar')
                    ->label('الحملة')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('إجمالي التبرعات')
                    ->formatStateUsing(fn ($state) => '$' . number_format((float)$state, 2))
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('donations_count')
                    ->label('عدد التبرعات')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('goal_amount')
                    ->label('الهدف')
                    ->formatStateUsing(fn ($state) => $state ? '$' . number_format((float)$state, 2) : '—')
                    ->color('warning'),
            ])
            ->paginated(false);
    }
}
