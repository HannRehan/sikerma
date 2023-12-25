<?php
session_start(); // Pastikan session_start() telah dipanggil sebelum menggunakan $_SESSION

$koneksi = mysqli_connect("localhost", "root", "", "sikerma");

// login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $cekuser = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username'");
    $hitung = mysqli_num_rows($cekuser);

    if ($hitung > 0) {
        $user = mysqli_fetch_array($cekuser);

        $role = $user['role'];
        if (!password_verify($password, $user['password'])) {
            echo "<script>alert('Username atau password salah');window.location.href = 'login.php'</script>";
        } else {
            if ($role == 'admin') {
                $_SESSION['log'] = 'Logged';
                $_SESSION['role'] = 'Admin';
                $_SESSION['username'] = $user['username']; // Simpan nama pengguna dalam sesi
                $_SESSION['email'] = $user['email'];
                header('location:../DashboardAdmin/index_admin.php');
            } else if ($role == 'user') {
                $_SESSION['log'] = 'Logged';
                $_SESSION['role'] = 'User';
                $_SESSION['username'] = $user['username']; // Simpan nama pengguna dalam sesi
                $_SESSION['email'] = $user['email'];
                // $_SESSION['email'] = $email_pengguna;
                // $_SESSION['user_id'] = $user['id'];
                
                header('location:../DashboardPengguna/index_pengguna.php');
            } else if ($role == 'superadmin') {
                $_SESSION['log'] = 'Logged';
                $_SESSION['role'] = 'Superadmin';
                $_SESSION['username'] = $user['username']; // Simpan nama pengguna dalam sesi
                $_SESSION['email'] = $user['email'];
                header('location:../Dashboard/index.php');
            }
        }
    } else {
        echo "<script>alert('User tidak ditemukan');window.location.href = '../Login/Login.php'</script>";
    }
}
?>
