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
        Schema::create('sales', function (Blueprint $table) {
            $table->id('sale_id');
            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers', 'customer_id')
                ->onDelete('cascade');
            $table->foreignId('payment_type_id')
                ->nullable()
                ->constrained('payment_types', 'payment_type_id');
         $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'user_id')
                ->onDelete('set null');
            $table->string('sale_code', 8)->unique();
            $table->decimal('total_price_dollars', 10, 2);
            $table->decimal('total_price_bs', 10, 2)->nullable();
            $table->boolean('paid_only_dollars')->default(0)->nullable();
            $table->decimal('total_amount_paid_bs', 10, 2)->nullable();
            $table->decimal('total_profit', 10, 2)->nullable();
            $table->decimal('exchange_rate_bs', 10, 2);
            $table->decimal('only_currencies', 10, 2);
            $table->decimal('savings', 10, 2)->nullable();
            $table->decimal('only_currencies', 10, 2);

            $table->decimal('tax_base', 10, 2);
            $table->integer('VAT');
            $table->decimal('VAT_tax_dollars', 10, 2);
            $table->decimal('credit_tax_dollars', 10, 2);
            $table->integer('discount')->nullable();
            $table->enum('status', ['Pendiente', 'Completada', 'Cancelada', 'Facturada']);
            $table->date('expiration_date')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('credit_rate')->nullable();
            $table->string('slug', 12)->nullable();
            $table->string('slug-name', 12)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
