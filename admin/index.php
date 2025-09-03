
<?php 
// echo password_hash("admin12345",PASSWORD_DEFAULT);
include "../config/koneksi.php";
session_start();
if(isset($_SESSION['login'])) {
    return header("Location: dashboard.php");
    exit;
}
if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($db,"SELECT * FROM user WHERE username = '$username'");
    $num = mysqli_fetch_assoc($result);
    if($num) {
        if(password_verify($password,$num['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['nama']= $num['nama'];
            $_SESSION['username']=$num['username'];
            return header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>
        alert('Username Atau Password Salah');
        window.location.href = 'index.php';
        </script>";
        die;
        }
    } else {
        echo "<script>
        alert('Akun Tidak Ada');
        window.location.href = 'index.php';
        </script>";
        die;
    }


}
?>
<!doctype html>
<html lang="en">

<head>
    <title>Toko Kerajinan Tangan</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Login Toko Kerajinan Tangan</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(../img//login.jpg);">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Login</h3>
                                </div>
                            </div>
                            <form action="" enctype="multipart/form-data" class="signin-form" method="POST">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Username</label>
                                    <input type="text" class="form-control" name="username"  placeholder="Username" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="login" class="form-control btn btn-primary rounded submit px-3">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"82e7f2b7cdbb3e2f","version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>

</html>