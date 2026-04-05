<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use App\Models\Order;
use App\Models\Product;
use App\Models\Seat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CafeStatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $pendingBookings = Booking::where('status', 'reserved')->count();
        $todaysBookings = Booking::whereDate('date', now()->toDateString())->count();

        return [
            Stat::make('☕ Menu Items', Product::count())
                ->description('Products in the menu')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('🪑 Total Seats', Seat::count())
                ->description('Seats configured')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('info'),

            Stat::make('📅 Today\'s Bookings', $todaysBookings)
                ->description("{$pendingBookings} pending reservation(s)")
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),

            Stat::make('💰 Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('From completed orders')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
