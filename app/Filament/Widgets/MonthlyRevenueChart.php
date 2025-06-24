<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MonthlyRevenueChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Bulanan';
    
    protected static ?int $sort = 2;
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Transaction::where('payment_status', 'paid')
            ->select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereYear('payment_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $chartData = [];
        $labels = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthData = $data->where('month', $i)->first();
            $chartData[] = $monthData ? $monthData->total : 0;
            $labels[] = $months[$i];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $chartData,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
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
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + new Intl.NumberFormat("id-ID").format(value); }',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return "Pendapatan: Rp " + new Intl.NumberFormat("id-ID").format(context.parsed.y); }',
                    ],
                ],
            ],
        ];
    }
}
