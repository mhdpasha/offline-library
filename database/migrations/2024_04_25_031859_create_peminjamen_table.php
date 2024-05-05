<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('peminjamen', function (Blueprint $table) {
        $table->id();
        $table->foreignId('detail_buku_id')->constrained();
        $table->foreignId('buku_id')->constrained();
        $table->foreignId('user_id')->constrained();
        $table->foreignId('admin_id');
        $table->date('tanggal_peminjaman');
        $table->date('tanggal_pengembalian')->nullable();
        $table->boolean('history')->nullable();
        $table->boolean('deleted')->nullable();
        $table->string('slug')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('peminjamen');
}
};
