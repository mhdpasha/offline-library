<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Peminjaman extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getSimpleCreatedAtAttribute()
    {
        return $this->created_at->translatedFormat('j / F / Y');
    }

    public function getDetailedCreatedAtAttribute()
    {
        return $this->created_at->translatedFormat('l, j F Y; h:i a');
    }

    public function getTanggalPengembalianAttribute($attribute)
    {
        if(!$attribute) {
            return '-';
        }

        return Carbon::parse($attribute)->translatedFormat('j / F / Y');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detail(): BelongsTo
    {
        return $this->belongsTo(DetailBuku::class);
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }
}
