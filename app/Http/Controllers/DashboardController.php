<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailBuku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $counts = [
            'totalJudul' => Buku::all()->count(),
            'totalBuku' => DetailBuku::all()->count(),
            'sisaBuku' => DetailBuku::where('status', 'Tersedia')->count(),
            'bukuDipinjam' => DetailBuku::where('status', 'Tidak Tersedia')->count()
        ];

        return view('pages.dashboard', [
            'counts' => $counts,
            'pinjams' => Peminjaman::where('history', null)->get(),
            'bukus' => Buku::where('stok', '>', 0)
                        ->whereHas('kategori', function ($query) {
                            $query->where('status', 'aktif');
                        })->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
