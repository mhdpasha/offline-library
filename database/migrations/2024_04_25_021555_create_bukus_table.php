<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained();
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->text('deskripsi');
            $table->text('image')->nullable()->default('https://cdn3d.iconscout.com/3d/premium/thumb/book-5596349-4665465.png');
            $table->integer('stok')->nullable()->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
