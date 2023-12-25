<?php
session_start();

// Hancurkan semua data sesi
session_destroy();

// Arahkan pengguna ke halaman login
header("Location: Login.php");
exit();
?>
