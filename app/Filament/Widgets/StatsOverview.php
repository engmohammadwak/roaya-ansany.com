<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Donation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي التبرعات', '$' . number_format(Donation::where('status', 'completed')->sum('amount'), 2))
                ->description('التبرعات المكتملة')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('الحملات النشطة', Campaign::active()->count())
                ->description('حملة نشطة حالياً')
                ->color('warning')
                ->icon('heroicon-o-megaphone'),

            Stat::make('المقالات', Blog::published()->count())
                ->description('مقالة منشورة')
                ->color('info')
                ->icon('heroicon-o-document-text'),

            Stat::make('الرسائل الجديدة', Contact::where('is_read', false)->count())
                ->description('رسالة غير مقروءة')
                ->color('danger')
                ->icon('heroicon-o-envelope'),
        ];
    }
}
