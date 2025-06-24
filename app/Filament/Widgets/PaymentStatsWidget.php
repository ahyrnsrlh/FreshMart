<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PaymentStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $pendingPayments = Transaction::where('payment_status', 'pending')->count();
        $paidToday = Transaction::where('payment_status', 'paid')
            ->whereDate('payment_date', today())
            ->count();
        $totalRevenueToday = Transaction::where('payment_status', 'paid')
            ->whereDate('payment_date', today())
            ->sum('total_price');
        $totalPendingAmount = Transaction::where('payment_status', 'pending')->sum('total_price');

        return [
            Stat::make('Pembayaran Pending', $pendingPayments)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingPayments > 0 ? 'warning' : 'success')
                ->url(route('filament.admin.resources.transactions.index', ['tableFilters[payment_status][value]' => 'pending'])),
                
            Stat::make('Dibayar Hari Ini', $paidToday)
                ->description('Pembayaran berhasil')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
                
            Stat::make('Pendapatan Hari Ini', 'Rp ' . number_format($totalRevenueToday, 0, ',', '.'))
                ->description('Total pembayaran masuk')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
                
            Stat::make('Nilai Pending', 'Rp ' . number_format($totalPendingAmount, 0, ',', '.'))
                ->description('Total nilai menunggu')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('warning'),
        ];
    }
}
