<?php 
session_start();
//connect database
require '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Zanow | Login Admin</title>

    <!-- css bootstrap 5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- css manual -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<style>
    .main {
  height: 100vh;
}
.login-box {
  width: 400px;
  height: 350px;
  border-radius: 20px;
  box-sizing: border-box;
}
</style>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-4 shadow">
            <div class="icon-login text-center mb-3">
            <i class="fa-solid fa-user-secret fa-3x"></i>
            </div>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary form-control" type="submit" name="loginbtn">Login</button>
                </div>
                <div class="mb-3">
                    <a href="../index.php" class="btn btn-success form-control">Halaman Utama</a>
                </div>
            </form>
        </div>
        <!-- logic php -->
        <div class="mt-3">
            <?php 
            if (isset($_POST['loginbtn'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);
                
                if ($countdata > 0) {
                    if (password_verify($password, $data['password'])){
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: ../adminpanel');
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                              Password Salah!
                              </div>';
                    }
                }else{
                    echo '<div class="alert alert-danger" role="alert">
                          Akun Tidak Tersedia!
                          </div>';
                }
            }
            ?>
        </div>
    </div>
</body>
</html>