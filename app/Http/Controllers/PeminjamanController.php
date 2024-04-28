<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\DetailBuku;
use App\Models\Peminjaman;
use App\Http\Requests\StorePeminjamanRequest;
use App\Http\Requests\UpdatePeminjamanRequest;
use Illuminate\Support\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('pages.peminjaman', [
            'pinjams' => Peminjaman::where('history', null)->get(),
            'listBuku' => Buku::where('stok', '>', 0)
                            ->whereHas('kategori', function ($query) {
                                $query->where('status', 'aktif');
                            })
                            ->withCount(['detail as stok' => function ($query) {
                                $query->where('status', 'Tersedia');
                            }])
                            ->having('stok', '>', 0)
                            ->get(),
            'listUser' => User::where('role', 'user')->where('deleted', null)->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(StorePeminjamanRequest $request)
    {
        $validated = $request->validated();
        $validated['admin_id'] = auth()->user()->id;
        $validated['detail_buku_id'] = $request->buku_id;
        $validated['tanggal_peminjaman'] = Carbon::now();

        Peminjaman::create($validated);

        $detailBuku = DetailBuku::where('buku_id', $request->buku_id)
                                ->where('status', 'Tersedia')
                                ->first();
        $detailBuku->update(['status' => 'Tidak Tersedia']);

        return redirect()->back()->with('added', 'Peminjaman berhasil ditambahkan');
    }

    public function show(Peminjaman $peminjaman)
    {
        $createdAt = $peminjaman->created_at;
        
        $now = Carbon::now();
        $totalSeconds = $createdAt->diffInSeconds($now);
        
        $days = floor($totalSeconds / (3600 * 24));
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;
        
        return view('pages.peminjaman-show', [
            'pinjam' => $peminjaman,
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'createdAt' => $createdAt 
        ]);
    }

    public function edit(Peminjaman $peminjaman)
    {
        //
    }             

    public function update(UpdatePeminjamanRequest $request, Peminjaman $peminjaman)
    {
        $detailBuku = DetailBuku::where('buku_id', $peminjaman->buku->id)
                                ->where('status', 'Tidak Tersedia')
                                ->first();
        $detailBuku->update(['status' => 'Tersedia']);

        $peminjaman->update([
            'history' => 1,
            'tanggal_pengembalian' => Carbon::now(),
        ]);

        return redirect()->back()->with('saved', "Peminjaman {$peminjaman->user->nama} telah selesai");
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->back()->with('deleted', 'Data arsip berhasil dihapus');
    }

    public function history()
    {
        $user = (auth()->user()->role == "user") ? 'user' : '';

        if ($user) {
            $data = Peminjaman::where('user_id', auth()->user()->id)
                                ->orderBy('id', 'desc')
                                ->get();
        } else {
            $data = Peminjaman::all();
        }

        return view('pages.history', [
            'data' => $data,
        ]);
    }
}
