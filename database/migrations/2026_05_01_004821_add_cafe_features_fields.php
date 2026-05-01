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
        // 1. Update Users Table (Already added)
        // Schema::table('users', function (Blueprint $table) {
        //     $table->string('role')->default('customer')->after('email');
        //     $table->integer('loyalty_points')->default(0)->after('role');
        // });

        // 2. Update Orders Table (Already added)
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->string('order_type')->default('take_away')->after('status');
        // });

        // 3. Update Order Items Table for Quantity (Already exists)
        // Schema::table('order_items', function (Blueprint $table) {
        //     $table->integer('quantity')->default(1)->after('price');
        //     $table->decimal('subtotal', 10, 2)->default(0)->after('quantity');
        // });

        // 4. Update Products Table for Discounts
        Schema::table('products', function (Blueprint $table) {
            $table->integer('discount_percentage')->default(0)->after('price');
            $table->timestamp('discount_expires_at')->nullable()->after('discount_percentage');
        });

        // 5. Create Tables Table
        Schema::create('cafe_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('capacity')->default(2);
            $table->string('status')->default('available'); // available, reserved, occupied
            $table->timestamps();
        });

        // 6. Create Reservations Table
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cafe_table_id')->constrained('cafe_tables')->cascadeOnDelete();
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('guest_count')->default(1);
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, rejected, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('cafe_tables');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['discount_percentage', 'discount_expires_at']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'subtotal']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_type');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'loyalty_points']);
        });
    }
};
