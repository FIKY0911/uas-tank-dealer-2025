<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ProductStockOverview extends BaseWidget
{
    protected static ?string $heading = 'Stok Produk';
    protected static ?int $sort = 1;
    protected int|string|array $columnSpan = 'full';

    // ✅ Query utama tabel
    protected function getTableQuery(): Builder
    {
        return Product::query();
    }

    // ✅ Kartu statistik
    protected function getCards(): array
    {
        $query = $this->getFilteredTableQuery();

        return [
            Card::make('Total Produk', (clone $query)->count())
                ->description('Jumlah seluruh produk yang difilter')
                ->color('info')
                ->icon('heroicon-o-cube'),

            Card::make('Total Stok', (clone $query)->sum('stock'))
                ->description('Akumulasi seluruh stok yang difilter')
                ->color('success')
                ->icon('heroicon-o-archive-box'),

            Card::make('Stok Kosong', (clone $query)->where('stock', 0)->count())
                ->description('Produk tanpa stok')
                ->color('danger')
                ->icon('heroicon-o-exclamation-triangle'),
        ];
    }

    // ✅ Kolom tabel
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nama Produk')
                ->searchable()
                ->url(fn(Product $record) => route('filament.admin.resources.products.edit', ['record' => $record]))
                ->openUrlInNewTab(),

            Tables\Columns\TextColumn::make('category.name') // relasi kategori
                ->label('Kategori'),

            Tables\Columns\TextColumn::make('stock')
                ->label('Stok')
                ->formatStateUsing(fn($state) => $state == 0
                    ? 'Stock Kosong'
                    : "{$state} unit")
                ->color(fn($state) => $state == 0 ? 'danger' : 'success')
                ->sortable(),
        ];
    }

    // ✅ Aksi (restock)
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('restock')
                ->label('Restock')
                ->icon('heroicon-o-plus')
                ->form([
                    TextInput::make('amount')
                        ->label('Jumlah Tambahan')
                        ->numeric()
                        ->minValue(1)
                        ->required(),
                ])
                ->action(function (array $data, Product $record): void {
                    $record->increment('stock', $data['amount']);

                    Notification::make()
                        ->title("Stok {$record->name} ditambahkan {$data['amount']} unit")
                        ->success()
                        ->send();
                }),
        ];
    }

    // ✅ Filter (kategori saja)
    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('category_id')
                ->label('Kategori')
                ->options(Category::pluck('name', 'id')->toArray()),
        ];
    }
}
