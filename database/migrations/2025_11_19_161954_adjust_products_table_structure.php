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
        Schema::table('products', function (Blueprint $table) {
            // Add timestamps if not exists
            if (!Schema::hasColumn('products', 'created_at')) {
                $table->timestamps();
            }
            
            // Change stok to have default 0
            if (Schema::hasColumn('products', 'stok')) {
                $table->integer('stok')->default(0)->change();
            }
            
            // Ensure foto is string type (not nullable as per requirement)
            if (Schema::hasColumn('products', 'foto')) {
                $table->string('foto')->nullable(false)->change();
            }
            
            // Ensure deskripsi is text type
            if (Schema::hasColumn('products', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->change();
            }
            
            // Ensure harga is decimal
            if (Schema::hasColumn('products', 'harga')) {
                $table->decimal('harga', 10, 2)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove timestamps
            if (Schema::hasColumn('products', 'created_at')) {
                $table->dropTimestamps();
            }
            
            // Revert stok default
            $table->integer('stok')->default(null)->change();
            
            // Revert foto to nullable
            $table->string('foto')->nullable()->change();
        });
    }
};
