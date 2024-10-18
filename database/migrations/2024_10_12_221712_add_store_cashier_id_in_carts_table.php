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
            $table->foreignId('store_id')->after('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->after('store_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign('carts_store_id_foreign');
            $table->dropColumn('store_id');
            $table->dropForeign('carts_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};
