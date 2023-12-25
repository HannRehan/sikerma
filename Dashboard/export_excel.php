<?php
header('Content-Type: application/vnd.ms-excel');
$filename = "form_hasil_pengusul.xls";
header("Content-Disposition: attachment;filename=\"$filename\"");
?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 2px solid black;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2; /* Add a light gray background to header cells */
    }
</style>

<table>
    <thead>
        <tr>
            <th colspan="11" style="text-align: center; font-size: 32px;">Hasil Export Form Pengusul</th>
        </tr>
        <tr>
            <th>Nomor</th>
            <th>Nama Pengusul</th>
            <th>Email Pengusul</th>
            <th>Lembaga Mitra</th>
            <th>Judul</th>
            <th>Ruang Lingkup yang diambil</th>
            <th>Lainnya</th>
            <th>Status</th>
            <th>Tingkat</th>
            <th>Moa File</th>
            <th>Mou File</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include 'koneksi2.php';

        $query = "SELECT * FROM form";
        $result = mysqli_query($koneksi, $query);

        $no = 1;
        while ($data = mysqli_fetch_assoc($result)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data["nama_pengusul"]; ?></td>
                <td><?php echo $data["email_pengusul"]; ?></td>
                <td><?php echo $data["lembaga_mitra"]; ?></td>
                <td><?php echo $data["judul"]; ?></td>
                <td><?php echo $data["lingkup"]; ?></td>
                <td><?php echo $data["lainnya"]; ?></td>
                <td><?php echo $data["status"]; ?></td>
                <td><?php echo $data["tingkat"]; ?></td>
                <td><?php echo $data["moa_file"]; ?></td>
                <td><?php echo $data["mou_file"]; ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
