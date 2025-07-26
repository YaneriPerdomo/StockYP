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
        Schema::create('business_data', function (Blueprint $table) {
            $table->id('business_data_id');
            $table->foreignId('identity_card_id')->nullable()
                ->constrained('identity_cards', 'identity_card_id');
            $table->string('name', 40);
            $table->string('rif', 15)->nullable()->unique();
            $table->string('phone', 12)->nullable();
            $table->string('email', 90)->nullable();
            $table->string('address', 120);
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_data');
    }
};
