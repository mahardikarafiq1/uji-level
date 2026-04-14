<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Total Pendapatan Kapan Saja (Hanya yang Selesai)
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // 2. Keuntungan (Estimasi 30% dari Total Pendapatan)
        $keuntungan = $totalRevenue * 0.30;
        
        // 3. Jumlah Pembayaran Berhasil (Order Selesai)
        $successfulOrders = Order::where('status', 'completed')->count();
        
        // 4. Jumlah Pembayaran Batal (Order Dibatalkan)
        $failedOrders = Order::where('status', 'cancelled')->count();

        // Cari pemasukan hari ini vs kemarin untuk trend (contoh sederhana)
        $revenueToday = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->sum('total_amount');
            
        $revenueYesterday = Order::where('status', 'completed')
            ->whereDate('created_at', today()->subDay())
            ->sum('total_amount');

        $revenueIncrease = $revenueToday - $revenueYesterday;
        $trendIcon = $revenueIncrease >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        $trendColor = $revenueIncrease >= 0 ? 'success' : 'danger';
        $trendDesc = $revenueIncrease >= 0 ? 'Meningkat dari kemarin' : 'Menurun dari kemarin';

        return [
            Stat::make('Uang Masuk (Total)', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description($trendDesc)
                ->descriptionIcon($trendIcon)
                ->color($trendColor)
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Contoh sparkline static (visual saja)

            Stat::make('Keuntungan Bersih (30%)', 'Rp ' . number_format($keuntungan, 0, ',', '.'))
                ->description('Asumsi margin profit 30%')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Pembayaran Berhasil', $successfulOrders . ' Pesanan')
                ->description('Transaksi selesai')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pembayaran Gagal/Batal', $failedOrders . ' Pesanan')
                ->description('Transaksi dibatalkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}
