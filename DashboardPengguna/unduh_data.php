<?php
session_start();
// Database connection details
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sikerma";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
// Fetch the uploaded files from the database
$sql = "SELECT * FROM form WHERE id_usulan = $id";
$result = $conn->query($sql);
} else {
	header("location: hasil_usulan_pengguna.php");
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
				<a href="../DashboardPengguna/index_pengguna.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../../Sikerma/DashboardPengguna/index_usulan_pengguna.php">
					<i class='bx bx-bar-chart-alt-2'></i>
					<span class="text">Usulan Baru</span>
				</a>
			</li>
			<li>
				<a href="../../Sikerma/DashboardPengguna/proses_usulan_pengguna.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Proses Usulan</span>
				</a>
			</li>
			<li>
				<a href="../../Sikerma/DashboardPengguna/hasil_usulan_pengguna.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Hasil Usulan</span>
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
                    
                    
                    echo '<a class="dropdown-item" href="../Login/Login.php">Logout</a>';
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
            <div class="container mt-5">
                <h2>Uploaded Files</h2>

                <!-- Form to select status -->
                <!-- <form method="post">
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                    <input class="btn btn-success" type="submit" name="submit" value="Filter">
                </form> -->

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
							<th>Judul</th>
                            <th>File MOA</th>
							<th>File MOU</th>
                            <th>Download MOA</th>
							<th>Download MOU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display the uploaded files and download links
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $moaFilePath = "../uploads/" . $row['moa_file'];
                                $mouFilePath = "../uploads/" . $row['mou_file'];
                                ?>
                                <tr>
									<td><?php echo  $row["judul"]  ?></td>
									<td><?php echo $row['moa_file']; ?></td>
                                    <td><?php echo $row['mou_file']; ?></td>
                                    <td><a href="<?php echo $moaFilePath; ?>" class="btn btn-primary" download>Download MOA</a></td>
                                    <td><a href="<?php echo $mouFilePath; ?>" class="btn btn-success" download>Download MOU</a></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">No files uploaded yet.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>

                
        <!-- <input type="submit" name="submit" value="Simpan"> -->
        <!-- <input class="btn btn-success" type="submit" name="submit" value="Simpan"> -->
    </form>
    </div>
</body>
</html>
