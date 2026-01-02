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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'alamat')) {
                $table->text('alamat')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'telepon')) {
                $table->string('telepon', 20)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('orders', 'metode')) {
                $table->string('metode')->nullable()->after('telepon');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'alamat')) {
                $table->dropColumn('alamat');
            }
            if (Schema::hasColumn('orders', 'telepon')) {
                $table->dropColumn('telepon');
            }
            if (Schema::hasColumn('orders', 'metode')) {
                $table->dropColumn('metode');
            }
        });
    }
};
