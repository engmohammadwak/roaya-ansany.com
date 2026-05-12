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
        $totalSuccess = Donation::whereIn('status', ['success', 'completed'])->sum('amount');
        $countSuccess = Donation::whereIn('status', ['success', 'completed'])->count();
        $thisYear     = Donation::whereIn('status', ['success', 'completed'])
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
        $campaigns    = Donation::whereIn('status', ['success', 'completed'])
            ->whereNotNull('campaign_id')
            ->distinct('campaign_id')
            ->count('campaign_id');
        $uniqueDonors = Donation::whereIn('status', ['success', 'completed'])
            ->distinct('name')
            ->count('name');

        return [
            Stat::make('إجمالي التبرعات', '$' . number_format($totalSuccess, 2))
                ->description($countSuccess . ' تبرع ناجح')
                ->color('success')
                ->icon('heroicon-o-banknotes')
                ->url(route('filament.admin.resources.donations.index'))
                ->openUrlInNewTab(false),

            Stat::make('تبرعات ' . Carbon::now()->year, '$' . number_format($thisYear, 2))
                ->description('مجموع السنة الحالية')
                ->color('info')
                ->icon('heroicon-o-calendar')
                ->url(route('filament.admin.resources.donations.index'))
                ->openUrlInNewTab(false),

            Stat::make('حملات مفعلة', (string) $campaigns)
                ->description('حملات فيها تبرعات')
                ->color('warning')
                ->icon('heroicon-o-megaphone')
                ->url(route('filament.admin.resources.campaigns.index'))
                ->openUrlInNewTab(false),

            Stat::make('عدد المتبرعين', (string) $uniqueDonors)
                ->description('متبرع فريد')
                ->color('primary')
                ->icon('heroicon-o-users')
                ->url(route('filament.admin.resources.donations.index'))
                ->openUrlInNewTab(false),
        ];
    }
}
