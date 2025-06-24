<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Total Revenue
        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('total_price');
        
        // Pending Revenue
        $pendingRevenue = Transaction::where('payment_status', 'pending')->sum('total_price');
        
        // Revenue growth calculation (this month vs last month)
        $thisMonth = Transaction::where('payment_status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('total_price');
            
        $lastMonth = Transaction::where('payment_status', 'paid')
            ->whereMonth('payment_date', now()->subMonth()->month)
            ->whereYear('payment_date', now()->subMonth()->year)
            ->sum('total_price');
            
        $revenueGrowth = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;
        
        // Orders statistics
        $totalOrders = Transaction::count();
        $pendingOrders = Transaction::where('order_status', 'pending')->count();
        $completedOrders = Transaction::where('order_status', 'delivered')->count();
          // Customer statistics
        $totalCustomers = User::where('role', 'customer')->count();
        $newCustomersToday = User::where('role', 'customer')
            ->whereDate('created_at', today())
            ->count();

        return [
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description($revenueGrowth > 0 ? 'Naik ' . number_format($revenueGrowth, 1) . '% dari bulan lalu' : 'Turun ' . number_format(abs($revenueGrowth), 1) . '% dari bulan lalu')
                ->descriptionIcon($revenueGrowth > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueGrowth > 0 ? 'success' : 'danger')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->icon('heroicon-o-banknotes'),
                
            Stat::make('Pendapatan Tertunda', 'Rp ' . number_format($pendingRevenue, 0, ',', '.'))
                ->description('Pembayaran yang belum dikonfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),
                
            Stat::make('Total Pesanan', number_format($totalOrders))
                ->description($pendingOrders . ' pesanan tertunda, ' . $completedOrders . ' selesai')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info')
                ->chart([1, 3, 5, 10, 20, 40, $totalOrders])
                ->icon('heroicon-o-shopping-bag'),
                
            Stat::make('Total Pelanggan', number_format($totalCustomers))
                ->description($newCustomersToday . ' pelanggan baru hari ini')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('primary')
                ->icon('heroicon-o-users'),
        ];
    }
}
