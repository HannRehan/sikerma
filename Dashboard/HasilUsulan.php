<?php
session_start();
// Check if user is not logged in
if (!isset($_SESSION['log']) || $_SESSION['log'] != 'Logged') {
    header("Location: ../Login/Login.php");
    exit();
}
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "sikerma");

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Tentukan jumlah data per halaman
$per_page = 5;

// Hitung total data
$total_data = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM form WHERE status = 'Diterima' OR status = 'Ditolak'"));

// Hitung jumlah halaman
$total_pages = ceil($total_data / $per_page);

// Tentukan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Hitung offset untuk query SQL
$offset = ($current_page - 1) * $per_page;

// Ambil data sesuai dengan halaman dan batasan
$sql = "SELECT * FROM form WHERE status = 'Diterima' OR status = 'Ditolak' LIMIT $per_page OFFSET $offset";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

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

	<title>Hasil Usulan</title>
	<style>
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination a {
            padding: 5px;
            margin: 5px;
            border: 1px solid #ddd;
            color: #007bff;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #ddd;
        }

        .pagination .active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
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
				<a href="../Dashboard/Index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../Dashboard/Index.Pengajuan.php">
					<i class='bx bx-bar-chart-alt-2'></i>
					<span class="text">Usulan Baru</span>
				</a>
			</li>
			<li>
				<a href="../Dashboard/ProsesUsulan.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Proses Usulan</span>
				</a>
			</li>
			<li class="active">
				<a href="../Dashboard/HasilUsulan.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Hasil Usulan</span>
				</a>
			</li>
			<li>
				<a href="../Dashboard/Pengguna.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Pengguna</span>
				</a>
			</li>
		</ul>
		<!-- <ul class="side-menu">
			<li>
				<a href="../Login/Login.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul> -->
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
					
					<h1>Hasil Usulan</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Hasil Usulan</a>
						</li>
					</ul>
					<!-- <a href="../Dashboard/CreateDataHasil.php" class="btn-download">
					<i class='bx bx-plus' ></i>
					<span class="text">Create</span>
				</a> -->
				</div>
				
			</div>

			<ul class="box-info">
			</ul>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Hasil Usulan</h3>
						<div class="search">
        <input type="text" id="searchInput" placeholder="Cari Data...">
        <i class='bx bx-search'></i>
    </div>
						
					</div>

					<table>
    <thead>
        <tr>
            <th style="width: 5%">NO</th>
            <th style="width: 30%">Judul</th>
            <th style="width: 15%">Mitra</th>
            <th style="width: 30%">R.Lingkup</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
    </thead>
	<?php
if (mysqli_num_rows($result) > 0) {
    $nomor_urut = $offset + 1; // Inisialisasi nomor urut

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $nomor_urut . "</td>"; // Tampilkan nomor urut
        echo "<td>" . $row["judul"] . "</td>";
        echo "<td>" . $row["lembaga_mitra"] . "</td>";
        if(!$row['lingkup']){
            echo "<td>" . $row["lainnya"] . "</td>";
        } else {
            echo "<td>" . $row["lingkup"] . "</td>";
        }
        
        $status = $row["status"];
        $color = "blue"; // Warna default (abu-abu) jika tidak sesuai kondisi di bawah

        if ($status == "Diterima") {
            $color = "green";
        } elseif ($status == "Ditolak") {
            $color = "red";
        }

        echo "<td style='color: $color;'>" . $status . "</td>";
        echo "<td>
                <a href='unduh_file.php?id=" . $row["id_usulan"] . "' class='btn btn-primary'>Unduh</a>
              </td>";
        echo "</tr>";

        $nomor_urut++; // Tambahkan nomor urut untuk baris berikutnya
    }
} else {
    echo "No records found.";
}

// Tampilkan link halaman
echo "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='?page=$i'>$i</a>";
}
echo "</div>";
?>
</table>



				</div>
			</div>
			
			
					
				
				
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script>
    

    // Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', function () {
    const switchMode = document.getElementById('switch-mode');

    // Fungsi untuk mengubah status mode gelap dan menyimpannya di penyimpanan lokal
    function toggleDarkMode() {
        if (switchMode.checked) {
            document.body.classList.add('dark');
            localStorage.setItem('darkMode', 'dark'); // Simpan status mode gelap
        } else {
            document.body.classList.remove('dark');
            localStorage.setItem('darkMode', 'light'); // Simpan status mode terang
        }
    }

    // Saat tombol switch mode diubah
    switchMode.addEventListener('change', toggleDarkMode);

    // Periksa status mode gelap yang tersimpan di penyimpanan lokal saat halaman dimuat
    const storedMode = localStorage.getItem('darkMode');

    if (storedMode === 'dark') {
        switchMode.checked = true;
        document.body.classList.add('dark');
    } else {
        switchMode.checked = false;
        document.body.classList.remove('dark');
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
            url: "search_data_hasil.php",
            data: { search: searchText },
            success: function (response) {
                $(".table-data table tbody").html(response);

                // Perbarui paginasi untuk hasil pencarian
                $.ajax({
                    type: "POST",
                    url: "search_pagination.php", // Ganti dengan file yang menangani paginasi hasil pencarian
                    data: { search: searchText },
                    success: function (pagination) {
                        $(".pagination").html(pagination);
                    }
                });
            }
        });
    });
});

</script>


</body>
</html>