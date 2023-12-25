<?php
session_start();
include('koneksipengguna.php'); // Sertakan file koneksi database

//narik email dari user login session
$userEmail = $_SESSION['email'];

if (isset($_POST['search'])) {
    $searchText = $_POST['search'];
    $sql = "SELECT * FROM form 
            WHERE (nama_pengusul LIKE '%$searchText%' OR judul LIKE '%$searchText%' OR lembaga_mitra LIKE '%$searchText%') 
            AND (status = 'Diterima' OR status = 'Ditolak') AND email_pengusul = '$userEmail'
            ORDER BY CAST(id_usulan AS SIGNED)"; // Use CAST to treat id_usulan as an integer
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $nomor_urut = 1; // Inisialisasi nomor urut

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $nomor_urut . "</td>"; // Tampilkan nomor urut  
            echo "<td>" . $row["judul"] . "</td>";
            echo "<td>" . $row["lembaga_mitra"] . "</td>";
            echo "<td>" . $row["lingkup"] . "</td>";

            $status = $row["status"];
            $color = "blue"; // Warna default (abu-abu) jika tidak sesuai kondisi di bawah

            if ($status == "Diterima") {
                $color = "green";
            } elseif ($status == "Ditolak") {
                $color = "red";
            }

            echo "<td style='color: $color;'>" . $row["status"] . "</td>";
            echo "<td>
                <a href='unduh_data.php?id=" . $row["id_usulan"] . "' class='btn btn-primary'>Unduh</a>
            </td>";
            echo "</tr>";
            $nomor_urut++; // Tambahkan nomor urut untuk baris berikutnya
        }
    } else {
        echo "Tidak ada data yang sesuai.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn); // Tutup koneksi database
?>