<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()
                ->constrained('suppliers', 'supplier_id')->onDelete('set null');
            $table->foreignId('category_id')
                ->constrained('categorys', 'category_id')->onDelete('cascade');
            $table->foreignId('brand_id')
                ->constrained('brands', 'brand_id')->onDelete('cascade');
            $table->foreignId('location_id')->nullable()
                ->constrained('locations', 'location_id')->onDelete('set null');
            $table->string('name', 90);
            $table->string('code', 90)->unique();
            $table->decimal('price_dollar', 10, 2)
                ->default(0.00)
                ->comment('Precio del producto en dólares pero ten en cuenta que al momento de la venta será en bolívares su monto principal');

            $table->integer('sale_profit_percentage')->default(0);
            $table->integer('discount_only_dollar')->nullable();
            $table->integer('stock_available')->default(0);
            $table->text('description')->nullable();
            $table->string('slug', 90)->unique();
            $table->enum('state', ['Para la venta', 'Pendiente de precio', 'En baja']);
            $table->string('slug_name', 90)->unique();
            $table->string('slug_search', 90)->nullable()->unique();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
