

<?php
$koneksi = mysqli_connect("localhost", "root", "", "sikerma");
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>