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

// Inisialisasi variabel
$judul = $namaPengusul = $email_pengusul = "";
$lingkup_values = array();

// Periksa apakah parameter "id" ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

	// Ambil data dari database berdasarkan ID
	$selectSql = "SELECT * FROM form WHERE id_usulan = $id";
	$result = mysqli_query($conn, $selectSql);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$judul = $row['judul'];
		$namaPengusul = $row['nama_pengusul'];
		$email_pengusul = $row['email_pengusul'];
		$mitra = $row['lembaga_mitra'];
		$lingkup = $row['lingkup'];
		$lainnya = $row['lainnya'];
		$status = $row['status'];
		$tingkat = $row['tingkat'];

		// Ambil nilai checkbox dari kolom "lingkup" di database
        $lingkup_values = explode(",", $row['lingkup']);
	}

    if (isset($_POST['submit'])) {
        $status = $_POST['status']; // Diterima atau Ditolak

        // Handle MOA file upload
        $moaFileName = $_FILES['moa']['name'];
        $moaTempName = $_FILES['moa']['tmp_name'];
        $moaTargetPath = "../uploads/" . $moaFileName; // Adjust the target path as needed

        // Move the uploaded MOA file to the target path
        move_uploaded_file($moaTempName, $moaTargetPath);

        // Handle MOU file upload
        $mouFileName = $_FILES['mou']['name'];
        $mouTempName = $_FILES['mou']['tmp_name'];
        $mouTargetPath = "../uploads/" . $mouFileName; // Adjust the target path as needed

        // Move the uploaded MOU file to the target path
        move_uploaded_file($mouTempName, $mouTargetPath);

        // Update status and file names in the database
        $updateSql = "UPDATE form SET status = '$status', moa_file = '$moaFileName', mou_file = '$mouFileName' WHERE id_usulan = $id";

        if (mysqli_query($conn, $updateSql)) {
            // Tampilkan modal setelah berhasil memperbarui status
            echo '<script>showSuccessModal();</script>';
            // Redirect kembali ke halaman ProsesUsulan.php setelah berhasil memperbarui status
            header("Location: ProsesUsulanAdmin.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
	header("location: ProsesUsulanAdmin.php");
}
?>


	<body>
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

       <!-- ... -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showSuccessModal() {
            $('#successModal').modal('show');
        }
    </script>
    <!-- ... -->


		

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
            <input type="text" class="form-control" name="nama_pengusul" required value="<?php echo $namaPengusul; ?>" disabled>
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Email Pengusul : </label>
            <input type="text" class="form-control" name="nama_pengusul" required value="<?php echo $email_pengusul; ?>"disabled>
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Lembaga Mitra : </label>
            <input type="text" class="form-control" name="lembaga_mitra" required value="<?php echo $mitra; ?>"disabled>
            </div>
            <br>
            <div class="form-group mb-3">
            <label for="">Judul Kerja Sama : </label>
            <input type="text" class="form-control" name="judul" required value="<?php echo $judul; ?>"disabled>
            </div>
            <div class="form-group mb-3">
            <label for="">Ruang Lingkup Lainnya : </label>
            <input type="text" class="form-control" name="judul" required value="<?php echo $lainnya; ?>"disabled>
            </div>
            <br>
            <!-- <span class="text-danger"></span> -->
            
            <br>
                Tingkat: <br>
            <select class="form-select" aria-label="Default select example" type="select" name="tingkat" required disabled>
            <option ><?php echo $tingkat; ?></option>
        </select><br><br><br>

        <div class="form-group mb-3">
    <label for="">Proses Review: </label>
    <input type="checkbox" id="status" name="status" value="1" checked disabled>
</div>

        <form method="post" enctype="multipart/form-data">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="Diterima">Diterima</option>
                <option value="Ditolak">Ditolak</option>
            </select>
            <br>

            <!-- File upload for MOA -->
            <label for="moa">Upload MOA (PDF):</label>
            <input type="file" name="moa" accept=".pdf"> 

            <!-- File upload for MOU -->
            <label for="mou">Upload MOU (PDF):</label>
            <input type="file" name="mou" accept=".pdf">

            <br>

            <input class="btn btn-success" type="submit" name="submit" value="Simpan">
        </form>

        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Data Berhasil Disimpan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Data usulan berhasil diperbarui.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


    </div>
</div>
<script>
function checkLimit() {
    // Dapatkan semua checkbox dengan nama 'lingkup[]'
    const checkboxes = document.querySelectorAll('input[name="lingkup[]"]');
    const maxChecked = 3; // Jumlah maksimum checkbox yang diizinkan

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
