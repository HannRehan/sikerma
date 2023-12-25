<?php
session_start();
include('koneksipengguna.php'); // Sertakan file koneksi database

if (isset($_POST['search'])) {
    $searchText = $_POST['search'];

    //narik email dari user login session
    $userEmail = $_SESSION['email'];
    
    // Tambahkan kondisi WHERE untuk memfilter berdasarkan status "Proses Review"
    $sql = "SELECT * FROM form WHERE (nama_pengusul LIKE '%$searchText%' OR judul LIKE '%$searchText%') AND status = 'Proses Review' AND email_pengusul = '$userEmail'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["nama_pengusul"] . "</td>";
            echo "<td>" . $row["judul"] . "</td>";
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
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#detailModal" . $row["id_usulan"] . "'>Detail</button>
                  </td>";

            echo "</tr>";
        }
    } else {
        echo "No records found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn); // Tutup koneksi database
?>
