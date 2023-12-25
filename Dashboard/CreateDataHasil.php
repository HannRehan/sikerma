<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../assets/css/Template.css">
    <!-- Tautan ke Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Tautan ke Bootstrap JavaScript (jQuery harus disertakan sebelum Bootstrap JS) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	

	<title>Sikerma</title>

	

</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar" >
		<a href="#" class="brand">
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
		<ul class="side-menu">
			
			<li>
				<a href="../Login/Login.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
		<!-- <button class="btn btn-primary" id="sidebarToggle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
</svg>
                        </button> -->
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<!-- <input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label> -->
			<!-- <a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/people.png">
			</a> -->
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Tambah Data Hasil</h1>
					
				</div>
			</div>


			<div class="table-data">
				<div class="order">
					
                    <div class="card">
    <div class="card-body">
    <form action="SimpanPengguna.php" method="POST" onsubmit="return redirectToPengguna()">
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username">
        <span class="text-danger"></span>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control" name="email">
        <span class="text-danger"></span>
    </div>

    <div class="form-check">
        <label>Jenis Kelamin</label>
        <div>
            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
            <label class="form-check-label" for="male">Laki-laki</label>
        </div>
        <div>
            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
            <label class="form-check-label" for="female">Perempuan</label>
        </div>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password">
        <span class="text-danger"></span>
    </div>
    <div class="form-check">
        <label>Role</label>
        <div>
            <input class="form-check-input" type="radio" name="role" id="pengusul" value="pengusul">
            <label class="form-check-label" for="pengusul">Pengusul</label>
        </div>
        <div>
            <input class="form-check-input" type="radio" name="role" id="admin" value="admin">
            <label class="form-check-label" for="admin">Admin</label>
        </div>
    </div>
    <br>
    <input type="submit" class="btn btn-success" name="add">
    <a class="btn btn-danger" href="../Dashboard/HasilUsulan.php">CANCEL</a>
</form>
    </div>
</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script>
    function redirectToPengguna() {
        // Kembalikan true untuk mengizinkan pengiriman formulir dan mengarahkan ke Pengguna.php
        window.location.href = '../Dashboard/HasilUsulan.php';
        return true;
    }

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
</body>
</html>