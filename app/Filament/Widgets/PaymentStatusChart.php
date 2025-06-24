<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class PaymentStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Pembayaran';
    
    protected static ?int $sort = 3;
    
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $pending = Transaction::where('payment_status', 'pending')->count();
        $paid = Transaction::where('payment_status', 'paid')->count();
        $failed = Transaction::where('payment_status', 'failed')->count();
        $cancelled = Transaction::where('payment_status', 'cancelled')->count();

        return [
            'datasets' => [
                [
                    'data' => [$pending, $paid, $failed, $cancelled],
                    'backgroundColor' => [
                        'rgb(251, 191, 36)', // warning - pending
                        'rgb(34, 197, 94)',  // success - paid
                        'rgb(239, 68, 68)',  // danger - failed
                        'rgb(156, 163, 175)', // gray - cancelled
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Tertunda', 'Dibayar', 'Gagal', 'Dibatalkan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.label + ": " + context.parsed + " pesanan"; }',
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
