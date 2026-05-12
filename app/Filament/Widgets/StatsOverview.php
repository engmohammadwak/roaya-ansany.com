<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Campaign;
use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRaised = Campaign::sum('collected_amount');
        $totalGoal   = Campaign::sum('target_amount');
        $percent     = $totalGoal > 0 ? min(100, round(($totalRaised / $totalGoal) * 100)) : 0;

        $completedCampaigns = Campaign::whereColumn('collected_amount', '>=', 'target_amount')
            ->where('target_amount', '>', 0)
            ->count();

        return [
            Stat::make('إجمالي التبرعات المُجمَّعة', '$' . number_format($totalRaised, 2))
                ->description('من أصل $' . number_format($totalGoal, 2) . ' هدف — ' . $percent . '%')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('الحملات المكتملة', $completedCampaigns)
                ->description('حملة وصلت لهدفها')
                ->color('primary')
                ->icon('heroicon-o-check-badge'),

            Stat::make('الحملات النشطة', Campaign::active()->count())
                ->description('حملة نشطة حالياً')
                ->color('warning')
                ->icon('heroicon-o-megaphone'),

            Stat::make('المقالات المنشورة', Blog::published()->count())
                ->description('مقالة منشورة')
                ->color('info')
                ->icon('heroicon-o-document-text'),

            Stat::make('الرسائل غير المقروءة', Contact::where('is_read', false)->count())
                ->description('رسالة جديدة في الانتظار')
                ->color('danger')
                ->icon('heroicon-o-envelope'),
        ];
    }
}
