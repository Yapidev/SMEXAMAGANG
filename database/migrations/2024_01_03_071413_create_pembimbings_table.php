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
        Schema::create('pembimbings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tempat_prakerins_id')->constrained();
            $table->string('name');
            $table->string('image')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->enum('jurusan', ['RPL', 'AK', 'MP', 'LP', 'BD']);
            $table->text('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembimbings');
    }
};
