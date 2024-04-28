<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->onDelete('cascade');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
            $table->text('serial_num');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_bukus');
    }
};
