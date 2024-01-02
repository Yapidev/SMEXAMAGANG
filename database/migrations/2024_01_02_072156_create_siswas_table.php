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
        Schema::create('siswas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('image');
            $table->string('phone_number');
            $table->string('nik');
            $table->enum('kelas', ['XII', 'XI', 'X']);
            $table->enum('jurusan', ['RPL', 'AK', 'MP', 'LP', 'BD']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
