<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Arsene Library</title>

    <link rel="icon" href="../img/arsene-lib-logo-white.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

</head>

<body>
    <main class="d-flex justify-content-center align-items-center w-100 h-100 gap-5 mt-5">

        <a id="back" class="btn btn-dark" href="{{ route('peminjaman.index') }}">
            < </a>
                <a href="{{ route('buku.show', $pinjam->buku) }}">
                    <img src="{{ $pinjam->buku->image }}" alt="cover" height="auto" width="530px">
                </a>
                <div>
                    <h1>{{ $pinjam->buku->judul }} <box-icon name='badge-check' type='solid'
                            color='#292b2c'></box-icon></h1>

                    <p style="max-width: 400px" id="desc">{{ Str::limit($pinjam->buku->deskripsi, 150) }}</p>

                    <h5>Detail Peminjaman</h5>
                    <ul>
                        <li>Status : <span
                                class="p-2 badge bg-{{ $pinjam->history ? 'success' : 'warning' }}">{{ $pinjam->history ? 'Dikembalikan' : 'Dipinjam' }}</span>
                        </li>
                        <li>Peminjam : <b>{{ "{$pinjam->user->nama} [ {$pinjam->user->no_induk} ]" }} </b></li>
                        <li>Penerima : <b>{{ "{$pinjam->admin->nama} [ {$pinjam->admin->role} ]" }}</b> </li>
                    </ul>

                    <h5>Detail Buku</h5>
                    <ul>
                        <li>Kategori : <span
                                class="p-2 badge bg-{{ $pinjam->buku->kategori->status == 'aktif' ? 'success' : 'danger' }}">{{ $pinjam->buku->kategori->kode }}</span>
                        </li>
                        <li>Pengarang : {{ $pinjam->buku->pengarang }} </li>
                        <li>Penerbit : {{ $pinjam->buku->penerbit }} </li>
                        <li>Stok tersisa: {{ $pinjam->buku->stok }} </li>
                    </ul>

                    @if($pinjam->history)

                    @else
                    <h5>Lama Peminjaman: </h5>
                    <h4><span class="font-weight-bold">{{ $days }} Hari </span><span id="lamaPeminjaman" class="ml-3">{{ $hours }} Jam {{ $minutes }} Menit {{ $seconds }} Detik</span></h4>

                    <ul>
                        <li>Entri Peminjaman : {{ $pinjam->detailed_created_at }} </li>
                    </ul>
                    @endif

                </div>
    </main>
</body>

<style>
    #back {
        display: flex;
        height: 200px;
        align-items: center;
        transition: 0.3s ease;
    }

    li {
        list-style-type: "- ";
    }

    img {
        aspect-ratio: 3/4;
        object-fit: cover;
        width: 420px;
        border-radius: 20px;
    }

    img:hover {
        translateX: 10px
    }

    p:hover {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let desc = document.getElementById('desc')
        let fullDesc = "{{ $pinjam->buku->deskripsi }}"
        let isTruncated = true
        
        desc.addEventListener('click', function() {
            if (isTruncated) {
                this.textContent = fullDesc
            } else {
                this.textContent = "{{ Str::limit($pinjam->buku->deskripsi, 150) }}"
            }
            
            isTruncated = !isTruncated
        });

        const createdAt = '{{ $createdAt }}'
        const creationTime = new Date(createdAt)
        
        let lamaPeminjaman = document.getElementById('lamaPeminjaman')
        
        const timer = () => {
            const now = new Date()
            
            const totalSeconds = Math.floor((now - creationTime) / 1000)
            
            let hours = Math.floor(totalSeconds / 3600)
            let minutes = Math.floor((totalSeconds % 3600) / 60)
            let seconds = totalSeconds % 60
            
            lamaPeminjaman.textContent = `${hours} Jam ${minutes} Menit ${seconds} Detik`
        }
        
        setInterval(timer, 1000)
    })
</script>
</html>
