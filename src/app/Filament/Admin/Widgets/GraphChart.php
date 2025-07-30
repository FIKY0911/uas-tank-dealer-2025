<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class GraphChart extends ChartWidget
{
    protected static ?string $heading = 'Garis Produk & Transaksi per Kategori';

    // ⏱️ Auto-refresh setiap 10 detik
    protected static ?string $pollingInterval = '10s';

    protected function getData(): array
    {
        $productData = Product::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get()
            ->map(fn ($item) => [
                'category' => $item->category->name ?? 'Unknown',
                'total' => $item->total,
            ]);

        $transactionData = Transaction::select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get()
            ->map(fn ($item) => [
                'category' => $item->category->name ?? 'Unknown',
                'total' => $item->total,
            ]);

        $categories = $productData->pluck('category')->merge($transactionData->pluck('category'))->unique()->values();

        $productCounts = $categories->map(fn ($cat) => $productData->firstWhere('category', $cat)['total'] ?? 0);
        $transactionCounts = $categories->map(fn ($cat) => $transactionData->firstWhere('category', $cat)['total'] ?? 0);

        return [
            'datasets' => [
                [
                    'label' => 'Produk',
                    'data' => $productCounts,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Transaksi',
                    'data' => $transactionCounts,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $categories,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
