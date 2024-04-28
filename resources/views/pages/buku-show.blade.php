<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Arsene Library</title>

    <link rel="icon" href="https://raw.githubusercontent.com/mhdpasha/arsene-library-master/main/public/assets/img/arsene-lib-logo-white.png">

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

        <a id="back" class="btn btn-dark" href="{{ URL::previous() }}">
            < </a>
                <a href="{{ $buku->image }}">
                    <img src="{{ $buku->image }}" alt="cover" height="auto" width="530px">
                </a>
                <div>
                    <h1>{{ $buku->judul }} <box-icon name='badge-check' type='solid' color='#292b2c'></box-icon></h1>

                    <p style="max-width: 400px" id="descriptionParagraph">{{ Str::limit($buku->deskripsi, 150) }}</p>

                    <h5>Detail Buku</h5>
                    <ul>
                        <li>Kategori : <span class="p-2 badge bg-{{ $buku->kategori->status == 'aktif' ? 'success' : 'danger' }}">{{ $buku->kategori->kode }}</span></li>
                        <li>Pengarang : {{ $buku->pengarang }} </li>
                        <li>Penerbit : {{ $buku->penerbit }} </li>
                    </ul>

                    <h5>Detail Stok</h5>
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Buku</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stok as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->serial_num }}</td>
                                    <td>
                                        @if ($detail->status == 'Tersedia')
                                            <span class="p-2 badge bg-dark">Tersedia</span>
                                        @else
                                            <span class="p-2 badge bg-secondary">Tidak Tersedia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        width: 450px;
        border-radius: 20px;
    }

    p:hover {
        cursor: pointer;
    }

    #dataTable:hover {
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let descriptionParagraph = document.getElementById('descriptionParagraph')
        let fullDescription = "{{ $buku->deskripsi }}"
        let isTruncated = true
        
        descriptionParagraph.addEventListener('click', function() {
            if (isTruncated) {
                this.textContent = fullDescription
            } else {
                this.textContent = "{{ Str::limit($buku->deskripsi, 150) }}"
            }
            
            isTruncated = !isTruncated
        })

        let tableRows = document.querySelectorAll("#dataTable tbody tr")
        let numRowsToShow = 5
        let showAll = false

        function toggleRows() {
            for (let i = 0; i < tableRows.length; i++) {
                if (i >= numRowsToShow && !showAll) {
                    tableRows[i].style.display = "none"
                } else {
                    tableRows[i].style.display = ""
                }
            }
        }
        toggleRows()

        document.getElementById("dataTable").addEventListener("click", function() {
            showAll = !showAll;
            toggleRows()
        })
    })
    
</script>
    
    

</html>