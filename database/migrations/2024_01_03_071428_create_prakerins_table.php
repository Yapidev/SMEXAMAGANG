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
        Schema::create('prakerins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tempat_prakerin_id')->constrained('tempat_prakerins')->onDelete('restrict')->onUpdate('cascade');         
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['belum_magang','sedang_magang', 'selesai', 'diberhentikan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prakerins');
    }
};
