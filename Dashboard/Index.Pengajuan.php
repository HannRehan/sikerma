<?php
session_start();
//narik data email dari login user (SESSION)
$userEmail = $_SESSION['email'];
// Check if user is not logged in
if (!isset($_SESSION['log']) || $_SESSION['log'] != 'Logged') {
    header("Location: ../Login/Login.php");
    exit();
}

// Pastikan ini berada di atas tag <!DOCTYPE html>
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nama_pengusul = $_POST["nama_pengusul"];
    $email_pengusul = $_POST["email_pengusul"];
    $lembaga_mitra = $_POST["lembaga_mitra"];
    $judul = $_POST["judul"];
    $lingkup = isset($_POST["lingkup"]) ? implode(", ", $_POST["lingkup"]) : ""; // Menggabungkan nilai checkbox jika ada yang dipilih
    $proses_review = isset($_POST["status"]) ? 1 : 0;
    $lainnya = $_POST["lainnya"];
    $tingkat = $_POST["tingkat"];

    // Validasi bahwa semua formulir harus terisi
    if (empty($nama_pengusul) || empty($email_pengusul) || empty($lembaga_mitra) || empty($judul) || empty($tingkat)) {
        echo "<script>alert('Semua formulir harus diisi');window.location.href = 'form_usulan.php'</script>";
        exit;
    }

    // Validasi format email menggunakan filter_var
    if (!filter_var($email_pengusul, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid');window.location.href = 'form_usulan.php'</script>";
        exit;
    }

    // Koneksi ke database (sesuaikan dengan pengaturan Anda)
    $conn = mysqli_connect("localhost", "root", "", "sikerma");

    // Periksa koneksi
    if (!$conn) {
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    // Buat query SQL untuk menyimpan data
    $sql = "INSERT INTO form (nama_pengusul, email_pengusul, lembaga_mitra, judul, lingkup, lainnya, tingkat, status)
            VALUES ('$nama_pengusul', '$email_pengusul', '$lembaga_mitra', '$judul', '$lingkup', '$lainnya', '$tingkat', 'Proses Review')";

    // Jika data berhasil disimpan
    if (mysqli_query($conn, $sql)) {
        // Arahkan pengguna kembali ke halaman dengan pesan sukses
        header("Location: ProsesUsulan.php?success=true");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Tutup koneksi
    mysqli_close($conn);
}
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
	<!-- Tautan ke Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">

<!-- Tautan ke Bootstrap JavaScript (jQuery harus disertakan sebelum Bootstrap JS) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	

	<title>Usulan Baru</title>

	

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
		<!-- MAIN -->
		<main>
           
			<div class="head-title">
				<div class="left">
					<h1>Form Usulan</h1>
					
				</div>
			</div>


			<div class="table-data">
				<div class="order">
                    <div class="card">
    <div class="card-body">
        <form class="form" method="POST" enctype="multipart/form-data">

            <div class="form-group mb-3">
            <label for="">Nama Pengusul : </label>
            <input type="text" class="form-control" name="nama_pengusul" required value="">
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Email Pengusul : </label>
            <input type="email" class="form-control" name="" disabled value="<?php echo $userEmail ?>" >
            <input type="email" class="form-control" name="email_pengusul" hidden value="<?php echo $userEmail ?>" >
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Lembaga Mitra : </label>
            <input type="text" class="form-control" name="lembaga_mitra" required value="">
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Judul Kerja Sama : </label>
            <input type="text" class="form-control" name="judul" required value="">
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Ruang Lingkup : </label>
            <br>
            
            <input type="checkbox" name="lingkup[]" value="pkl siswa" onclick="checkLimit()" >  PKL Siswa<br/>

            <input type="checkbox" name="lingkup[]" value="magang guru" onclick="checkLimit()" > Magang Guru  <br/>
  
            <input type="checkbox" name="lingkup[]" value="rekruitment lulusan" onclick="checkLimit()"> Rekruitment Lulusan <br>
            
            <input type="checkbox" name="lingkup[]" value="eksploring STEM" onclick="checkLimit()"> Eksploring STEM <br>

            <input type="checkbox" name="lingkup[]" value="tefa" onclick="checkLimit()"> TEFA<br>

            <input type="checkbox" name="lingkup[]" value="sertifikasi" onclick="checkLimit()"> Sertifikasi<br>

            <input type="checkbox" name="lingkup[]" value="Pelayanan" onclick="checkLimit()"> Pelayanan dan Pembinaan Kesehatan<br>

            <input type="checkbox" name="lingkup[]" value="Penyelarasan Kurikulum" onclick="checkLimit()"> Penyelarasan Kurikulum<br>

            <input type="checkbox" name="lingkup[]" value="Sarana" onclick="checkLimit()"> Pengembangan Sarana dan Prasarana <br>

            <input type="checkbox" name="lingkup[]" value="Peneitian" onclick="checkLimit()"> Penelitian Pelaksanaan Program PK<br>

            <input type="checkbox" name="lingkup[]" value="Pelatihan" onclick="checkLimit()"> Pelatihan<br>

            <input type="checkbox" name="lingkup[]" value="Kelas Industri" onclick="checkLimit()"> Kelas Industri<br>

            <input type="checkbox" name="lingkup[]" value="Guru Tamu" onclick="checkLimit()"> Guru Tamu <br>

            <input type="checkbox" name="lingkup[]" value="Kepesertaan BPJS" onclick="checkLimit()"> Kepesertaan BPJS<br>

            <input type="checkbox" name="lingkup[]" value="PendampinganBLUD" onclick="checkLimit()"> Pendampingan BLUD<br><br>
           
            

            Lainnya :
            <textarea class="form-control" name="lainnya" cols="15" rows="1"></textarea>
            
            <!-- <span class="text-danger"></span> -->
            
            <br>
                Tingkat: <br>
            <select class="form-select" aria-label="Default select example" type="select" name="tingkat" required>
            <option selected disabled>Pilihan Tingkat</option>
            <option value="Internasional">Internasional</option>
            <option value="Nasional">Nasional</option>
            <option value="Lokal">Lokal/Wilayah</option>
        </select><br><br><br>

        <div class="form-group mb-3">
    <label for="">Proses Review: </label>
    <input type="checkbox" id="status" name="status" value="1" checked disabled>
</div>


            
            <hr><br>

            <div class="btn">
            <input class="btn btn-success" type="submit" name="add" value="SUBMIT">
            
            
            <a href="../Dashboard/index.php" class="btn btn-danger">
            CANCEL
            </a>
            </div>
            
            
        </form>
    </div>
</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script>

    // Cek jika ada parameter 'success' dalam URL
const urlParams = new URLSearchParams(window.location.search);
const successMessage = urlParams.get('success');

console.log('Index.Pengajuan:', window.location.href);

// Jika parameter 'success' ada dan bernilai 'true', tampilkan pesan pop-up
if (successMessage === 'true') {
    console.log('Data berhasil disimpan!'); // Tambahkan pesan log untuk memastikan ini dijalankan
    // alert('Data berhasil disimpan!');
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
    <script>
function checkLimit() {
    // Dapatkan semua checkbox dengan nama 'lingkup[]'
    const checkboxes = document.querySelectorAll('input[name="lingkup[]"]');
    const maxChecked = 15; // Jumlah maksimum checkbox yang diizinkan

    let checkedCount = 0; // Inisialisasi jumlah yang sudah dipilih

    // Hitung jumlah checkbox yang sudah dipilih
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checkedCount++;
        }
    });

    // Jika jumlah yang sudah dipilih melebihi batas, nonaktifkan checkbox yang tidak dipilih
    if (checkedCount >= maxChecked) {
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.disabled = true;
            }
        });
    } else {
        // Jika jumlah yang sudah dipilih masih di bawah batas, aktifkan semua checkbox
        checkboxes.forEach(checkbox => {
            checkbox.disabled = false;
        });
    }
}
</script>
</body>
</html>