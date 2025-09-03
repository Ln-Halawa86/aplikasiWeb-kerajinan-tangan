<?php

include "../config/koneksi.php";

$query = mysqli_query($db, "SELECT * FROM penjualan ORDER BY id DESC");

if (isset($_POST['done'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = mysqli_query($db, "UPDATE penjualan SET status = '$status' WHERE id = '$id'");
    if ($query) {
        echo "<script>
        alert('Data Berhasil Diupdate');
        window.location.href = 'penjualan.php';
        </script>";
        exit;
    } else {
        echo "<script>
        alert('Data Gagal Diupdate');
        window.location.href = 'penjualan.php';
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../layout/head.php"; ?>
</head>

<body>
    <?php include "navbar.php"; ?>

    <h1 class="text-center  mt-5">Pembelian</h1>
    <br>
    <div class="container mb-3">
    <a href="print.php" target="_blank" class="btn btn-success">Print</a>
    </div>
    <table class="table container table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">No Hp</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Satuan Harga</th>
                <th scope="col">Total Harga</th>
                <th scope="col">Qty</th>
                <th scope="col">Status</th>
                <th scope="col">Alamat</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($query as $row) : ?>
                <?php
                $id_barang = $row['product_id'];
                $barang = mysqli_query($db, "SELECT * FROM product WHERE id = '$id_barang'");
                $ff = mysqli_fetch_assoc($barang);
                ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['no_hp']; ?></td>
                    <td><?= $ff['nama']; ?></td>
                    <td> Rp. <?= number_format($ff['harga']); ?></td>
                    <td> Rp. <?= number_format($row['nominal']); ?></td>
                    <td><?= $row['qty']; ?> Barang</td>
                    <td>
                        <?php if ($row['status'] == 'Pending') :  ?>
                            <span class="badge badge-pill bg-danger">Pending</span>
                        <?php elseif ($row['status'] == "Dikirim") :  ?>
                            <span class="badge badge-pill bg-warning">Dikirim</span>
                        <?php elseif ($row['status'] == "Selesai") :  ?>
                            <span class="badge badge-pill bg-success">Selesai</span>
                        <?php endif; ?>
                    <td><?= $row['alamat']; ?></td>
                    <td>
                        <?php if ($row['img'] == null) : ?>
                            <a href="#" class="btn btn-danger">
                                Belum Dibayar
                            </a>
                        <?php else : ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#bayar<?= $row['id'] ?>" class="btn btn-success">
                                Detail
                            </a>
                        <?php endif; ?>
                    </td>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php foreach ($query as $er) :  ?>
        <div class="modal fade" id="bayar<?= $er['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form method="POST" enctype="multipart/form-data" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Bayar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if ($er['status'] != "Selesai") : ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="width: 100%;height: auto;">
                                        <img src="<?= '../' . $er['img']; ?>" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?= $er['id']; ?>">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Status</label>
                                        <select name="status" id="" class="form-control" required>
                                            <option value="">Pilih</option>
                                            <option value="Dikirim">Dikirim</option>
                                            <option value="Selesai">Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div style="width: 100%;height: auto;">
                                <img src="<?= '../' . $er['img']; ?>" alt="" class="img-fluid">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <?php if($er['status'] != "Selesai") : ?>
                        <button type="submit" name="done" class="btn btn-primary">Simpan</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php include "../layout/script.php" ?>
</body>

</html>