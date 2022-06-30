<?php 
    require '../koneksi.php';
    require 'session.php';

    $id=$_GET['p'];

    $query = mysqli_query($con, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
    $data = mysqli_fetch_array($query); 

    $queryKategori = mysqli_query($con, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

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
    <title>Zanow | Produk Detail</title>

    <!-- css bootstrap 5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- css manual -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- navbar component -->
    <?php require 'navbar.php'; ?>

    <div class="container mt-3">
        <h2>Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama produk</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo $data['nama'];?>" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select name="kategori" id="kategori" class="form-select" required>
                <option value="<?php echo $data['nama_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                <?php 
                    while($dataKategori=mysqli_fetch_array($queryKategori)){
                ?>
                    <option value="<?php echo $dataKategori['id']?>"><?php echo $dataKategori['nama'] ?></option>
                <?php
                    }
                ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" id="harga" name="harga" value="<?php echo $data['harga'];?>" class="form-control" required>
            </div>
            <div>
                <label class="form-label" for="currentFoto">Foto Produk Sekarang : </label>
                <img src="../image/<?php echo $data['foto'] ?>" alt="Foto_Produk_Sekarang" width="350px">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Pilih Foto Terbaru</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="detail" class="form-label">Detail</label>
                <textarea class="form-control" placeholder="Tuliskan detail produk" id="detail" name="detail" cols="20" rows="10"><?php echo $data['detail']; ?></textarea>
            </div>
            <div class="mb-2">
                <label for="stok" class="form-label">Ketersediaan Stok</label>
                <select name="stok" id="stok" class="form-select">
                    <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo $data['ketersediaan_stok']; ?></option>
                    <?php 
                    if($data['ketersediaan_stok']=='tersedia'){
                        echo "<option value='habis'>habis</option>";
                    }else{
                        echo "<option value='tersedia'>tersedia</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <button type="submit" name="simpan" class="btn btn-success">Update Data</button>
                <button type="submit" name="hapus" class="btn btn-danger">Hapus Data</button>
            </div>
            </form>

        <?php 
        if(isset($_POST['simpan'])){
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

            if($nama=='' || $kategori=='' || $harga==''){
                echo '<div class="alert alert-warning" role="alert">
                Nama, Kategori dan Harga wajib diisi !
                </div>';
            }else{
                $queryUpdate = mysqli_query($con, "UPDATE produk SET kategori_id='$kategori', nama='$nama', harga='$harga', detail='$detail', ketersediaan_stok='$stok' WHERE id=$id");

                echo '<meta http-equiv="refresh" content="0; url=produk.php" />';

                if($nama_file!=''){
                    if($image_size > 500000){
                        echo '<div class="alert alert-warning" role="alert">
                        foto tidak boleh lebih dari 500kb!
                        </div>';
                    }else{
                        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif'){
                            echo '<div class="alert alert-warning" role="alert">
                            file wajib bertipe jpg, png, atau gif
                            </div>';
                        }else{
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name );

                            $queryUpdate = mysqli_query($con, "UPDATE produk SET foto='$new_name' WHERE id='$id'");

                            if($queryUpdate){
                                echo '<div class="alert alert-success role="alert">
                                Foto Berhasil Diupdate
                                </div>
                                <meta http-equiv="refresh" content="2; url=produk.php" />';
                            }
                        }
                    }
                }
            }
        }

        if(isset($_POST['hapus'])){
            $queryHapus = mysqli_query($con, "DELETE FROM produk WHERE id='$id'");

            if($queryHapus){
                echo '<div class="alert alert-primary" role="alert">
                        kategori berhasil dihapus !
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php"/>';
            }
        }
        ?>
        </div>
    </div>



    <!-- js bootsrtap -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>