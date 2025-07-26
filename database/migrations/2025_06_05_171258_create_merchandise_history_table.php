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
        Schema::create('merchandise_history', function (Blueprint $table) {
            $table->id('merchandise_history_id');
            $table->foreignId('return_merchandise_id')
                ->nullable()
                ->constrained('return_merchandise', 'return_merchandise_id')
                ->onDelete('cascade');
            $table->foreignId('good_id')
                ->nullable()
                ->constrained('goods', 'good_id')
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
        Schema::dropIfExists('merchandise_history');
    }
};
