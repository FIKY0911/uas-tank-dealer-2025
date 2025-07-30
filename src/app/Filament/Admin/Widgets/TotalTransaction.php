<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class TotalTransaction extends BaseWidget
{
    protected static ?int $sort = 0; // Urutan tampil pertama
    protected ?string $heading = 'Statistik Transaksi';

    protected function getCards(): array
    {
        $query = Transaction::query();

        return [
            Card::make('Total Transaksi', $query->count())
                ->description('Jumlah seluruh transaksi produk')
                ->color('info')
                ->icon('heroicon-o-banknotes')
                ->url(route('filament.admin.resources.transactions.index')), // Buat bisa diklik
        ];
    }
}
