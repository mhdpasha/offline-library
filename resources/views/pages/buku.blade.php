@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Buku</h1>


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#add">+ Tambah Buku</button>

                    <!-- Modal -->
                    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Buku</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('buku.store') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col">
                                                <label>Judul</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Judul buku"
                                                        autocomplete="off" name="judul" value="{{ old('judul') }}">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label>Pengarang</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Nama pengarang"
                                                        autocomplete="off" name="pengarang" value="{{ old('pengarang') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <label>Penerbit</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Nama penerbit"
                                                autocomplete="off" name="penerbit" value="{{ old('penerbit') }}">
                                        </div>
                                        <label>Kategori / Genre</label>
                                        <select class="form-control" name="kategori_id">
                                            @foreach ($select as $kategori)
                                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                            @endforeach
                                        </select>
                                        <label>Deskripsi</label>
                                        <div class="form-floating">
                                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px" autocomplete="off" name="deskripsi">{{ old('deskripsi') }}</textarea>
                                        </div>
                                        <label>Cover Buku (opsional)</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="CDN atau Link"
                                                autocomplete="off" name="image" value="{{ old('image') }}">
                                        </div>
                                        <label>Stok Tersedia</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" placeholder="5" autocomplete="off"
                                                name="stok" value="5">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Pengarsipan</th>
                                    <th>Total Stok</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukus as $buku)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $buku->judul }}</td>
                                        <td>{{ $buku->kategori->nama }}</td>
                                        <td>{{ $buku->pengarang }}</td>
                                        <td>{{ $buku->created_at }}</td>
                                        <td>{{ $buku->stok }}</td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('buku.show', $buku) }}" class="btn btn-primary"><i
                                                    class="fa fa-info-circle" aria-hidden="true"></i></a>
                                            <button data-toggle="modal" data-target="#edit{{ $buku->id }}"
                                                class="btn btn-warning mx-2"><i class="fa fa-edit"
                                                    aria-hidden="true"></i></button>
                                            <form action="{{ route('buku.destroy', $buku) }}" method="POST" id="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>

                                            {{-- Modal Delete --}}
                                            <div class="modal fade" id="confirmationModal">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <h5 class="mb-3">Delete buku? Pastikan buku tidak ada di record Peminjaman.</h5>
                                                            <div class="row justify-content-evenly">
                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-danger w-100" id="confirmButton">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="edit{{ $buku->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Kategori
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('buku.update', $buku) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="row g-3">
                                                                    <div class="col">
                                                                        <label>Judul</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Judul buku"
                                                                                autocomplete="off" name="judul"
                                                                                value="{{ $buku->judul }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label>Pengarang</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="Nama pengarang"
                                                                                autocomplete="off" name="pengarang"
                                                                                value="{{ $buku->pengarang }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <label>Penerbit</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Nama penerbit" autocomplete="off"
                                                                        name="penerbit" value="{{ $buku->penerbit }}">
                                                                </div>
                                                                <label>Kategori / Genre</label>
                                                                <select class="form-control" name="kategori_id">
                                                                    @foreach ($select as $kategori)
                                                                        <option value="{{ $kategori->id }}"
                                                                            {{ $kategori->id == $buku->kategori->id ? 'selected' : '' }}>
                                                                            {{ $kategori->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <label>Deskripsi</label>
                                                                <div class="form-floating">
                                                                    <textarea class="form-control" id="floatingTextarea2" style="height: 100px" autocomplete="off" name="deskripsi">{{ $buku->deskripsi }}</textarea>
                                                                </div>
                                                                <label>Cover Buku (opsional)</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="CDN atau Link" autocomplete="off"
                                                                        name="image" value="{{ $buku->image }}">
                                                                </div>
                                                                <label>Stok Tersedia </label>
                                                                <div class="input-group mb-3">
                                                                    <input type="number" class="form-control"
                                                                        placeholder="5" autocomplete="off" name="stok"
                                                                        value="{{ $buku->stok }}">
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert"
                                data-dismiss="alert" style="cursor: pointer;">
                                <h4><strong>Field belum terisi :</strong></h4>
                                <ul style="list-style-type: >">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif (session()->has('added'))
                            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert"
                                data-dismiss="alert" style="cursor: pointer;">
                                <strong class="d-flex items-center justify-content-center">
                                    {{ session('added') }}
                                </strong>
                            </div>
                        @elseif (session()->has('saved'))
                            <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert"
                                data-dismiss="alert" style="cursor: pointer;">
                                <strong class="d-flex items-center justify-content-center">
                                    {{ session('saved') }}
                                </strong>
                            </div>
                        @elseif (session()->has('deleted'))
                            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert"
                                data-dismiss="alert" style="cursor: pointer;">
                                <strong class="d-flex items-center justify-content-center">
                                    {{ session('deleted') }}
                                </strong>
                            </div>
                        @endif



                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <style>
        .dt-button {
            border: none;
            margin-top: 20px;
            border-radius: 20px;
            padding: 10px 20px;
        }

        .dt-button-collection button {
            transition: 0.3s ease;
            position: absolute;
            color: white;
            background: #adb5bd;
            top: 88px;
        }

        .dt-button-collection button:hover {
            background: #6c757d;
        }

        .dt-button-collection button:nth-child(1) {
            left: 400px
        }

        .dt-button-collection button:nth-child(2) {
            left: 505px
        }

        .dt-button-collection button:nth-child(3) {
            left: 610px
        }

        .dt-button-collection button:nth-child(4) {
            left: 715px
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm('Yakin delete? pastikan tidak ada di record peminjaman')
        }
    </script>
@endsection