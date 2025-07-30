<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
