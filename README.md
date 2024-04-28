---

# USK PREPARATION

This module is designed to facilitate book management in a library setting.

## VIEW

### Admin Template
SB Admin 2

### Blade Engine
**main.blade.php**:
```blade
@include('sidebar')
@include('topbar')
@yield('content')
```

**content.blade.php**:
```blade
@extends('main')
@section('content')
<!-- Your content here -->
@endsection
```

## DATABASE

### Model/Controller
Shortcut: `Ctrl + Shift + P` -> Make:Model

#### Create DB
Create the following tables:
- Kategori
- Buku
- User
- Pinjam
- History (tentative)

#### Relational DB + Migrations Examples

**Buku Model**:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buku extends Model
{
    // Relationships
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
```

**Buku Migration**:
```php
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
        $table->text('uuid');
        $table->integer('stok')->nullable()->default(5);
        $table->timestamps();
    });
}
```

**Kategori Model**:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    // Relationships
    public function buku(): HasMany
    {
        return $this->hasMany(Buku::class);
    }
}
```

**Kategori Migration**:
```php
public function up(): void
{
    Schema::create('kategoris', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->timestamps();
    });
}
```

### Relational Structures

1. **Kategori**: hasMany `Buku`
2. **Buku**: belongsTo `Kategori` && hasMany `Pinjam`
3. **User**: hasMany `Pinjam`
4. **Pinjam**: belongsTo `Buku` && belongsTo `User`

## CRUDS

### Create
```php
// Controller method
public function store(StoreBukuRequest $request)
{
    $validated = $request->validate([
        'judul' => 'required',
        'pengarang' => 'required',
        'penerbit' => 'required',
        'kategori_id' => 'required',
        'deskripsi' => 'required',
        'image' => 'exclude',
        'stok' => 'exclude'
    ]);
    $validated['uuid'] = Str::orderedUuid();
    Buku::create($validated);

    return redirect()->back()->with('added', 'Buku berhasil ditambahkan');
}
```

### Read
```php
// Controller method
public function index()
{
    return view('daftar-buku', [
        'data' => Buku::with('kategori')->get(),
        'select' => Kategori::all()
    ]);
}
```

### Update
```php
// Controller method
public function update(UpdateBukuRequest $request, Buku $buku)
{
    $buku->update($request->all());
    return redirect()->back()->with('saved', 'Buku berhasil di-update');
}
```

### Delete
```php
// Controller method
public function destroy(Buku $buku)
{
    $buku->delete();
    return redirect()->back()->with('deleted', "Buku {$buku->judul} telah dihapus");
}
```

### Show
```php
// Controller method
public function show(Buku $buku)
{
    return view('pinjam-show', ['buku' => $buku]);
}
```

## Authentication/Authorization

### AuthController
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.index');
    }

    public function auth(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with(
            'loginErr', 'The provided credentials do not match our records.',
        );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
```

### Authorization

**Make Role Middleware**:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        abort(401);
    }
}

```

**Kernel.php**:
```php
'role' => \App\Http\Middleware\Role::class
```

**Middleware Usage**:
```php
Route::middleware(['auth','role:pustakawan,admin'])->group(function () {
    Route::resource('buku', BukuController::class);

        Route::middleware(['auth','role:admin'])->group(function () {   

        });
});
```

## Database Seeder

### DatabaseSeeder.php
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            BukuSeeder::class
        ]);
    }
}
```

### UserSeeder.php
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Muhamad Pasha Albara',
                'email' => 'pashaalbara01@gmail.com',
                'password' => Hash::make('pasha'),
                'phone' => '085777511106',
                'location' => 'Jl. Nangka no. 18',
                'about_me' => 'I code things',
                'pustakawan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Muhamad Hanafi',
                'email' => 'napi@gmail.com',
                'password' => Hash::make('pasha'),
                'phone' => '085777511106',
                'location' => 'Jl. Nanas no. 12',
                'about_me' => 'Aku wibu',
                'pustakawan' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]

            ]);
    }
}
```

Or just use normal `User::create([]);

---

This README.md provides an overview of the module structure, database setup, CRUD operations, authentication, authorization, and database seeding. Feel free to use it as a reference or note.
