@extends('layouts.main')

@section('content')
    <!-- Main Content -->
    <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">History Peminjaman</h1>


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    User : {{ auth()->user()->nama }} [ <b> {{ auth()->user()->role }} </b> ]
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable{{ auth()->user()->role == 'user' ? '2' : '' }}"
                            width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10px">No</th>
                                    <th>Buku</th>
                                    <th>Peminjam</th>
                                    <th>Admin/Pustakawan</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    @if (auth()->user()->role == 'user')
                                    @else
                                        <th width="100px">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $pinjam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pinjam->buku->judul }}</td>
                                        <td>{{ $pinjam->user->nama }}</td>
                                        <td>{{ $pinjam->admin->nama }}</td>
                                        <td>{{ $pinjam->simple_created_at }}</td>
                                        <td>{{ $pinjam->tanggal_pengembalian }}
                                        </td>
                                        <td class="text-center"><span
                                                class="p-2 badge badge-{{ $pinjam->history ? 'success' : 'warning' }}">{{ $pinjam->history ? 'Dikembalikan' : 'Dipinjam' }}</span>
                                        </td>
                                        @if (auth()->user()->role == 'user')
                                        @else
                                            <td class="d-flex justify-content-center align-items-center">
                                                <a href="{{ route('peminjaman.show', $pinjam) }}"
                                                    class="btn btn-primary mx-1"><i class="fa fa-info-circle"
                                                        aria-hidden="true"></i></a>
                                                <form action="{{ route('peminjaman.destroy', $pinjam) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger mx-1" {{ $pinjam->history ? '' : 'disabled' }}>
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
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
            top: 74px;
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