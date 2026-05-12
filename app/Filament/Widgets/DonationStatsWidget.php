<?php
namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Campaign;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DonationStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSuccess = Donation::where('status', 'success')->sum('amount');
        $countSuccess = Donation::where('status', 'success')->count();
        $thisYear     = Donation::where('status', 'success')
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        $campaigns    = Donation::where('status', 'success')
            ->whereNotNull('campaign_id')
            ->distinct('campaign_id')
            ->count('campaign_id');

        return [
            Stat::make('إجمالي التبرعات', '$' . number_format($totalSuccess, 2))
                ->description($countSuccess . ' تبرع ناجح')
                ->color('success')
                ->icon('heroicon-o-banknotes'),

            Stat::make('تبرعات ' . Carbon::now()->year, '$' . number_format($thisYear, 2))
                ->description('مجموع السنة الحالية')
                ->color('info')
                ->icon('heroicon-o-calendar'),

            Stat::make('حملات مفعلة', (string) $campaigns)
                ->description('حملات فيها تبرعات')
                ->color('warning')
                ->icon('heroicon-o-megaphone'),

            Stat::make('عدد المتبرعين', (string) $countSuccess)
                ->description('متبرع فريد')
                ->color('primary')
                ->icon('heroicon-o-users'),
        ];
    }
}
