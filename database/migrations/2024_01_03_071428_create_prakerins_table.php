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

            $table->uuid('siswas_id');
            $table->uuid('tempat_prakerins_id');
            $table->uuid('pembimbings_id');

            $table->foreign('siswas_id')->references('id')->on('siswas');
            $table->foreign('tempat_prakerins_id')->references('id')->on('tempat_prakerins');
            $table->foreign('pembimbings_id')->references('id')->on('pembimbings');

            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['sedang_magang', 'selesai']);
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
