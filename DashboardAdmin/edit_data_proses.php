<?php
// Periksa apakah ada parameter "id" dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lakukan koneksi ke database
    $conn = mysqli_connect("localhost", "root", "", "sikerma");

    if (!$conn) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    // Lakukan query SQL untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM form WHERE id_usulan = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $judul = $row["judul"];
        $nama_pengusul = $row["nama_pengusul"];
        $lingkup = $row["lingkup"];
    } else {
        echo "Data tidak ditemukan.";
    }

    mysqli_close($conn);
} else {
    echo "ID tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tambahkan stylesheet atau CSS sesuai kebutuhan Anda -->
    <title>Edit Data</title>
</head>
<body>

    <h1>Edit Data</h1>

    <!-- Form untuk mengedit data -->
    <form action="update_data.php" method="POST">
        <input type="hidden" name="id_usulan" value="<?php echo $id; ?>">
        <div>
            <label for="judul">Judul:</label>
            <input type="text" name="judul" value="<?php echo $judul; ?>">
        </div>
        <div>
            <label for="nama_pengusul">Nama Pengusul:</label>
            <input type="text" name="nama_pengusul" value="<?php echo $nama_pengusul; ?>">
        </div>
        <div>
            <label for="lingkup">Ruang Lingkup:</label>
            <input type="text" name="lingkup" value="<?php echo $lingkup; ?>">
        </div>
        <button type="submit">Simpan Perubahan</button>
    </form>

</body>
</html>
