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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamp('waktu_masuk')->nullable(); 
           // $table->timestamp('waktu_keluar')->nullable(); 
            $table->string('foto_pagar_depan')->nullable(); 
            $table->string('foto_pagar_belakang')->nullable(); 
            $table->string('foto_lorong_lab')->nullable(); 
            $table->string('foto_ruang_tengah')->nullable(); 
            $table->decimal('latitude', 10, 8)->nullable(); 
            $table->decimal('longitude', 11, 8)->nullable(); 
            $table->enum('status', ['belum diverifikasi', 'diverifikasi', 'tidak valid'])->default('belum diverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
