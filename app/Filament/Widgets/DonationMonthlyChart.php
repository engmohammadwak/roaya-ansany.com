<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class DonationMonthlyChart extends ChartWidget
{
    protected static ?string $heading      = '📅 التبرعات الشهرية (آخر 12 شهر)';
    protected static ?int    $sort         = 3;
    protected static string  $color        = 'success';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $labels  = [];
        $success = [];
        $failed  = [];

        foreach ($months as $month) {
            $labels[] = $month->translatedFormat('M Y');

            $success[] = (float) Donation::whereIn('status', ['success', 'completed'])
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');

            $failed[] = (float) Donation::where('status', 'failed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
        }

        return [
            'datasets' => [
                [
                    'label'           => 'مبلغ التبرعات الناجحة',
                    'data'            => $success,
                    'backgroundColor' => 'rgba(34,197,94,0.7)',
                    'borderColor'     => 'rgba(34,197,94,1)',
                    'borderWidth'     => 2,
                    'borderRadius'    => 6,
                ],
                [
                    'label'           => 'مبلغ التبرعات الفاشلة',
                    'data'            => $failed,
                    'backgroundColor' => 'rgba(239,68,68,0.6)',
                    'borderColor'     => 'rgba(239,68,68,1)',
                    'borderWidth'     => 2,
                    'borderRadius'    => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['position' => 'top'],
                'tooltip' => [
                    'callbacks' => [],
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks'       => ['callback' => 'function(v){ return "$"+v.toLocaleString(); }'],
                ],
            ],
        ];
    }
}
