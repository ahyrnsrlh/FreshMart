<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'cancelled'])->default('pending')->after('total_price');
            $table->enum('payment_method', ['transfer_bank', 'cash', 'e_wallet'])->nullable()->after('payment_status');
            $table->string('payment_proof')->nullable()->after('payment_method');
            $table->text('payment_notes')->nullable()->after('payment_proof');
            $table->timestamp('payment_date')->nullable()->after('payment_notes');
            $table->enum('order_status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending')->after('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_method', 
                'payment_proof',
                'payment_notes',
                'payment_date',
                'order_status'
            ]);
        });
    }
};
