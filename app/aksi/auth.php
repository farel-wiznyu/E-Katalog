<?php
include "../log/aksi_log.php";
include 'koneksi.php';

// Mencegah SQL Injection
$nip_nis = mysqli_real_escape_string($koneksi, $_POST['nip_nisn']);
$plain_password = $_POST['password'];
$password = md5($plain_password);

// Perbaikan 1: Query difilter menggunakan WHERE nip_nis
$query = "SELECT p.id, p.nip_nis, p.nama, p.telepon, p.role, pw.password 
          FROM tb_pengguna_v2 p 
          INNER JOIN tb_password pw ON p.nip_nis = pw.nip_nis 
          WHERE p.nip_nis = '$nip_nis'";
$result = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil dan ada data user yang cocok dengan NIP/NIS tersebut
if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_array($result);

    // Periksa apakah password cocok
    if ($data["password"] == $password && $data["nip_nis"] == $nip_nis) {
        // Perbaikan 2: Log "berhasil" diletakkan setelah password terkonfirmasi benar
        write_log("Login Berhasil Di Lakukan Oleh $nip_nis");

        // Perbaikan 3: Hapus spasi pada Location:
        header("Location: ../dashboard_pengguna.php");
        exit;
    } else {
        write_log("Login Gagal (Password Salah) Di Lakukan Oleh $nip_nis");
        // Perbaikan 4: Redirect ke nama file yang benar
        header("Location: ../page_login.php");
        exit;
    }
} else {
    // Jika NIP/NIS tidak ditemukan sama sekali di database
    write_log("Login Gagal (NIP/NISN Tidak Ditemukan) Di Lakukan Oleh $nip_nis");
    header("Location: ../page_login.php");
    exit;
}
?>