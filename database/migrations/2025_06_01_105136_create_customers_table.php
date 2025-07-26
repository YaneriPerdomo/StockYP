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
            'customers',
            function (Blueprint $table) {
                $table->id('customer_id');
                $table->foreignId('identity_card_id')
                    ->constrained('identity_cards', 'identity_card_id');
                $table->foreignId('gender_id')
                    ->constrained('genders', 'gender_id');
                     $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
                $table->string('name', 50);
                $table->string('lastname', 50);
                $table->string('card', 13)->unique();
                $table->string('phone', 15)->nullable()->unique();
                $table->string('address', 90)->nullable();
                $table->text('description')->nullable();
                $table->string('slug', 115)->unique();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
