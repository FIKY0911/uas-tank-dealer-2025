<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Product;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TotalProductStat extends BaseWidget
{
    protected ?string $heading = 'Statistik Produk';

    protected function getCards(): array
    {
        $productQuery = Product::query();
        $categoryQuery = Category::query();

        return [
            // Total Produk
            Card::make('Total Produk', $productQuery->count())
                ->description('Jumlah seluruh produk')
                ->color('info')
                ->icon('heroicon-o-cube')
                ->url(route('filament.admin.resources.products.index')),

            // Total Stok
            Card::make('Total Stok', $productQuery->sum('stock'))
                ->description('Akumulasi stok semua produk')
                ->color('success')
                ->icon('heroicon-o-archive-box')
                ->url(route('filament.admin.resources.products.index')),

            // Stok Kosong
            Card::make('Stok Kosong', $productQuery->where('stock', 0)->count())
                ->description('Klik untuk lihat produk habis')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle')
                ->url(route('filament.admin.resources.products.index', [
                    'tableFilters' => [
                        'Stok Kosong' => true,
                    ],
                ])),

            // Total Kategori
            Card::make('Total Kategori', $categoryQuery->count())
                ->description('Jumlah kategori produk')
                ->color('warning')
                ->icon('heroicon-o-tag')
                ->url(route('filament.admin.resources.categories.index')),
        ];
    }
}
