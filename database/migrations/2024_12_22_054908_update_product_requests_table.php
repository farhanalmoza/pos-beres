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
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id', 'quantity']);
            $table->enum('status', ['requested', 'done', 'customized'])->default('requested')->change();

            $table->string('request_number')->after('id');
            $table->foreignId('created_by')->after('store_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['request_number', 'created_by']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->change();

            $table->foreignId('product_id')->after('id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->after('store_id')->change();
        });
    }
};
