<?php 
    require 'session.php';
    require '../koneksi.php';

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);

    $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    $jumlahProduk = mysqli_num_rows($queryProduk);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Home</title>

    <!-- css bootstrap 5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<style>
    .summary-kategori{
        background-color: #00A1AB;
        border-radius: 15px;
    }
    .summary-produk{
        background-color: #4FBDBA;
        border-radius: 15px;
    }

    .link{
        text-decoration: none;
        color: white;
    }
    .link:hover{
        color: #6F0000;
    }
</style>
<body>
    <!-- navbar component -->
    <?php require 'navbar.php'; ?>

    <!-- breadcrumb component -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"> <i class="fa-solid fa-house"></i> Home</li>
            </ol>
        </nav>
        <h2>Hallo <?php echo $_SESSION['username']; ?></h2>

        <!-- summary component -->
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="summary-kategori p-3">
                            <div class="row">
                                <div class="col-6">
                                    <i class="fa-solid fa-align-justify fa-7x text-black-50"></i>
                                </div>
                                <div class="col-6 text-white">
                                    <h3 class="fs-2">kategori</h3>
                                    <p class="fs-4"><?php echo $jumlahKategori; ?> Kategori</p>
                                    <p><a href="kategori.php" class="link">lihat detail</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <div class="summary-produk p-3">
                            <div class="row">
                                <div class="col-6">
                                <i class="fa-solid fa-box-open fa-7x text-black-50"></i>
                                </div>
                                <div class="col-6 text-white">
                                    <h3 class="fs-2">Produk</h3>
                                    <p class="fs-4"><?php echo $jumlahProduk; ?> Produk</p>
                                    <p><a href="produk.php" class="link">lihat detail</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- end summary -->
            </div>
        </div>
    </div>
    <!-- end breadcrumb -->

    <!-- js bootsrtap -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- js fontawesome -->
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>