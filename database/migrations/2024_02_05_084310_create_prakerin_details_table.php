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
        Schema::create('prakerin_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('siswa_id')->constrained('siswas')->cascade('onDelete')->cascade('onUpdate');
            $table->foreignUuid('prakerin_id')->constrained('prakerins')->cascade('onDelete')->cascade('onUpdate');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['sedang_magang', 'selesai_magang', 'diberhentikan'])->default('sedang_magang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prakerin_details');
    }
};
