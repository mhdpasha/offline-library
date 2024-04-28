<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\DetailBuku;
use App\Models\Peminjaman;
use Illuminate\Support\Str;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;

class BukuController extends Controller
{
    public function index()
    {
        return view('pages.buku', [
            'bukus' => Buku::with('kategori')->get(),
            'select' => Kategori::all(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StoreBukuRequest $request)
    {
        $validated = $request->validated();
        $validated['image'] = $request->image ?: 'https://cdn3d.iconscout.com/3d/premium/thumb/book-5596349-4665465.png';

        $buku = Buku::create($validated);
        $stok = $validated['stok'];
        $serial = strtoupper(str_replace(' ', '-', $validated['judul']));

        for ($i = 0; $i < $stok; $i++) {
            DetailBuku::create([
                'buku_id' => $buku->id,
                'status' => 'Tersedia',
                'serial_num' => "AR-BOOK-{$serial}-" . $i+1
            ]);
        }

        return redirect()->back()->with('added', "Buku {$request->judul} berhasil ditambahkan");
    }

    public function show(Buku $buku)
    {
        $stok = DetailBuku::where('buku_id', $buku->id)->get();

        return view('pages.buku-show', [
            'buku' => $buku,
            'stok' => $stok,
        ]);
    }

    public function edit(Buku $buku)
    {
        //
    }

    public function update(UpdateBukuRequest $request, Buku $buku)
    {
        $validated = $request->validated();
        $validated['image'] = $request->image ?: 'https://cdn3d.iconscout.com/3d/premium/thumb/book-5596349-4665465.png';

        $buku->update($validated);
        $stok = DetailBuku::where('buku_id', $buku->id)->count();
        $serial = strtoupper(str_replace(' ', '-', $validated['judul']));

        if ($request->stok > $stok) {
            $surplus = $request->stok - $stok;
            for ($i = 0; $i < $surplus; $i++) {
                DetailBuku::create([
                    'buku_id' => $buku->id,
                    'status' => 'Tersedia',
                    'serial_num' => "AR-BOOK-{$serial}-" . ($stok+$i+1)
                ]);
            }

            return redirect()->back()->with('saved', 'Buku berhasil di-update, Stok telah ditambah');

        } elseif ($request->stok == $stok) {
            return redirect()->back()->with('saved', 'Buku berhasil di-update');
            
        } else {
            $surplus = $stok - $request->stok;
            $details = DetailBuku::where('buku_id', $buku->id)->orderBy('id', 'desc')->limit($surplus)->get();

            foreach ($details as $detail) {
                $detail->delete();
            }

            return redirect()->back()->with('saved', 'Buku berhasil di-update, Stok telah dikurangi');
        }
    }

    public function destroy(Buku $buku)
    {
        $recordPinjam = Peminjaman::where('buku_id', $buku->id)->exists();

        if($recordPinjam) {
            return redirect()->back()->with('deleted', 'Buku masih tercatat di record Peminjaman !');
        }

        $buku->delete();

        $detail = DetailBuku::where('buku_id', $buku->id)->get();
        foreach ($detail as $buku) {
            $buku->delete();
        }

        return redirect()->back()->with('deleted', 'Buku telah di-delete');
    }
}
