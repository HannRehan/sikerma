<?php
session_start();
// Check if user is not logged in
if (!isset($_SESSION['log']) || $_SESSION['log'] != 'Logged') {
    header("Location: ../Login/Login.php");
    exit();
}
// Koneksi ke database MySQL
$koneksi = mysqli_connect("localhost", "root", "", "sikerma");

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Fungsi untuk menghitung jumlah data berdasarkan tingkat
function hitungJumlahData($koneksi, $tingkat) {
    $query = "SELECT COUNT(*) as total FROM form WHERE tingkat = '$tingkat'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0;
    }
}

// Hitung jumlah data untuk setiap tingkat
$jumlahInternasional = hitungJumlahData($koneksi, 'Internasional');
$jumlahNasional = hitungJumlahData($koneksi, 'Nasional');
$jumlahLokal = hitungJumlahData($koneksi, 'Lokal');
$totalData = $jumlahInternasional + $jumlahNasional + $jumlahLokal;
// Hitung persentase untuk setiap tingkat
$persentaseInternasional = round(($jumlahInternasional / $totalData) * 100);
$persentaseNasional = round(($jumlahNasional / $totalData) * 100);
$persentaseLokal = round(($jumlahLokal / $totalData) * 100);

// Pastikan total persentase tidak melebihi 100
$totalPersentase = $persentaseInternasional + $persentaseNasional + $persentaseLokal;

if ($totalPersentase > 100) {
    // Kurangi persentase yang paling besar agar total menjadi 100
    $maxPersentase = max($persentaseInternasional, $persentaseNasional, $persentaseLokal);

    if ($maxPersentase === $persentaseInternasional) {
        $persentaseInternasional -= ($totalPersentase - 100);
    } elseif ($maxPersentase === $persentaseNasional) {
        $persentaseNasional -= ($totalPersentase - 100);
    } elseif ($maxPersentase === $persentaseLokal) {
        $persentaseLokal -= ($totalPersentase - 100);
    }
}

// Format persentase sebagai string dengan tanda persen
$persentaseInternasionalString = number_format($persentaseInternasional) . '%';
$persentaseNasionalString = number_format($persentaseNasional) . '%';
$persentaseLokalString = number_format($persentaseLokal) . '%';



// Tutup koneksi database
mysqli_close($koneksi);
?>

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Contoh PHP dan MySQL</title>
</head>
<body>
    <span class="text">
        <h3 id="penggunacount"><?php echo $jumlah_data; ?></h3>
        <p>Pengguna</p>
    </span>
</body>
</html> -->



<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../assets/css/Template.css">

	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<!-- Tautan ke Bootstrap JavaScript (jQuery harus disertakan sebelum Bootstrap JS) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

	<title>Sikerma</title>

    <style>
        body {
            background-color: #eee;
        }
    </style>
	

</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar" >
		<a  class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">SIKERMA</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="../Dashboard/index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../../Sikerma/Dashboard/Index.Pengajuan.php">
					<i class='bx bx-bar-chart-alt-2'></i>
					<span class="text">Usulan Baru</span>
				</a>
			</li>
			<li>
				<a href="../../Sikerma/Dashboard/ProsesUsulan.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Proses Usulan</span>
				</a>
			</li>
			<li>
				<a href="../../Sikerma/Dashboard/HasilUsulan.php">
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
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<!-- <a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a> -->
			</div>

			<ul class="box-info">
    <li>
	<i class='bx bx-globe'></i>
        <span class="text">
            <h3><?php echo $jumlahInternasional; ?></h3>
            <p>Internasional</p>
        </span>
    </li>
    <li>
	<i class='bx bx-flag'></i>
        <span class="text">
            <h3><?php echo $jumlahNasional; ?></h3>
            <p>Nasional</p>
        </span>
    </li>
    <li>
	<i class='bx bx-buildings'></i>
        <span class="text">
            <h3><?php echo $jumlahLokal; ?></h3>
            <p>Lokal</p>
        </span>
    </li>
</ul>


			<div class="table-data">
				<div class="order">
				<section id="pricing" class="pricing pt-0">
      <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-header" style="margin-left: 10%;">
          
          <h2>Statistik Kerjasama</h2>
          <h2 style="margin-left: 50%; margin-top: -5%;">Statistik Persen Kerjasama</h2>

        </div>

        <div class="row gy-4">
    <div class="col-lg-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" id="chart-container">
        <canvas id="myChart" width="500" height="500"></canvas>
    </div>

    <div class="col-lg-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" id="chart-container2">
        <canvas id="myChart2" width="500" height="500"></canvas>
    </div>
</div>

<script>
// Dapatkan elemen canvas pertama
var ctx = document.getElementById("myChart").getContext('2d');

// Membuat grafik lingkaran pertama
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Internasional", "Nasional", "Lokal"],
        datasets: [{
            label: '',
            data: [
                <?php echo $jumlahInternasional; ?>,
                <?php echo $jumlahNasional; ?>,
                <?php echo $jumlahLokal; ?>
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(205, 206, 86, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(71, 62, 210, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

// Dapatkan elemen canvas kedua
var ctx2 = document.getElementById("myChart2").getContext('2d');

// Membuat grafik lingkaran kedua
var myChart2 = new Chart(ctx2, {
    type: 'pie',
    data: {
    labels: ["Internasional", "Nasional", "Lokal"],
    datasets: [{
        label: '',
        data: [
            <?php echo $persentaseInternasional;  ?>,
            <?php echo $persentaseNasional; ?>,
            <?php echo $persentaseLokal; ?>
        ],
        backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(205, 206, 86, 0.2)',
            'rgba(255, 99, 132, 0.2)'
        ],
        borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(71, 62, 210, 1)',
            'rgba(255,99,132,1)'
        ],
        borderWidth: 1
    }]
},
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

</script>

</script>   


      
    </section>


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







</script>
	<script src="/assets/js/scripts.js"></script>
	<script>
// Data yang akan digunakan dalam grafik lingkaran
var data = {
    labels: ['Internasional', 'Nasional', 'Lokal'],
    datasets: [{
        data: [<?php echo $jumlahInternasional; ?>, <?php echo $jumlahNasional; ?>, <?php echo $jumlahLokal; ?>],
        backgroundColor: ['#FF5733', '#33FF57', '#5733FF'], // Warna untuk setiap bagian grafik
    }]
};

// Mengambil elemen canvas dengan id "myPieChart"
var ctx = document.getElementById('myPieChart').getContext('2d');

// Membuat grafik lingkaran
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
        // Tambahkan opsi lain sesuai kebutuhan Anda
    }
});
</script>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

</body>
</html>