<?php
include('koneksi1.php'); // Sertakan file koneksi database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $sql_delete = "DELETE FROM user WHERE id = $id";

    if (mysqli_query($conn, $sql_delete)) {
        // Mengarahkan kembali ke Pengguna.php setelah penghapusan berhasil
        $return_url = isset($_GET['return']) ? $_GET['return'] : 'Pengguna.php';
        header("Location: $return_url");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak valid.";
}

mysqli_close($conn); // Tutup koneksi database
?>
