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
        Schema::table('product_in', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->after('id')->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_in', function (Blueprint $table) {
            $table->dropForeign('product_in_supplier_id_foreign');
            $table->dropColumn('supplier_id');
        });
    }
};