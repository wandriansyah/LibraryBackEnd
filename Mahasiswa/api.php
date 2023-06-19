<?php
// File: api.php

header('Content-Type: application/json');

// Menghubungkan ke database
$host = 'localhost';
$username = 'admin';
$password = '123';
$database = 'library';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Menambahkan buku baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'insert_buku') {
    $data = json_decode(file_get_contents('php://input'), true);
    $kode = $data['kode'];
    $kode_kategori = $data['kode_kategori'];
    $judul = $data['judul'];
    $pengarang = $data['pengarang'];
    $penerbit = $data['penerbit'];
    $tahun = $data['tahun'];
    $tanggal_input = $data['tanggal_input'];
    $harga = $data['harga'];
    $file_cover = $data['file_cover'];

    $sql = "INSERT INTO buku (kode, kode_kategori, judul, pengarang, penerbit, tahun, tanggal_input, harga, file_cover) VALUES ('$kode', '$kode_kategori', '$judul', '$pengarang', '$penerbit', $tahun, '$tanggal_input', $harga, '$file_cover')";

    if ($conn->query($sql) === true) {
        $response = array('status' => 'success', 'message' => 'Buku berhasil ditambahkan');
    } else {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error);
    }

    echo json_encode($response);
}

// Memperbarui buku berdasarkan kode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'update_buku') {
    $data = json_decode(file_get_contents('php://input'), true);
    $kode = $data['kode'];
    $kode_kategori = $data['kode_kategori'];
    $judul = $data['judul'];
    $pengarang = $data['pengarang'];
    $penerbit = $data['penerbit'];
    $tahun = $data['tahun'];
    $tanggal_input = $data['tanggal_input'];
    $harga = $data['harga'];
    $file_cover = $data['file_cover'];

    $sql = "UPDATE buku SET kode_kategori = '$kode_kategori', judul = '$judul', pengarang = '$pengarang', penerbit = '$penerbit', tahun = $tahun, tanggal_input = '$tanggal_input', harga = $harga, file_cover = '$file_cover' WHERE kode = '$kode'";

    if ($conn->query($sql) === true) {
        $response = array('status' => 'success', 'message' => 'Buku berhasil diperbarui');
    } else {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error);
    }

    echo json_encode($response);
}

// Menghapus buku berdasarkan kode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete_buku') {
    $data = json_decode(file_get_contents('php://input'), true);
    $kode = $data['kode'];

    $sql = "DELETE FROM buku WHERE kode = '$kode'";

    if ($conn->query($sql) === true) {
        $response = array('status' => 'success', 'message' => 'Buku berhasil dihapus');
    } else {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error);
    }

    echo json_encode($response);
}

// Mengambil semua data buku
if ($_GET['action'] === 'select_all_buku') {
    $sql = "SELECT * FROM buku";
    $result = $conn->query($sql);

    $buku = array();
    while ($row = $result->fetch_assoc()) {
        $buku[] = $row;
    }

    echo json_encode($buku);
}

// Mengambil data buku berdasarkan kode
if ($_GET['action'] === 'select_buku_by_kode') {
    $kode = $_GET['kode'];

    $sql = "SELECT * FROM buku WHERE kode = '$kode'";
    $result = $conn->query($sql);

    $buku = $result->fetch_assoc();

    echo json_encode($buku);
}

// Menambahkan kategori baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'insert_kategori') {
    $data = json_decode(file_get_contents('php://input'), true);
    $kode = $data['kode'];
    $kategori = $data['kategori'];

    $sql = "INSERT INTO kategori (kode, kategori) VALUES ('$kode', '$kategori')";

    if ($conn->query($sql) === true) {
        $response = array('status' => 'success', 'message' => 'Kategori berhasil ditambahkan');
    } else {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error);
    }

    echo json_encode($response);
}

// Memperbarui kategori berdasarkan kode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'update_kategori') {
    $data = json_decode(file_get_contents('php://input'), true);
    $kode = $data['kode'];
    $kategori = $data['kategori'];

    $sql = "UPDATE kategori SET kategori = '$kategori' WHERE kode = '$kode'";

    if ($conn->query($sql) === true) {
        $response = array('status' => 'success', 'message' => 'Kategori berhasil diperbarui');
    } else {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error);
    }

    echo json_encode($response);
}

// Menghapus kategori berdasarkan kode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'delete_kategori') {
    $data = json_decode(file_get_contents('php://input'), true);
    $kode = $data['kode'];

    $sql = "DELETE FROM kategori WHERE kode = '$kode'";

    if ($conn->query($sql) === true) {
        $response = array('status' => 'success', 'message' => 'Kategori berhasil dihapus');
    } else {
        $response = array('status' => 'error', 'message' => 'Terjadi kesalahan: ' . $conn->error);
    }

    echo json_encode($response);
}

// Mengambil semua data kategori
if ($_GET['action'] === 'select_all_kategori') {
    $sql = "SELECT * FROM kategori";
    $result = $conn->query($sql);

    $kategori = array();
    while ($row = $result->fetch_assoc()) {
        $kategori[] = $row;
    }

    echo json_encode($kategori);
}

// Mengambil data kategori berdasarkan kode
if ($_GET['action'] === 'select_kategori_by_kode') {
    $kode = $_GET['kode'];

    $sql = "SELECT * FROM kategori WHERE kode = '$kode'";
    $result = $conn->query($sql);

    $kategori = $result->fetch_assoc();

    echo json_encode($kategori);
}

$conn->close();
?>
