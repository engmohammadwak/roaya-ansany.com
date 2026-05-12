<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon  = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'الرئيسية';
    protected static ?string $title           = '📊 لوحة التحكم';
    protected static ?int    $navigationSort  = -2;

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\DonationStatsWidget::class,
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\DonationMonthlyChart::class,
            \App\Filament\Widgets\DonationDailyChart::class,
            \App\Filament\Widgets\TopCampaignsWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'sm'  => 1,
            'md'  => 2,
            'xl'  => 3,
        ];
    }
}
