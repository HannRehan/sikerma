<?php
session_start();
// Check if user is not logged in
if (!isset($_SESSION['log']) || $_SESSION['log'] != 'Logged') {
    header("Location: ../Login/Login.php");
    exit();
}
// Koneksi ke database (sesuaikan dengan pengaturan Anda)
$conn = mysqli_connect("localhost", "root", "", "sikerma");

// Periksa koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Query SQL untuk mengambil data yang memiliki status "Proses Review"
$sql = "SELECT * FROM form WHERE status = 'Proses Review'";
$result = mysqli_query($conn, $sql);

// Tutup koneksi
mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../assets/css/Template.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">

	<title>Proses Usulan</title>
</head>
<body >


	<!-- SIDEBAR -->
	<section id="sidebar" >
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">SIKERMA</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="../DashboardAdmin/index_admin.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../DashboardAdmin/index.Pengajuan.admin.php">
					<i class='bx bx-bar-chart-alt-2'></i>
					<span class="text">Usulan Baru</span>
				</a>
			</li>
			<li>
				<a href="../DashboardAdmin/ProsesUsulanAdmin.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Proses Usulan</span>
				</a>
			</li>
			<li>
				<a href="../DashboardAdmin/HasilUsulanAdmin.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Hasil Usulan</span>
				</a>
			</li>
			
		</ul>
		<ul class="side-menu">
			
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Tambahkan kelas ml-auto untuk memindahkan ke pojok kanan -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php
                if (isset($_SESSION['log']) && $_SESSION['log'] == 'Logged') {
                    echo 'Selamat Datang, ' . $_SESSION['username'];
                } else {
                    echo 'Dropdown link';
                }
                ?>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <?php
                if (isset($_SESSION['log']) && $_SESSION['log'] == 'Logged') {
                    
                    
                    echo '<a class="dropdown-item" href="../Login/logout.php">Logout</a>';
                } else {
                    echo '<a class="dropdown-item" href="../Login/Login.php">Login</a>';
                }
                ?>
            </div>
        </li>
    </ul>
</nav>
<!-- endnavbar -->
		<!-- MAIN -->
		<main class="main" style="background-color: #e9ecef">
			<div class="head-title">
				<div class="left">
					
					<h1>Proses Usulan</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Proses Usulan</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
			</ul>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<a href="../DashboardAdmin/export_excel_Admin.php" class="btn-download">
							<i class='bx bxs-cloud-download' ></i>
							<span class="text">Export</span>
				</a>
						<div class="search">
        <input type="text" id="searchInput" placeholder="Cari Data Pengusul...">
        <i class='bx bx-search'></i>
    </div>
						
					</div>

					<table>
        <thead>
            <tr>
            <th style="width: 15%">Nama Pengusul</th>
                <th style="width: 30%" >Judul Kerja Sama</th>
                <th style="width: 20%">Ruang Lingkup</th>
                <th style="width: 20%">Status</th>
                <th style="width: 25%">Action</th>
            </tr>
        </thead>
        <?php
        include('koneksi1.php'); // Sertakan file koneksi database

        // Gunakan hasil query yang telah diperbarui
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

            echo "<td style='color: $color;'>" . $status . "</td>";

            echo "<td>
            <button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row["id_usulan"] . "'>Delete</button>
            <a href='update_status_admin.php?id=" . $row["id_usulan"] . "' class='btn btn-primary'>Edit</a>
        </td>";
            echo "</tr>";
            echo "<div class='modal fade' id='deleteModal" . $row["id_usulan"] . "' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel" . $row["id_usulan"] . "'>";
            echo "<div class='modal-dialog' role='document'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='deleteModalLabel" . $row["id_usulan"] . "'>Konfirmasi Hapus</h5>";
            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
            echo "<span aria-hidden='true'>&times;</span>";
            echo "</button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "Apakah Anda yakin ingin menghapus data ini?";
            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Batal</button>";
            // Tambahkan URL yang sesuai untuk menghapus data pada tautan berikut
            echo "<a href='hapus_data_admin.php?id=" . $row["id_usulan"] . "&return=ProsesUsulanAdmin.php' class='btn btn-danger'>Hapus</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }

        mysqli_close($conn); // Tutup koneksi database
        ?>
    </table>
			
			
					
				
				
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script>
    

    // Wait for the DOM to fully load
	document.addEventListener('DOMContentLoaded', function () {
    const switchMode = document.getElementById('switch-mode');

    function toggleDarkMode() {
        const body = document.body;
        const sidebar = document.getElementById('sidebar');

        if (switchMode.checked) {
            body.classList.add('dark');
            sidebar.classList.add('dark');
            localStorage.setItem('darkMode', 'dark');
        } else {
            body.classList.remove('dark');
            sidebar.classList.remove('dark');
            localStorage.setItem('darkMode', 'light');
        }
    }

    switchMode.addEventListener('change', toggleDarkMode);

    const storedMode = localStorage.getItem('darkMode');

    if (storedMode === 'dark') {
        switchMode.checked = true;
        document.body.classList.add('dark');
        document.getElementById('sidebar').classList.add('dark');
    } else {
        switchMode.checked = false;
        document.body.classList.remove('dark');
        document.getElementById('sidebar').classList.remove('dark');
    }
});


    // Dapatkan URL halaman saat ini
const currentLocation = window.location.href;

// Dapatkan semua tautan dalam sidebar
const sidebarLinks = document.querySelectorAll('.side-menu a');

// Loop melalui tautan dan bandingkan dengan URL saat ini
sidebarLinks.forEach(link => {
    if (link.href === currentLocation) {
        link.parentNode.classList.add('active'); // Tambahkan class "active" pada elemen li yang berisi tautan aktif
    }
});
<!-- Tautan ke Bootstrap JavaScript (jQuery harus disertakan sebelum Bootstrap JS) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</script>
	<script src="/assets/js/scripts.js"></script>
    <script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var searchText = $(this).val();
            $.ajax({
                type: "POST",
                url: "search_data_admin.php", // Ganti dengan nama file yang akan menangani pencarian
                data: { search: searchText },
                success: function (response) {
                    $(".table-data table tbody").html(response);
                }
            });
        });
    });
</script>


</body>
</html>