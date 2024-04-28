@extends('layouts.main')

@section('content')

<!-- Main Content -->
<div id="content">

    <!-- Begin Page Content -->
    <div class="container-fluid">

       <!-- Page Heading -->
       <h1 class="h3 mb-2 text-gray-800">User</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#add">+ Tambah User</button>

                <!-- Modal -->
                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{ route('user.store') }}" method="POST">
                          @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col">
                                    <label>Nama</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" value="{{ old('nama') }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Nomor Induk</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Nomor Induk" name="no_induk" value="{{ old('no_induk') }}">
                                    </div>
                                </div>
                              </div>
                              <div class="row g-3">
                                <div class="col">
                                    <label>Tempat Lahir</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempatlahir" value="{{ old('tempatlahir') }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Tanggal Lahir</label>
                                    <div class="input-group mb-3">
                                      <input type="date" class="form-control" placeholder="Tanggal Lahir" name="tanggallahir" value="{{ old('tanggallahir') }}">
                                    </div>
                                </div>
                              </div>
                              <div class="row g-3">
                                <div class="col">
                                    <label>Email</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Password</label>
                                    <div class="input-group mb-3">
                                      <input type="text" class="form-control" placeholder="Password" autocomplete="off" name="password" value="{{ old('password') }}">
                                    </div>
                                </div>
                              </div> 
                              <label>Hak Akses</label>
                                <select class="form-control" name="role">
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="pustakawan" {{ old('role') == 'pustakawan' ? 'selected' : '' }}>Pustakawan</option>
                                </select>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary">Save</button>
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
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor Induk</th>
                                <th>TTL</th>
                                <th>Email</th>
                                <th>Akses</th>
                                <th width="30px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach ($users as $user)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->no_induk }}</td>
                            <td>{{ "{$user->tempatlahir}, " }} {{  $user->tanggallahir }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                              @if($user->role == 'admin')
                              <span class="text-white px-3 py-2 badge bg-dark">{{ strtoupper($user->role) }}</span>
                              @elseif($user->role == 'pustakawan')
                              <span class="text-white px-3 py-2 badge bg-secondary">{{ strtoupper($user->role) }}</span>
                              @else
                              <span class="text-dark px-3 py-2 badge bg-light">{{ strtoupper($user->role) }}</span>
                              @endif
                            </td>
                            <td class="d-flex">
                              <button class="btn btn-warning"  data-toggle="modal" data-target="#edit{{ $user->id }}" {{ ($user->role == 'admin') ? 'disabled' : '' }}>
                                <i class="fas fa-fw fa-edit"></i>
                              </button>
                              <form action="{{ route('user.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger mx-2" type="submit" {{ ($user->role == 'admin') ? 'disabled' : '' }}>
                                  <i class="fas fa-fw fa-trash"></i>
                                </button>
                              </form>
                            </td>


                            <!-- Edit -->
                            <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ route('user.update', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                  <div class="modal-body">
                                      <div class="row g-3">
                                          <div class="col">
                                              <label>Nama</label>
                                              <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" value="{{ $user->nama }}">
                                              </div>
                                          </div>
                                          <div class="col">
                                              <label>Nomor Induk</label>
                                              <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Nomor Induk" name="no_induk" value="{{ $user->no_induk }}">
                                              </div>
                                          </div>
                                        </div>
                                        <div class="row g-3">
                                          <div class="col">
                                              <label>Tempat Lahir</label>
                                              <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempatlahir" value="{{ $user->tempatlahir }}">
                                              </div>
                                          </div>
                                          <div class="col">
                                              <label>Tanggal Lahir</label>
                                              <div class="input-group mb-3">
                                                <input type="date" class="form-control" placeholder="Tanggal Lahir" name="tanggallahir" value="{{ $user->tanggallahir }}">
                                              </div>
                                          </div>
                                        </div>
                                        <div class="row g-3">
                                          <div class="col">
                                              <label>Email</label>
                                              <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}">
                                              </div>
                                          </div>
                                          <div class="col">
                                            <label>Hak Akses</label>
                                            <select class="form-control" name="role">
                                                <option value="user" {{ ($user->role == 'user' ? 'selected' : '') }}>User</option>
                                                <option value="pustakawan" {{ ($user->role == 'pustakawan' ? 'selected' : '') }}>Pustakawan</option>
                                            </select>
                                          </div>
                                        </div> 
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                  </div>
                                </form>
                                </div>
                              </div>
                            </div>


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