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
        Schema::create('credit_rate', function (Blueprint $table) {
            $table->id('credit_rate_id');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
            $table->integer('value')->nullable();
            $table->timestamp('updated_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_rate');
    }
};
