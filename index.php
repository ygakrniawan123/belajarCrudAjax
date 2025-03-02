<?php
include 'service/config.php';


?>




<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(45deg, #1a1a1a, #2d2d2d);
            color: #fff;
            font-family: Arial, sans-serif;
            height: 500vh;
        }

        .alert {
            transition: 3s;
        }

        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #212529, #000000);
            padding: 20px;
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.3);
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px;
            margin: 8px 0;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 1.2em;
        }

        .sidebar a:hover {
            background: linear-gradient(90deg, #343a40, #212529);
            border-left: 3px solid #605678;
            transform: translateX(5px);
        }

        .content {
            height: 500vh;
            width: max;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: max;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-warning {
            color: #212529;
        }

        .modal-content {
            background: #343a40;
            color: #fff;
        }

        .modal-content .form-control {
            background: #212529;
            color: #fff;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">

                <h3 class="light mb-4 fw-bold">Admin Panel</h3>
                <a href="menu-admin.php"><i class="bi bi-palette"></i>Kelola Menu </a>
                <a href="user-admin.php"><i class="bi bi-person"></i> Kelola User</a>
                <a href="../login.php"><i class="bi bi-box-arrow-right"></i> Keluar</a>
            </div>


            <!-- Main Content -->
            <div class="col-md-10 content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-light fw-bold">Manajemen Data Siswa</h2>
                    <div class="d-flex gap-3">
                        <!-- tombol untuk searching -->
                        <!-- <form action="" method="GET">
              <input type="text" name="cari-data" class="btn btn-outline-warning text-light" size="15">
              <button class="btn btn-warning  text-light" type="submit">Cari</button>
            </form> -->
                        <!-- tombol untuk menambahkan data -->
                        <button class="btn btn-warning text-light fw-bold" data-bs-toggle="modal" data-bs-target="#addFilmModal">
                            <i class="bi bi-plus"></i> </button>
                    </div>
                </div>

                <!-- menu Table -->
                <div class="card">
                    <div class="card-header bg-secondary text-light fw-bold">
                        <i class="bi bi-table me-2"></i> Daftar siswa
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Nama</th>
                                    <th>kelas</th>
                                    <th>Nisn</th>
                                    <th class="text-start">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="dataSiswa">
                                <!--  data akan di isi dari ajax -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add menu Modal -->
                <div class="modal fade" id="addFilmModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-warning">Tambah Data Baru</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data" id="formTambah">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kelas</label>
                                        <input type="textt" name="kelas" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nisn</label>
                                        <input type="text" name="nisn" class="form-control">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-warning text-light fw-bold">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- main js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "GetSiswa.php",
        dataType: "json", // Pastikan menerima data JSON
        success: function(result){
            $.each(result, function(key, val){
                let TableSiswa = $("<tr></tr>"); // Buat elemen baris baru
                TableSiswa.html(`
                    <td>${val.id}</td>
                    <td>${val.nama}</td>
                    <td>${val.kelas}</td>
                    <td>${val.nisn}</td>
                `);
                $("#dataSiswa").append(TableSiswa); // Tambahkan ke tabel
            });
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });

    $("#formTambah").submit(function(e){
        e.preventDefault(); // Mencegah reload halaman

        let nama = $("[name='nama']").val();
        let kelas = $("[name='kelas']").val();
        let nisn = $("[name='nisn']").val();

        $.ajax({
            type: "POST",
            url: "tambahSiswa.php",
            data: { nama: nama, kelas: kelas, nisn: nisn },
            dataType: "json",
            success: function(response){
                if(response.status === "success"){
                    let newRow = `<tr>
                        <td>${response.id}</td>
                        <td>${nama}</td>
                        <td>${kelas}</td>
                        <td>${nisn}</td>
                    </tr>`;

                    $("#dataSiswa").append(newRow);
                    $("#formTambah")[0].reset(); // Reset form
                    alert("Data berhasil ditambahkan! cuy");
                } else {
                    alert("Gagal menambahkan data!");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });
});
</script>
    <!-- main js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>