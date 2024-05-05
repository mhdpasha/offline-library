<?php

namespace App\Traits;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait GenerateSlug
{
    public function generateSlug($slug = null)
    {
        if($slug)
        {
            return Str::slug($slug);
        }
        
        do {
            $slug = Str::upper(bin2hex(random_bytes(3)));

            $exists = DB::table('peminjamen')
                        ->where('slug', $slug)
                        ->exists();

        } while ($exists);

        return $slug;
    }
}
