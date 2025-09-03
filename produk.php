<?php
include "config/koneksi.php";

$result = mysqli_query($db, "SELECT * FROM product WHERE stok >= 1 ORDER BY id DESC");
if(isset($_POST['beli'])) {
    $qty = $_POST['qty'];
    $nama = $_POST['nama'];
    $alamat  = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $id_produk = $_POST['id_produk'];

    $res = mysqli_query($db,"SELECT * FROM penjualan WHERE nama = '$nama' OR no_hp = '$no_hp'");
    $main = mysqli_num_rows($res);
    if($main) {
        echo "<script>
        alert('Nama Atau No Hp Sudah Ada');
        window.location.href = 'produk.php';
        </script>";
        exit;
    }

    $produk = mysqli_query($db,"SELECT * FROM product WHERE id = '$id_produk'");
    $fect = mysqli_fetch_assoc($produk);
    $nominal = $qty * $fect['harga'];

    $now = date("Y-m-d");
    $insert = mysqli_query($db,"INSERT INTO penjualan VALUES('',
    '$nama',
    '$alamat',
    'Pending',
    null,
    '$no_hp',
    '$id_produk',
    '$nominal',
    '$now',
    '$qty'
    )");

    if($insert) {
        echo "<script>
        alert('Barang Berhasil Dibeli');
        window.location.href = 'produk.php';
        </script>";
        exit;
    } else {
        echo "<script>
        alert('Barang Gagal Dibeli');
        window.location.href = 'produk.php';
        </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "layout/head.php"; ?>
</head>

<body>
    <?php include "layout/navbar.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Product</h1>
        <br>
        <div class="row">
            <?php foreach ($result as $row) : ?>
                <div class="col-md-3">
                    <div class="card">
                        <div style="width: 100%;height: 200px;">
                            <img src="<?= 'admin/' . $row['img'] ?>" class="card-img-top" alt="..." style="width: 100%;height: 100%;object-fit: contain;">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['nama']; ?></h5>
                            <small class="text-secondary">Stok : <?= $row['stok']; ?></small>
                            <br>
                            <small class="text-secondary">Harga : Rp. <?= number_format($row['harga']) ?></small>
                            <p class="card-text"><?= $row['keterangan'] ?></p>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#beli<?= $row['id'] ?>">Beli</a>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="beli<?= $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <form method="POST" enctype="multipart/form-data" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Beli</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div style="width: 100%;height: 400px;">
                                            <img src="<?= 'admin/' . $row['img'] ?>" class="card-img-top" alt="..." style="width: 100%;height: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4><?= $row['nama']; ?></h4>
                                        <small class="text-secondary">Stok : <?= $row['stok']; ?></small>
                                        <br>
                                        <small class="text-secondary">Harga : Rp. <?= number_format($row['harga']) ?></small>
                                        <p class="card-text"><?= $row['keterangan'] ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <input type="hidden" name="id_produk" value="<?= $row['id']; ?>">
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <label for="" class="form-label">Qty</label>
                                            <input type="number" class="form-control" required placeholder="Qty" name="qty">
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="form-label">Nama</label>
                                            <input type="text" class="form-control" required placeholder="Nama" name="nama">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mt-2">
                                            <label for="" class="form-label">No Hp</label>
                                            <input type="number" class="form-control" required placeholder="No Hp" name="no_hp">
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="form-label">Alamat</label>
                                            <input type="text" class="form-control" required placeholder="Alamat" name="alamat">
                                        </div>
                                        <div class="mt-2">
                                            <label for="" class="form-label">Via Transfer Bank</label>
                                            <input type="text" value="BRI/027261939728/Andi Pratama" class="form-control" required  readonly style="background:grey;color: white;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="beli" class="btn btn-primary">Beli</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include "layout/script.php" ?>
</body>

</html>