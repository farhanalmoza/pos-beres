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
        Schema::table('product_out', function (Blueprint $table) {
            $table->integer('total_price')->default(0)->after('quantity');
            $table->integer('ppn')->default(0)->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_out', function (Blueprint $table) {
            $table->dropColumn('total_price');
            $table->dropColumn('ppn');
        });
    }
};
