<?php 
    require '../koneksi.php';
    require 'session.php';

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");
    $jumlahKategori = mysqli_num_rows($queryKategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Kategori</title>

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

    <!-- breadcrumb component -->
<div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="../adminpanel" class="link"><i class="fa-solid fa-house"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kategori</li>
            </ol>
        </nav>

    <div class="my-5 col-12 col-md-6">
    <h3>Tambah Kategori</h3>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Input Nama Kategori">
            </div>
            <div class="mb-3">
                <button class="btn btn-success" type="submit" name="simpan_kategori" >Simpan</button>
            </div>
        </form>
        <!-- logic php -->
        <?php 
        if(isset($_POST['simpan_kategori'])){
            $kategori= htmlspecialchars($_POST['kategori']);

            $queryExist = mysqli_query($con, "SELECT nama FROM kategori WHERE nama='$kategori'");
            $jumlahDataKategoriBaru = mysqli_num_rows($queryExist);
            
            if($jumlahDataKategoriBaru > 0){
                echo '<div class="alert alert-warning" role="alert">
                kategori sudah ada !
              </div>';
            }else{
                $querySimpan = mysqli_query($con, "INSERT INTO kategori(nama) VALUES ('$kategori')");
                if($querySimpan){
                    echo '<div class="alert alert-success role="alert">
                            kategori berhasil ditambah
                            </div>
                            <meta http-equiv="refresh" content="0; url=kategori.php" />';
                }else{
                    echo mysqli_error($con);
                }
            }
        }
        ?>
    </div>

    <div class="mt-3">
        <h3>List Kategori</h3>
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=1;
                        if ($jumlahKategori == 0) {
                    ?>
                    <tr>
                    <td colspan="3" class="text-center">Tidak ada kategori</td>
                    </tr>
                    <?php
                    }else{
                        while ($data=mysqli_fetch_array($queryKategori)){
                    ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $data['nama'];?></td>
                        <td>
                        <a href="kategori-detail.php?p=<?php echo $data['id'] ?>" class="btn btn-info"><i class="fas fa-search"></i></a>
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
    <!-- end breadcrumb -->



    <!-- js bootsrtap -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- js fontawesome -->
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>