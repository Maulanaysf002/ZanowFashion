<?php 
    require '../koneksi.php';
    require 'session.php';

    $queryProduk = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
    $jumlahProduk = mysqli_num_rows($queryProduk);

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // fungsi string random
    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Produk</title>

    <!-- css bootstrap 5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- css manual -->
    <link rel="stylesheet" href="../css/style.css">
    <!-- fontawesome -->
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>
<style>
.link{
        text-decoration: none;
        color: gray;
    }
    .link:hover{
        color: #6F0000;
    }
</style>
<body>
    <!-- navbar component -->
    <?php require 'navbar.php'; ?>

<div class="container mt-4">
<nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="../adminpanel" class="link"><i class="fa-solid fa-house"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
        </nav>
    <!-- tambah produk -->
    <div class="my-4 col-12 col-md-6">
    <h3>Tambah Produk</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="nama" class="form-label">Nama produk</label>
                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
            </div>
            <div class="mb-2">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-select" required>
                <?php 
                    while($data=mysqli_fetch_array($queryKategori)){
                ?>
                    <option value="<?php echo $data['id']?>"><?php echo $data['nama'] ?></option>
                <?php
                    }
                ?>
                </select>
            </div>
            <div class="mb-2">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="mb-2">
                <label for="detail">Detail</label>
                <textarea class="form-control" placeholder="Tuliskan detail produk" id="detail" name="detail" cols="20" rows="10"></textarea>
            </div> 
            <div class="mb-2">
                <label for="stok">Ketersediaan Stok</label>
                <select name="stok" id="stok" class="form-select">
                    <option value="tersedia">tersedia</option>
                    <option value="habis">habis</option>
                </select>
            </div>
            <div class="mb-2">
                    <button type="submit" name="produkbtn" class="btn btn-success">Simpan</button>
            </div>
        </form>
        <!-- validasi php -->
    <?php
        if(isset($_POST['produkbtn'])){
            // variabel input form
            $nama = htmlspecialchars($_POST['nama']);
            $kategori = htmlspecialchars($_POST['kategori']);
            $harga = htmlspecialchars($_POST['harga']);
            $detail = htmlspecialchars($_POST['detail']);
            $stok = htmlspecialchars($_POST['stok']);
            // logic dan variabel untuk validasi foto
            $target_dir = "../image/";
            $nama_file = basename($_FILES['foto']['name']);
            $target_file = $target_dir . $nama_file;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $image_size = $_FILES["foto"]["size"];
            $random_name = generateRandomString(20);
            $new_name = $random_name . "." . $imageFileType; 

            if($nama=='' || $kategori=='' || $harga==0){
                echo '<div class="alert alert-warning" role="alert">
                Nama, Kategori dan Harga wajib diisi !
                </div>';
            }else{
                // validasi foto
                if($nama_file != ''){
                    if($image_size > 500000){
                        echo '<div class="alert alert-warning" role="alert">
                        foto tidak boleh lebih dari 500kb
                        </div>';
                    }else{
                        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif'){
                            echo '<div class="alert alert-warning" role="alert">
                            file wajib bertipe jpg, png, atau gif
                            </div>';
                        }else{
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name );
                        }
                    }
                }
                // query insert produk
                $queryInsert = mysqli_query($con, "INSERT INTO produk (kategori_id, nama, harga, foto, detail, ketersediaan_stok) VALUES ('$kategori', '$nama', '$harga', '$new_name', '$detail', '$stok')");

                if($queryInsert){
                    echo '<div class="alert alert-success role="alert">
                            Data Produk Berhasil Ditambah
                            </div>
                            <meta http-equiv="refresh" content="0; url=produk.php" />';
                }else{
                    echo mysqli_error($con);
                }
            }
        } 
    ?>
    </div>


    <!-- list produk -->
    <div class="mt-5">
        <h3>List Kategori</h3>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>kategori</th>
                        <th>harga</th>
                        <th>ketersediaan Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $i=1;
                    if($jumlahProduk == 0){
                ?>
                    <tr>
                        <td colspan="6" class="text-center"> Data Produk Tidak Tersedia </td>
                    </tr>
                <?php
                    }else{
                        while($data= mysqli_fetch_array($queryProduk))
                        {
                ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['nama_kategori'] ?></td>
                        <td><?php echo $data['harga'] ?></td>
                        <td><?php echo $data['ketersediaan_stok'] ?></td>
                        <td>
                        <a href="produk-detail.php?p=<?php echo $data['id'] ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
                        </td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
    <!-- js bootsrtap -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- js fontawesome -->
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>