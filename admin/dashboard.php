<?php
include "sesi.php";
$kontak = mysqli_query($db,"SELECT * FROM kontak");
$num = mysqli_num_rows($kontak);
$jual = mysqli_query($db,"SELECT * FROM penjualan ");
$satu = mysqli_num_rows($jual);

$produk = mysqli_query($db,"SELECT * FROM product");
$kl = mysqli_num_rows($produk);
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
        <h1>Dashboard Selamat Datang Toko Kerjinan Tangan</h1>
        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4>Kontak</h4>
                        <h3><?= $num; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4>Penjualan</h4>
                        <h3><?= $satu; ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h4>Product</h4>
                        <h3><?= $kl; ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "../layout/script.php" ?>
</body>

</html>