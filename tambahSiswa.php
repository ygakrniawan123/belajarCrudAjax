<?php
// Tampilkan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Atur header agar response adalah JSON
header('Content-Type: application/json');

include 'service/config.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari request POST
    $nama = htmlspecialchars($_POST['nama'] ?? '');
    $kelas = htmlspecialchars($_POST['kelas'] ?? '');
    $nisn = htmlspecialchars($_POST['nisn'] ?? '');

    // Cek apakah data tidak kosong
    if (!empty($nama) && !empty($kelas) && !empty($nisn)) {
        // Gunakan variabel yang benar
        $stmt = $conn->prepare("INSERT INTO siswa_ajax (nama, kelas, nisn) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nama, $kelas, $nisn);

        if ($stmt->execute()) {
            $response = ["status" => "success", "id" => $stmt->insert_id];
        } else {
            $response = ["status" => "error", "message" => "Gagal menambahkan data."];
        }
        $stmt->close();
    } else {
        $response = ["status" => "error", "message" => "Semua field harus diisi!"];
    }
} else {
    $response = ["status" => "error", "message" => "Metode tidak valid!"];
}

// Kirim response JSON
echo json_encode($response);
exit;
