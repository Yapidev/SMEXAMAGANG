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
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->integer('phone_number');
            $table->string('nik');
            $table->enum('kelas', ['XII', 'XI', 'X']);
            $table->enum('jurusan', ['Rekayasa Perangkat Lunak', 'Akuntansi', 'Manajemen Perkantoran', 'Layanan Perbankan', 'Bisnis Digital']);
            $table->string('image');
            $table->foreignId('prakerins_id')->constrained('prakerins');
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
