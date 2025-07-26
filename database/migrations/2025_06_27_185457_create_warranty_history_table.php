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
        Schema::create('warranty_history', function (Blueprint $table) {
            $table->id('warranty_history_id');
            $table->foreignId('sale_id')
                ->nullable()
                ->constrained('sales', 'sale_id')
                ->onDelete('cascade');
            $table->text('message');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_history');
    }
};
