<?php

include "config/koneksi.php";

if (isset($_POST['kirim'])) {
    $nama = $_POST['nama'];
    $pesan = $_POST['keterangan'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];


    $result = mysqli_query($db, "SELECT * FROM kontak WHERE nama = '$nama'");
    $num = mysqli_num_rows($result);


    if ($num) {
        echo "
        <script>
            alert('Nama Sudah Ada');
            window.location.href = 'contact.php';
        </script>
        ";
        die;
    }
    $now = date("Y-m-d H:i:s");
    $query = "INSERT INTO kontak VALUES('','$nama','$email','$no_hp','$pesan','$now')";
    $check = mysqli_query($db, $query);
    if ($check) {
        echo "
    <script>
        alert('Pesan Berhasil Dikirim');
        window.location.href = 'contact.php';

    </script>
    ";
        die;
    } else {
        echo "
    <script>
        alert('Pesan Gagal Dikirim');
        window.location.href = 'contact.php';
    </script>
    ";
        die;
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
    
    <h1 class="text-center  mt-5">Kontak</h1>
    <br>
    <div class="card container">
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-groups">
                            <label class="form-label" for="">Nama</label>
                            <input type="text" class="form-control" name="nama" required maxlength="255" placeholder="Nama">
                        </div>
                        <div class="input-groups mt-3">
                            <label class="form-label" for="">Email</label>
                            <input type="email" class="form-control" name="email" required maxlength="255" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-groups mt-3">
                            <label class="form-label" for="">No Hp</label>
                            <input type="number" class="form-control" name="no_hp" required maxlength="255" placeholder="No Hp">
                        </div>
                        <div class="input-groups mt-3">
                            <label class="form-label" for="">Keterangan</label>
                            <textarea name="keterangan" id="" class="form-control" required cols="30" rows="8"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3" name="kirim">Kirim</button>
            </form>
        </div>
    </div>


    <?php include "layout/script.php" ?>
</body>

</html>