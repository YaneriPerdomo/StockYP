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
        Schema::create('return_merchandise_details', function (Blueprint $table) {
            $table->id('return_merchandise_details_id');
            $table->foreignId('return_merchandise_id')
                ->constrained('return_merchandise', 'return_merchandise_id')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->onDelete('cascade');
            $table->unsignedInteger('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_merchandise_details');
    }
};
