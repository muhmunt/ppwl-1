<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Change total column precision from 10,2 to 12,2
            if (Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 12, 2)->change();
            }
            
            // Update enum status_pembayaran
            if (Schema::hasColumn('orders', 'status_pembayaran')) {
                DB::statement("ALTER TABLE orders MODIFY COLUMN status_pembayaran ENUM('pending', 'lunas', 'gagal', 'diproses') DEFAULT 'pending'");
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert total column precision to 10,2
            if (Schema::hasColumn('orders', 'total')) {
                $table->decimal('total', 10, 2)->change();
            }
            
            // Revert enum status_pembayaran
            if (Schema::hasColumn('orders', 'status_pembayaran')) {
                DB::statement("ALTER TABLE orders MODIFY COLUMN status_pembayaran ENUM('pending', 'sukses', 'gagal') DEFAULT 'pending'");
            }
        });
    }
};
