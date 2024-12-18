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
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable()->change();
            $table->boolean('is_warehouse')->default(false)->after('no_invoice');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->boolean('is_warehouse')->default(false)->after('no_invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('store_id')->nullable(false)->change();
            $table->dropColumn('is_warehouse');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('is_warehouse');
        });
    }
};
