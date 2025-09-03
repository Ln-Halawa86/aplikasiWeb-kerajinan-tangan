<?php
include "sesi.php";
$query = mysqli_query($db,"SELECT * FROM kontak ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../layout/head.php" ?>
</head>

<body>

    <?php include "navbar.php" ?>
    <br>
    <br>
    <br>
    <div class="container">
        <h4>Data Kontak</h4>
        <table  class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">No Hp</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $no =1; foreach($query as $row) : ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['no_hp']; ?></td>
                    <td><?= $row['pesan']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include "../layout/script.php" ?>
</body>

</html>