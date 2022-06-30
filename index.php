<?php 
    require 'koneksi.php';
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Home </title>

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
<div class="container-fluid banner d-flex align-items-center">
    <div class="container text-center ">
        <marquee behavior="" direction=""></marquee>
        <h1 class="mb-3 color1 text-shadow1"> ZANOW FASHION </h1>
        <h3 class="color1 text-shadow1"> Cari Semua Yang Keren Disini </h3>
        <div class="col-md-8 offset-md-2">
            <form action="produk.php" method="get">
            <div class="input-group input-group-lg my-4">
                <input autocomplete="off" name="keyword" type="text" class="form-control " placeholder="Nama Barang" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <button  class="btn warna3 text-white " type="submit" >Cari Disini</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- end banner -->

<!-- highlighted kategori -->
<div class="container-fluid py-5">
    <div class="container text-center">
        <h3 class="">Katergori Terlaris</h3>

        <div class="row mt-5 text-white">
            <div class="col-md-4 mb-3 ">
                <div class=" shadow1 highlight-kategori kategori-bajupria d-flex justify-content-center align-items-center">
                    <h4 ><a class="link1" href="produk.php?kategori=Baju Pria">BAJU PRIA</a></h4>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class=" shadow1 highlight-kategori kategori-bajuwanita d-flex justify-content-center align-items-center">
                <h4 ><a class="link1" href="produk.php?kategori=Baju Wanita">BAJU WANITA</a></h4>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="shadow1 highlight-kategori kategori-jamtangan d-flex justify-content-center align-items-center">
                <h4 ><a class="link1" href="produk.php?kategori=Jam Tangan">JAM TANGAN</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end highlight -->

<!-- tentang kami -->
<div class="container-fluid warna2 py-5">
    <div class="continer text-center text-white">
        <h3>Tentang Kami</h3> 
        <p class="fs-6 mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi dolor rem voluptatem provident exercitationem obcaecati recusandae ipsum odit, magnam maiores itaque, ea corrupti, dolores quis veritatis in repellendus voluptates ratione voluptatum accusantium hic! Repudiandae quaerat odio tempora, doloremque vitae consectetur eum sunt tempore odit quis laudantium corporis nesciunt nobis quas.</p>
    </div>
</div>
<!-- end tentang kami -->

<!-- produk highlight -->
<div class="container-fluid py-5">
    <div class="container text-center">
        <h3>Produk</h3>

        <div class="row mt-4">
            <!-- ambil data -->
            <?php while($data = mysqli_fetch_assoc($queryProduk)): ?>
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card h-100">
                   <div class="image-box">
                   <img src="image/<?php echo $data['foto']?>" class="card-img-top" alt="foto_produk">
                   </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $data['nama']; ?></h4>
                        <p class="card-text text-truncate"><?= $data['detail']; ?></p>
                        <p class="card-text text-harga">Rp.<?= $data['harga']; ?></p>
                        <a href="produk-detail.php?nama=<?= $data['nama']?>" class="btn warna3 text-white "><span class="color2">lihat Detail</span></a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

            <a href="produk.php" class="btn btn-outline-secondary mt-3  fs-4">Lihat lebih banyak</a>
    </div>
</div>
<!-- end produk highlight -->


<!-- footer -->
<?php require 'footer.php' ?>


<!-- js bootstrap -->
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- js fontawesome -->
<script src="fontawesome/js/all.min.js"></script>
</body>
</html>