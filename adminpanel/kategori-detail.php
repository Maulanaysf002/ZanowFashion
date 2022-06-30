<?php 
    require '../koneksi.php';
    require 'session.php';

    $id=$_GET['p'];

    $query = mysqli_query($con, "SELECT * FROM kategori WHERE id='$id'");
    $data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zanow | Kategori Detail</title>

    <!-- css bootstrap 5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- css manual -->
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- navbar component -->
    <?php require 'navbar.php'; ?>

<div class="container mt-3">
    <h2>Detail Kategori</h2>
        <div class="col-12 col-md-6">
            <form action="" method="POST">
                <div>
                <label for="kategori" class="form-label">Kategori</label>
                <input type="text" name="kategori" id="kategori" value="<?php echo $data['nama'];?>" class="form-control">
                </div>
                <div class="mt-4 mb-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary" name="editbtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="deletebtn">Delete</button>
                </div>
            </form>
            <!-- logic php -->
            <?php 
            if(isset($_POST['editbtn'])){
                $kategori = htmlspecialchars($_POST['kategori']);

                if($data['nama'] == $kategori){
                    echo '<meta http-equiv="refresh" content="0; url=kategori.php" />';
                }else{
                    $query = mysqli_query($con, "SELECT * FROM kategori WHERE nama='$kategori'");
                    $jumlahdata = mysqli_num_rows($query);
                    
                    if($jumlahdata > 0){
                        echo '<div class="alert alert-warning" role="alert">
                        kategori sudah ada !
                        </div>';
                    }else{
                        $querySimpan = mysqli_query($con, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                        if($querySimpan){
                    echo '<div class="alert alert-success role="alert">
                            kategori berhasil diupdate
                            </div>
                            <meta http-equiv="refresh" content="0; url=kategori.php" />';
                }else{
                    echo mysqli_error($con);
                }
                    }
                }
            }

            // delete logic
            if(isset($_POST['deletebtn'])){
                $queryCek = mysqli_query($con, "SELECT * FROM produk WHERE kategori_id='$id'");
                $dataCount = mysqli_num_rows($queryCek);

                if($dataCount > 0 ){
                    echo '<div class="alert alert-warning" role="alert">
                        kategori Tidak Bisa Dihapus Karena Ada Produk!!!
                        </div>';
                        die();
                }

                $querydelete = mysqli_query($con, "DELETE FROM kategori WHERE id='$id'");
                if($querydelete){
                echo '<div class="alert alert-primary" role="alert">
                        kategori berhasil dihapus !
                        </div>
                        <meta http-equiv="refresh" content="0; url=kategori.php"/>';
                }else{
                    echo mysqli_error($con);
                }
            }
            ?>
        </div>
</div>

    <!-- js bootsrtap -->
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>