<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class IncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Pendapatan 7 Hari Terakhir';
    
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full'; // Agar grafik chart penuh layarnya 

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        // Loop untuk 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            
            // Hitung total revenue untuk hari ini ($date)
            $dailyRevenue = Order::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
                
            $data[] = $dailyRevenue;
            $labels[] = $date->translatedFormat('d M'); 
        }

        return [
            'datasets' => [
                [
                    'label' => 'Uang Masuk (Rp)',
                    'data' => $data,
                    'backgroundColor' => '#6b3b1a',
                    'borderColor' => '#4b2a12',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
