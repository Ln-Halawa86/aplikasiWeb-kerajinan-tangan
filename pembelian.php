<?php

include "config/koneksi.php";

$query = mysqli_query($db, "SELECT * FROM penjualan ORDER BY id DESC");

if(isset($_POST['bayar'])) {
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // Periksa ukuran file
        $maxFileSize = 5 * 1024 * 1024; // Contoh untuk batas ukuran 5 MB

        // Izinkan ekstensi yang diizinkan
        $allowedExtensions = ["jpg", "jpeg", "png"];
        if ($_FILES["file"]["size"] > $maxFileSize) {
            echo "
            
            <script>
            alert('Ukuran file melebihi batas maksimum yang diperbolehkan.');
            window.location.href = 'pembelian.php';
            </script>";
            exit;
        } else {
            // Periksa ekstensi file
            $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {

                echo "
            
            <script>
            alert('Ekstensi file tidak diperbolehkan.');
            window.location.href = 'pembelian.php';
            </script>";
                exit;
            } else {
                $targetDir = "admin/uploads/";
                $targetFile = $targetDir . rand(1,999) . basename($_FILES["file"]["name"]);

                // Pindahkan file yang diunggah ke direktori target
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                    // Proses update foto ke database atau tempat penyimpanan lainnya
                    // Di sini, Anda dapat menyimpan nama file atau path file ke database
                    $nama_file = $targetFile;
                } else {
                    echo "
            
            <script>
            alert('Maaf, terjadi kesalahan saat mengunggah file.');
            window.location.href = 'pembelian.php';
            </script>";
                    exit;
                }
            }
        }
    } else {
        echo "
            
        <script>
        alert('Silakan pilih file foto yang valid.');
        window.location.href = 'pembelian.php';
        </script>";
        exit;
    }

    $id = $_POST['id'];

    $update = mysqli_query($db,"UPDATE penjualan SET img = '$nama_file' WHERE id = '$id'");
    $fects = mysqli_query($db,"SELECT * FROM penjualan WHERE id = '$id'");
        $re = mysqli_fetch_assoc($fects);
        $ids = $re['product_id'];


        $ma = mysqli_query($db,"SELECT *FROM product WHERE id = '$ids'");
        $qwe = mysqli_fetch_assoc($ma);

        $hasil = $qwe['stok'] - $re['qty'];

        mysqli_query($db,"UPDATE product SET stok = '$hasil' WHERE id = '$ids'" );
    
    if($update) {
        echo "
            
        <script>
        alert('Pembayaran Berhasil Dikirim.');
        window.location.href = 'pembelian.php';
        </script>";
        exit;
    } else {
        echo "
            
        <script>
        alert('Pembayaran Gagal Dikirim.');
        window.location.href = 'pembelian.php';
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

    <h1 class="text-center  mt-5">Pembelian</h1>
    <br>
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
                        <a href="#" data-bs-toggle="modal" data-bs-target="#bayar<?= $row['id'] ?>" class="btn btn-primary">
                        <?php if($row['img'] == null) : ?>
                        Bayar
                        <?php else: ?>
                            Detail
                        <?php endif; ?>
                    </a>
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
                        <?php if($er['img'] == null) :  ?>
                        <div class="row">
                            <input type="hidden" name="id" value="<?= $er['id']; ?>">
                            <div class="mt-2">
                                <label for="" class="form-label">Bukti Bayar</label>
                                <input type="file" class="form-control" required placeholder="Qty" name="file">
                            </div>
                        </div>
                        <?php else: ?>
                            <div style="width: 100%;height: auto;">
                                <img src="<?= $row['img']; ?>" alt="" class="img-fluid">
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <?php if($er['img'] == null) :  ?>
                            <button type="submit" name="bayar" class="btn btn-primary">Beli</button>
                            <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php include "layout/script.php" ?>
</body>

</html>