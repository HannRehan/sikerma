<?php
include('koneksipengguna.php'); // Sertakan file koneksi database

if (isset($_POST['search'])) {
    $searchText = $_POST['search'];
    $sql = "SELECT * FROM form WHERE nama_pengusul LIKE '%$searchText%' OR judul LIKE '%$searchText%'";
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
            <button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row["id_usulan"] . "'>Delete</button>
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
