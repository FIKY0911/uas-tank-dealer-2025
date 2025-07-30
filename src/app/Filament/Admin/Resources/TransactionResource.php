<?php

namespace App\Filament\Admin\Resources;

use App\Enums\PaymentTransaction;
use App\Enums\StatusTransaction;
use App\Filament\Admin\Resources\TransactionResource\Pages;
use App\Filament\Admin\Resources\TransactionResource\RelationManagers;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required()
                    ->reactive(), // <- ini penting!
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->options(function (callable $get) {
                        $categoryId = $get('category_id');
                        if (!$categoryId) {
                            return [];
                        }
                    
                        return \App\Models\Product::where('category_id', $categoryId)
                            ->pluck('name', 'id');
                    })
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Reset subtotal saat produk berubah
                        $product = \App\Models\Product::find($state);
                        $set('price', $product?->price ?? 0);
                    }),
                Forms\Components\TextInput::make('quantity')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $productId = $get('product_id');
                        $product = Product::find($productId);
                        $set('sub_total', ($product?->price ?? 0) * $state);
                    })
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('sub_total')
                    ->label('Sub Total')
                    ->disabled()
                    ->dehydrated()
                    ->numeric(),
                Forms\Components\Select::make('payment_type')
                    ->options(collect(PaymentTransaction::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray())
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(collect(StatusTransaction::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray())
                    ->default('pending')
                    ->required(),
                Forms\Components\DatePicker::make('transaction_date')
                        ->default(now())
                        ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('product.image')
                    ->label('Image')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sub_total')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_type'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
