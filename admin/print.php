<?php

include "../config/koneksi.php";
$res = mysqli_query($db, "SELECT * FROM penjualan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../layout/head.php"; ?>
    <style>
        * {
            margin: 0px;
            padding: 0px;
        }
        
    </style>
</head>

<body>
    <div class="text-center">
        <h4>Toko Kerjinan Tangan</h4>
        <br>
        <h5>Faktur</h5>
    </div>
    <div class="row" style="display: flex !important;">
        <div class="col-md-6">
            <span>Nama : Admin</span>
            <br>
            <span>No Fakter : <?= rand(1, 99) . '/FKT/' . date("Y") ?></span>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped mt-5">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
        <?php
$no = 1;
$totalNominal = 0;

foreach ($res as $row) :
    $ir = $row['product_id'];
    $query = mysqli_query($db, "SELECT * FROM product WHERE id = '$ir'");
    $ww = mysqli_fetch_assoc($query);
    ?>

    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['nama']; ?></td>
        <td>Nama Barang</td>
        <td><?= $row['qty']; ?> Barang</td>
        <td>Rp. <?= number_format($ww['harga']); ?></td>
        <td>Rp. <?= number_format($row['nominal']); ?></td>
    </tr>

    <?php
    // Add the current row's nominal value to the total
    $totalNominal += $row['nominal'];
endforeach;
?>

<tr>
    <td colspan="5" style="text-align: right;">Jumlah</td>
    <td>Rp. <?= number_format($totalNominal); ?></td>
</tr>

        </tbody>
    </table>

    <div class="row">
        <div class="col-md-6">
            <h6>Diketahui</h6>
            <br>
            <small>..................</small>
        </div>  
    </div>
    <script>
        window.print();
    </script>
</body>

</html>