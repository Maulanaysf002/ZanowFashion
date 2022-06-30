<?php
    require 'koneksi.php';

    // query data
    $nama = htmlspecialchars($_GET['nama']);

    $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_assoc($queryProduk);

    // produk terkait
    $queryProdukTerkait = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Produk Detail </title>

    <!-- bootstrap css 5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <!-- vanila css -->
    <link rel="stylesheet" href="style-vanila.css">
</head>
<body>
<!-- navbar -->
<?php require 'navbar.php'; ?>

<!-- banner -->
<div class="container-fluid banner-produk d-flex align-items-center">
    <div class="container text-center">
        <h1 class="mb-3 color1 text-shadow1">PRODUK DETAIL</h1>
    </div>
</div>

<!-- body -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-5 mb-5">
                <img src="image/<?php echo $produk['foto']; ?>" alt="Foto_Produk" class="w-100">
            </div>
            <div class="col-lg-6 offset-lg-1">
                <h1><?php echo $produk['nama']; ?></h1>
                <p class="fs-5"><?php echo $produk['detail']; ?></p>
                <p class="text-harga warna3">Rp. <?php echo $produk['harga']; ?></p>
                <p class="fs-5">Status Ketersediaan : <strong><?php echo $produk['ketersediaan_stok']; ?></strong></p>
            </div>
        </div>
    </div>
</div>

<!-- produk terkait -->
<div class="container-fluid py-5 warna2">
    <div class="container">
        <h2 class="text-center text-white mb-5">Produk Terkait</h2>

        <div class="row">
        <?php while($data = mysqli_fetch_assoc($queryProdukTerkait)) : ?>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="image-box">
            <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>">
            <img src="image/<?php echo $data['foto']; ?>" class="img-fluid img-thumbnail" alt="produk_terkait">
            </a>
            </div>
        </div>
        <?php endwhile; ?>
        </div>
    </div>
</div>

<!-- footer -->
<?php
    require 'footer.php';
?>

<!-- js bootstrap -->
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- js fontawesome -->
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>