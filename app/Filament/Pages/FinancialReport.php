<?php

namespace App\Filament\Pages;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;

class FinancialReport extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Laporan Keuangan';

    protected static UnitEnum|string|null $navigationGroup = 'Reports';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.financial-report';

    public string $period = 'this_month';

    public function getReportData(): array
    {
        [$start, $end] = $this->getDateRange();

        $orders = Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Orders by day for the period
        $dailyRevenue = Order::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue, COUNT(*) as order_count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top products
        $topProducts = OrderItem::whereHas('order', function ($q) use ($start, $end) {
                $q->whereBetween('created_at', [$start, $end])->where('status', 'completed');
            })
            ->selectRaw('product_id, SUM(quantity) as total_sold, SUM(subtotal) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->with('product')
            ->get();

        // Order type breakdown
        $dineInCount = $orders->where('order_type', 'dine_in')->count();
        $takeAwayCount = $orders->where('order_type', 'take_away')->count();

        // Payment method breakdown
        $waCount = $orders->where('payment_method', 'whatsapp')->count();
        $qrisCount = $orders->where('payment_method', 'qris')->count();

        // Customer count
        $uniqueCustomers = $orders->pluck('user_id')->filter()->unique()->count();

        return [
            'totalRevenue'    => $totalRevenue,
            'totalOrders'     => $totalOrders,
            'avgOrderValue'   => $avgOrderValue,
            'dailyRevenue'    => $dailyRevenue,
            'topProducts'     => $topProducts,
            'dineInCount'     => $dineInCount,
            'takeAwayCount'   => $takeAwayCount,
            'waCount'         => $waCount,
            'qrisCount'       => $qrisCount,
            'uniqueCustomers' => $uniqueCustomers,
            'start'           => $start,
            'end'             => $end,
        ];
    }

    private function getDateRange(): array
    {
        return match ($this->period) {
            'today'      => [Carbon::today(), Carbon::today()->endOfDay()],
            'this_week'  => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'last_month' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'this_year'  => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            default      => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        };
    }

    public function updatedPeriod(): void
    {
        // Livewire will re-render the view automatically
    }

    public function exportExcel()
    {
        $data = $this->getReportData();

        $csvContent = "Tanggal,Pendapatan,Jumlah Pesanan\n";
        foreach ($data['dailyRevenue'] as $day) {
            $csvContent .= "{$day->date},{$day->revenue},{$day->order_count}\n";
        }
        $csvContent .= "\n\nRingkasan\n";
        $csvContent .= "Total Pendapatan,Rp " . number_format($data['totalRevenue'], 0, ',', '.') . "\n";
        $csvContent .= "Total Pesanan,{$data['totalOrders']}\n";
        $csvContent .= "Rata-rata Pesanan,Rp " . number_format($data['avgOrderValue'], 0, ',', '.') . "\n";
        $csvContent .= "Dine In,{$data['dineInCount']}\n";
        $csvContent .= "Take Away,{$data['takeAwayCount']}\n";

        $csvContent .= "\n\nProduk Terlaris\n";
        $csvContent .= "Produk,Terjual,Pendapatan\n";
        foreach ($data['topProducts'] as $tp) {
            $name = $tp->product ? $tp->product->name : 'Deleted';
            $csvContent .= "{$name},{$tp->total_sold},Rp " . number_format($tp->total_revenue, 0, ',', '.') . "\n";
        }

        $filename = 'laporan_keuangan_' . now()->format('Y-m-d') . '.csv';
        $path = storage_path('app/public/' . $filename);
        file_put_contents($path, $csvContent);

        return response()->download($path, $filename)->deleteFileAfterSend();
    }
}
