<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $table = 'transactions';
    // protected $guarded = ['id'];

    protected $fillable = [
        'customer_id',
        'product_id',
        'category_id',
        'quantity',
        'price',
        'sub_total',
        'payment_type',
        'transaction_date',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            // Hitung sub_total otomatis
            $transaction->sub_total = $transaction->product->price * $transaction->quantity;

            // Kurangi stok produk
            $product = $transaction->product;

            if ($product->stock < $transaction->quantity) {
                throw new \Exception('Stok produk tidak mencukupi.');
            }

            $product->stock -= $transaction->quantity;
            $product->save();
        });

        static::updating(function ($transaction) {
            // Optional: Atur ulang stok jika quantity diubah
            $originalQty = $transaction->getOriginal('quantity');
            $difference = $transaction->quantity - $originalQty;

            $product = $transaction->product;
            $newStock = $product->stock - $difference;

            if ($newStock < 0) {
                throw new \Exception('Stok tidak cukup untuk update transaksi.');
            }

            $product->stock = $newStock;
            $product->save();

            $transaction->sub_total = $product->price * $transaction->quantity;
        });
    }

    public function customer(): BelongsTo
        {
            return $this->belongsTo(Customer::class);
        }

    public function product(): BelongsTo
        {
            return $this->belongsTo(Product::class);
        }
    public function category(): BelongsTo
        {
            return $this->belongsTo(Category::class);
        }
}
