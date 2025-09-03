<?php

include "sesi.php";
$result = mysqli_query($db,"SELECT * FROM product");
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];

    $ket = $_POST['keterangan'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
$nama_file = '';
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // Periksa ukuran file
        $maxFileSize = 5 * 1024 * 1024; // Contoh untuk batas ukuran 5 MB

        // Izinkan ekstensi yang diizinkan
        $allowedExtensions = ["jpg", "jpeg", "png"];
        if ($_FILES["file"]["size"] > $maxFileSize) {
            echo "
            
            <script>
            alert('Ukuran file melebihi batas maksimum yang diperbolehkan.');
            window.location.href = 'produk.php';
            </script>";
            exit;
        } else {
            // Periksa ekstensi file
            $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {

                echo "
            
            <script>
            alert('Ekstensi file tidak diperbolehkan.');
            window.location.href = 'produk.php';
            </script>";
                exit;
            } else {
                $targetDir = "uploads/";
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
            window.location.href = 'produk.php';
            </script>";
                    exit;
                }
            }
        }
    } else {
        echo "
            
        <script>
        alert('Silakan pilih file foto yang valid.');
        window.location.href = 'produk.php';
        </script>";
        exit;
    }
    $now = date("Y-m-d H:i:s");

    $query = mysqli_query($db,"INSERT INTO product VALUES('',
    '$nama_file',
    '$nama',
    '$stok',
    '$ket',
    '$now',
    '$harga'
    )");
    if($query) {
        echo "
            
        <script>
        alert('Data Berhasil Ditambahkan');
        window.location.href = 'produk.php';
        </script>";
        exit;
    } else {
        echo "
            
        <script>
        alert('Data Gagal Ditambahkan');
        window.location.href = 'produk.php';
        </script>";
        exit;
    }
}



if (isset($_POST['edit'])) {
    $nama = $_POST['nama'];
    $id = $_POST['id'];

    $ket = $_POST['keterangan'];
    $stok = $_POST['stok'];
$nama_file = '';
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
        // Periksa ukuran file
        $maxFileSize = 5 * 1024 * 1024; // Contoh untuk batas ukuran 5 MB

        // Izinkan ekstensi yang diizinkan
        $allowedExtensions = ["jpg", "jpeg", "png"];
        if ($_FILES["file"]["size"] > $maxFileSize) {
            echo "
            
            <script>
            alert('Ukuran file melebihi batas maksimum yang diperbolehkan.');
            window.location.href = 'produk.php';
            </script>";
            exit;
        } else {
            // Periksa ekstensi file
            $fileExtension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {

                echo "
            
            <script>
            alert('Ekstensi file tidak diperbolehkan.');
            window.location.href = 'produk.php';
            </script>";
                exit;
            } else {
                $targetDir = "uploads/";
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
            window.location.href = 'produk.php';
            </script>";
                    exit;
                }
            }
        }
    } else {
       $nama_file = $_POST['file_lama'];
    }
    $now = date("Y-m-d H:i:s");
$harga = $_POST['harga'];
    $query = mysqli_query($db,"UPDATE product SET img = '$nama_file', nama = '$nama', stok = '$stok', keterangan = '$ket', harga = '$harga' WHERE id = '$id'");
    if($query) {
        echo "
            
        <script>
        alert('Data Berhasil Diupdate');
        window.location.href = 'produk.php';
        </script>";
        exit;
    } else {
        echo "
            
        <script>
        alert('Data Gagal Diupdate');
        window.location.href = 'produk.php';
        </script>";
        exit;
    }
}

if(isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $hapus = mysqli_query($db,"DELETE FROM product WHERE id = '$id'");
    if($hapus) {
        echo "
            
        <script>
        alert('Data Berhasil Dihapus');
        window.location.href = 'produk.php';
        </script>";
        exit;
    } else {
        echo "
            
        <script>
        alert('Data Gagal Dihapus');
        window.location.href = 'produk.php';
        </script>";
        exit;
    }
} 
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
        <h4>Data Product</h4>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah</a>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="POST" enctype="multipart/form-data" class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" required placeholder="Nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label>
                                    <input type="file" class="form-control" required placeholder="img" name="file">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga</label>
                                    <input type="number" class="form-control" required placeholder="Harga" name="harga">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Stok</label>
                                    <input type="number" class="form-control" required placeholder="Stok" name="stok">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required placeholder="Keterangan" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Dibuat</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($result as $row) : ?>
                    
                <tr>
                    <th scope="row"><?= $no++; ?></th>
                    <td><div style="width: 70px;height: 70px;">
                    <img src="<?=  $row['img']; ?>" alt="" class="w-100 h-100 img-fluid">
                    </div></td>
                    <td><?= $row['nama']; ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td>Rp. <?= number_format($row['harga']); ?></td>
                    <td><?= date("d, F Y",strtotime($row['created_at'])); ?></td>
                    <td><?= $row['keterangan']; ?></td>
                    <td><a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id'] ?>">Edit</a> | <a href="#" class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#hapus<?= $row['id'] ?>">Hapus</a></td>
                   
                </tr>
             


        
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php foreach($result as $dua) :  ?>
    <div class="modal fade" id="edit<?= $dua['id'] ?>" tabindex="-1" aria-labelledby="edit<?= $dua['id'] ?>Label" aria-hidden="true">
            <form method="POST" enctype="multipart/form-data" class="modal-dialog modal-xl">
                <div class="modal-content">
                    <input type="hidden" name="id" value="<?= $dua['id']; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit<?= $dua['id'] ?>Label">Tambah Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label>
                                    <input type="text" class="form-control" value="<?= $dua['nama']; ?>" required placeholder="Nama" name="nama">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Foto</label>
                                    <input type="hidden" name="file_lama" value="<?= $dua['img']; ?>">
                                    <input type="file" class="form-control"  placeholder="img" name="file">
                                    <small class="text-secondary">Jika Tidak Diganti Maka Jangan Upload.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Harga</label>
                                    <input type="number" value="<?= $dua['harga']; ?>" class="form-control" required placeholder="Harga" name="harga">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Stok</label>
                                    <input type="number" class="form-control" value="<?= $dua['stok']; ?>" required placeholder="Stok" name="stok">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" required placeholder="Keterangan" id="" cols="30" rows="10"><?= $dua['keterangan']; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="hapus<?= $dua['id'] ?>" tabindex="-1" aria-labelledby="hapus<?= $dua['id'] ?>Label" aria-hidden="true">
            <form method="POST" enctype="multipart/form-data" class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapus<?= $dua['id'] ?>Label">Hapus Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $dua['id']; ?>">
                        <h5>Apakah Anda Ingin Menghapus Data Ini!</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="hapus" class="btn btn-primary">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    <?php endforeach; ?>
    <?php include "../layout/script.php" ?>
</body>

</html>