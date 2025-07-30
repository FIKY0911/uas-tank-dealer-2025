<?php

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class);
            $table->foreignIdFor(Product::class);
            $table->foreignIdFor(Category::class);
            $table->integer('quantity');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('sub_total');
            $table->enum('payment_type', ['bca', 'bri', 'mandiri', 'cash']);
            $table->date('transaction_date')->default(DB::raw('CURRENT_DATE'));
            $table->enum('status', ['pending', 'success', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
