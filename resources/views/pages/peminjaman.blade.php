@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Peminjaman Berlangsung</h1>


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#add">+ Tambah Peminjaman</button>

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('peminjaman.store') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col">
                                                <label>Buku</label>
                                                <select class="form-control" name="buku_id">
                                                    @foreach ($listBuku as $buku)
                                                        <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label>Peminjam</label>
                                                <select class="form-control" name="user_id">
                                                    @foreach ($listUser as $user)
                                                        <option value="{{ $user->id }}">{{ $user->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="row g-3 mt-3">
                                            <div class="col">
                                                <label>Tanggal Peminjaman</label>
                                                <input type="date" class="form-control" name="tanggal_peminjaman">
                                            </div>
                                        </div> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                </form>
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
                                    <th>Buku</th>
                                    <th>Peminjam</th>
                                    <th>Admin/Pustakawan</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Status</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pinjams as $pinjam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pinjam->buku->judul }}</td>
                                        <td>{{ $pinjam->user->nama }}</td>
                                        <td>{{ $pinjam->admin->nama }}</td>
                                        <td>{{ $pinjam->simple_created_at }}</td>
                                        <td class="text-center"><span class="p-2 badge badge-warning">Dipinjam</span></td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('peminjaman.show', $pinjam) }}"
                                                class="btn btn-primary mx-1"><i class="fa fa-info-circle"
                                                    aria-hidden="true"></i></a>
                                            <form action="{{ route('peminjaman.update', $pinjam) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success mx-1">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </button>
                                            </form>
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
@endsection