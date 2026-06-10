<?php
function write_log($pesan, $level = 'INFO')
{
    $lokasi_file = 'info/info.log';
    $waktu = date('Y-m-d H:i:s');

    // Format teks log: [WAKTU] [LEVEL] Pesan
    $format_log = "[$waktu] [$level] $pesan" . PHP_EOL;

    // Tulis ke file (FILE_APPEND agar teks baru tidak menghapus teks lama)
    file_put_contents($lokasi_file, $format_log, FILE_APPEND);
}

// Cara penggunaan:
write_log("Aplikasi berhasil dijalankan.");
write_log("Gagal memuat file konfigurasi!", "ERROR");
