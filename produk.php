<?php
    require 'koneksi.php';

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // get produk by keyword
    if(isset($_GET['keyword'])){
        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%'");
    }
    // get produk by kategori
      else if(isset($_GET['kategori'])){
        $getId = mysqli_query($con, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
        $idKategori = mysqli_fetch_array($getId);

        $queryProduk = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$idKategori[id]'");
      }
    // get produk by default
        else{
            $queryProduk = mysqli_query($con, "SELECT * FROM produk");
         }

         $countData = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Produk</title>

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
        <h1 class="mb-3 color1 text-shadow1">PRODUK</h1>
    </div>
</div>

<!-- isi produk -->
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <h3 class="mb-3 text-center">kategori</h3>
    <?php while($kategori = mysqli_fetch_assoc($queryKategori)) : ?>
            <ul class="list-group">
            <a href="produk.php?kategori=<?php echo $kategori['nama']; ?>" class="link3"><li class="list-group-item"><?php echo $kategori['nama']; ?></li></a>
            </ul>
    <?php endwhile; ?>
        </div>
        <div class="col-lg-9 mb-4">
            <h3 class="text-center mb-3">PRODUK</h3>
    <?php
        if($countData == 0){
        echo '<div class="alert alert-warning text-center" role="alert">
        Maaf Nama Produk Tidak Tersedia 
        </div>';
        }
    ?>
            <!-- desain produk -->
            <div class="row">
            <?php while($produk = mysqli_fetch_assoc($queryProduk)) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                    <div class="image-box">
                    <img src="image/<?php echo $produk['foto']?>" class="card-img-top" alt="foto_produk">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $produk['nama']; ?></h4>
                        <p class="card-text text-truncate"><?= $produk['detail']; ?></p>
                        <p class="card-text text-harga">Rp.<?= $produk['harga']; ?></p>
                        <a href="produk-detail.php?nama=<?= $produk['nama']?>" class="btn warna3 text-white "><span class="color2">lihat Detail</span></a>
                    </div>
                    </div>
                </div>
            <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php require 'footer.php' ?>


<!-- js bootstrap -->
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- js fontawesome -->
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>