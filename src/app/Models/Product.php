<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'stock',
        'image',
        'active',
    ];

    public function isStockAvailable(int $quantity): bool
        {
            return $this->stock >= $quantity;
        }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions(): hasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
