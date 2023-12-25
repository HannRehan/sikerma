<?php
// Menghubungkan ke database MySQL
$host = "localhost"; // Ganti sesuai dengan host database Anda
$username = "root"; // Ganti sesuai dengan username database Anda
$password = ""; // Ganti sesuai dengan password database Anda
$database = "sikerma"; // Ganti sesuai dengan nama database Anda

$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil data yang dikirimkan melalui formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $role = $_POST["role"];

    // Menyisipkan data ke dalam tabel "user"
    $sql = "INSERT INTO user (username, email, gender, password, role) VALUES ('$username', '$email', '$gender', '$password', '$role')";

    

    if ($conn->query($sql) === TRUE) {
        // Data berhasil disimpan, arahkan kembali ke halaman Pengguna.php
        header("Location: ../Dashboard/Pengguna.php");
        exit(); // Pastikan untuk menghentikan eksekusi skrip setelah mengarahkan
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Menutup koneksi ke database
$conn->close();
?>
