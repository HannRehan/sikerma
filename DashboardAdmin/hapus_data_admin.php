<?php
include('koneksi1.php'); // Sertakan file koneksi database

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID dengan menghindari SQL Injection
    $sql_delete = "DELETE FROM form WHERE id_usulan = ?";
    
    // Persiapkan pernyataan SQL
    $stmt = mysqli_prepare($conn, $sql_delete);
    
    if ($stmt) {
        // Bind parameter ID
        mysqli_stmt_bind_param($stmt, 'i', $id);
        
        // Eksekusi pernyataan SQL
        if (mysqli_stmt_execute($stmt)) {
            // Mengarahkan kembali ke halaman yang sesuai setelah penghapusan berhasil
            $return_url = isset($_GET['return']) ? $_GET['return'] : 'ProsesUsulan.php';
            header("Location: $return_url");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        
        // Tutup pernyataan
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak valid.";
}

mysqli_close($conn); // Tutup koneksi database
?>
