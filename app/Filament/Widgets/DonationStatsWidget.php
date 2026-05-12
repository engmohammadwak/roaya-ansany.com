<?php
namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\Campaign;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class DonationStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSuccess = Donation::whereIn('status', ['success', 'completed'])->sum('amount');
        $countSuccess = Donation::whereIn('status', ['success', 'completed'])->count();

        $thisMonth    = Donation::whereIn('status', ['success', 'completed'])
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        $lastMonth    = Donation::whereIn('status', ['success', 'completed'])
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('amount');
        $monthDiff    = $lastMonth > 0
            ? round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1)
            : ($thisMonth > 0 ? 100 : 0);

        $today        = Donation::whereIn('status', ['success', 'completed'])
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
        $todayCount   = Donation::whereIn('status', ['success', 'completed'])
            ->whereDate('created_at', Carbon::today())
            ->count();

        $failedToday  = Donation::where('status', 'failed')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $campaigns    = Donation::whereIn('status', ['success', 'completed'])
            ->whereNotNull('campaign_id')
            ->distinct('campaign_id')
            ->count('campaign_id');

        $uniqueDonors = Donation::whereIn('status', ['success', 'completed'])
            ->distinct('name')
            ->count('name');

        // اخر 7 أيام للـ chart في الكارد
        $last7 = collect(range(6, 0))->map(fn ($i) =>
            (float) Donation::whereIn('status', ['success', 'completed'])
                ->whereDate('created_at', Carbon::today()->subDays($i))
                ->sum('amount')
        )->values()->toArray();

        $last7Failed = collect(range(6, 0))->map(fn ($i) =>
            (int) Donation::where('status', 'failed')
                ->whereDate('created_at', Carbon::today()->subDays($i))
                ->count()
        )->values()->toArray();

        return [
            Stat::make('💰 إجمالي التبرعات', '$' . number_format($totalSuccess, 2))
                ->description($countSuccess . ' تبرع ناجح')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->chart($last7)
                ->url(route('filament.admin.resources.donations.index')),

            Stat::make('📅 هذا الشهر', '$' . number_format($thisMonth, 2))
                ->description(($monthDiff >= 0 ? '↑ ' : '↓ ') . abs($monthDiff) . '% عن الشهر الماضي')
                ->descriptionIcon($monthDiff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthDiff >= 0 ? 'success' : 'danger')
                ->url(route('filament.admin.resources.donations.index')),

            Stat::make('☀️ اليوم', '$' . number_format($today, 2))
                ->description($todayCount . ' تبرع | ' . ($failedToday > 0 ? '⚠️ ' . $failedToday . ' فاشل' : 'لا فشل'))
                ->descriptionIcon($failedToday > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-sun')
                ->color($failedToday > 0 ? 'warning' : 'info')
                ->chart($last7)
                ->url(route('filament.admin.resources.donations.index')),

            Stat::make('❌ دفعات فاشلة اليوم', (string) $failedToday)
                ->description($failedToday > 0 ? 'يتطلب مراجعة' : 'كل شي طيب')
                ->descriptionIcon($failedToday > 0 ? 'heroicon-m-exclamation-circle' : 'heroicon-m-check-badge')
                ->color($failedToday > 0 ? 'danger' : 'success')
                ->chart($last7Failed)
                ->url(route('filament.admin.resources.donations.index')),

            Stat::make('📢 حملات مفعلة', (string) $campaigns)
                ->description('حملات فيها تبرعات')
                ->descriptionIcon('heroicon-m-megaphone')
                ->color('warning')
                ->url(route('filament.admin.resources.campaigns.index')),

            Stat::make('👥 المتبرعون', (string) $uniqueDonors)
                ->description('متبرع فريد')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->url(route('filament.admin.resources.donations.index')),
        ];
    }
}
