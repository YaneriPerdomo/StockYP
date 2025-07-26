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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id('supplier_id');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
            $table->foreignId('gender_id')->constrained('genders', 'gender_id');
            $table->foreignId('identity_card_id')->nullable()
                ->constrained('identity_cards', 'identity_card_id');
            $table->string('name', 90)->unique();
            $table->string('card', 13)->nullable()->unique();
            $table->string('telephone_number', 20)->nullable()->unique();
            $table->string('address', 120)->nullable();
            $table->string('slug', 90)->unique();
            $table->boolean('state')->default(1);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
