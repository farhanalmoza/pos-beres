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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('nik')->unique();
            $table->string('name');
            $table->string('born_place');
            $table->date('born_date');
            $table->string('gender');
            $table->text('address');
            $table->enum('blood_type', ['a', 'b', 'ab', 'o'])->nullable();
            $table->string('religion');
            $table->boolean('is_married')->default(false);
            $table->string('profession')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
