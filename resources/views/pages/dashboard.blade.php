@extends('layouts.main')
@section('content')
            
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="/history" class="d-none d-sm-inline-block btn btn-sm btn-dark shadow-sm"><i
                                class="fas fa-bookmark mr-2 fa-sm text-white-50"></i> History Peminjaman </a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Judul Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['totalJudul'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Eksemplar</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['totalBuku'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Buku Tersedia
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $counts['sisaBuku'] }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Buku Dipinjam</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['bukuDipinjam'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-address-card fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'pustakawan')
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Buku Tersedia</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable2">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul</th>
                                                <th>Pengarang</th>
                                                <th>Penerbit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bukus as $buku)
                                                
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $buku->judul }}</td>
                                                <td>{{ $buku->pengarang }}</td>
                                                <td>{{ $buku->penerbit }}</td>
                                                <td width="30px">
                                                    <a href="{{ route('buku.show', $buku) }}"
                                                class="btn btn-primary ml-2"><i class="fa fa-info-circle"
                                                    aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Color System -->
                            <div class="row">
                                <a class="col-lg-6 mb-4" href="/peminjaman">
                                    <div class="card bg-primary text-white shadow">
                                        <div class="card-body">
                                            Status Peminjaman
                                            <div class="text-white-50 small">Lihat Status Peminjaman</div>
                                        </div>
                                    </div>
                                </a>
                                <a class="col-lg-6 mb-4" href="/history">
                                    <div class="card bg-success text-white shadow">
                                        <div class="card-body">
                                            History
                                            <div class="text-white-50 small">Lihat Laporan / History Peminjaman</div>
                                        </div>
                                    </div>
                                </a>
                                
                                <style>
                                    a:hover {
                                        text-decoration: none
                                    }
                                </style>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-4">

                            <!-- Illustrations -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Peminjaman Berlangsung</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable3">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Buku</th>
                                                <th>Peminjam</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pinjams as $pinjam)
                                                
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pinjam->buku->judul }}</td>
                                                <td>{{ $pinjam->user->nama }}</td>
                                                <td width="30px">
                                                    <a href="{{ route('peminjaman.show', $pinjam) }}"
                                                class="btn btn-primary ml-2"><i class="fa fa-info-circle"
                                                    aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            

                        </div>
                    </div>
                    @endif

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Pasha 2021-2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

@endsection