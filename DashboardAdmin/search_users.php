<?php
include('koneksi1.php'); // Sertakan file koneksi database

if (isset($_POST['search'])) {
    $searchText = $_POST['search'];
    $sql = "SELECT * FROM user WHERE username LIKE '%$searchText%' OR email LIKE '%$searchText%'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["role"] . "</td>";
            echo "<td>
                <button class='btn btn-danger' data-toggle='modal' data-target='#deleteModal" . $row["id"] . "'>Delete</button>
            </td>";
            echo "</tr>";
        }
    } else {
        echo "No records found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn); // Tutup koneksi database
?>
