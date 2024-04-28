<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.user', [
            "users" => User::where('deleted', null)->get()
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
        $validated = $request->validate([
            'no_induk' => 'required|numeric|min:6',
            'nama' => 'required|max:255',
            'email' => 'required|unique:users,email|email',
            'password' => 'required',
            'tempatlahir' => 'required|max:255',
            'tanggallahir' => 'required|date',
            'role' => 'required',
        ]);
        $validated['password'] = Hash::make($request->password);

        User::create($validated);

        return redirect()->back()->with('added', "User {$request->nama} berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'no_induk' => 'required|numeric|min:6',
            'nama' => 'required|max:255',
            'email' => 'required',
            'tempatlahir' => 'required|max:255',
            'tanggallahir' => 'required|date',
            'role' => 'required',
        ]);
        $user->update($validated);

        return redirect()->back()->with('saved', 'User telah di-update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update([
            'deleted' => 1
        ]);
        return redirect()->back()->with('deleted', 'User berhasil dihapus');
    }
}
