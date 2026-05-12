<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class DonationDailyChart extends ChartWidget
{
    protected static ?string $heading    = '📈 التبرعات اليومية (آخر 30 يوم)';
    protected static ?int    $sort       = 4;
    protected static string  $color      = 'info';
    protected int | string   $columnSpan = 'full';

    protected function getData(): array
    {
        $labels  = [];
        $amounts = [];
        $counts  = [];

        for ($i = 29; $i >= 0; $i--) {
            $day      = Carbon::now()->subDays($i);
            $labels[] = $day->format('d/m');

            $amounts[] = (float) Donation::whereIn('status', ['success', 'completed'])
                ->whereDate('created_at', $day->toDateString())
                ->sum('amount');

            $counts[] = (int) Donation::whereIn('status', ['success', 'completed'])
                ->whereDate('created_at', $day->toDateString())
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label'       => 'مبلغ التبرعات ($)',
                    'data'        => $amounts,
                    'borderColor' => 'rgba(59,130,246,1)',
                    'backgroundColor' => 'rgba(59,130,246,0.12)',
                    'fill'        => true,
                    'tension'     => 0.4,
                    'pointRadius' => 4,
                    'pointBackgroundColor' => 'rgba(59,130,246,1)',
                    'yAxisID'     => 'y',
                ],
                [
                    'label'       => 'عدد التبرعات',
                    'data'        => $counts,
                    'borderColor' => 'rgba(168,85,247,1)',
                    'backgroundColor' => 'rgba(168,85,247,0.08)',
                    'fill'        => false,
                    'tension'     => 0.4,
                    'pointRadius' => 3,
                    'borderDash'  => [4, 4],
                    'yAxisID'     => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['position' => 'top'],
            ],
            'scales' => [
                'y'  => ['beginAtZero' => true, 'position' => 'left',  'title' => ['display' => true, 'text' => 'المبلغ ($)']],
                'y1' => ['beginAtZero' => true, 'position' => 'right', 'title' => ['display' => true, 'text' => 'عدد التبرعات'], 'grid' => ['drawOnChartArea' => false]],
            ],
        ];
    }
}
