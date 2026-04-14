<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code')->unique()->nullable()->after('id');
            $table->string('customer_phone')->nullable()->after('customer_name');
            $table->string('payment_method')->nullable()->after('status');
            $table->string('seat_code')->nullable()->after('payment_method');
            $table->text('notes')->nullable()->after('seat_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_code', 'customer_phone', 'payment_method', 'seat_code', 'notes']);
        });
    }
};
