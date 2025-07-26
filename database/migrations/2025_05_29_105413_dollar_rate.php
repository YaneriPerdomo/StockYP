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
        Schema::create(
            "dollar_rate",
            function (Blueprint $table) {
                $table->id('dollar_rate_id');
                    $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
                $table->decimal('in_bs', 10, 2)->default(0);
                $table->dateTime('last_update')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamps();
            }

        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
