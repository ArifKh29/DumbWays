<?php

$host       = "localhost";
$user       = "root";
$password   = "";
$database   = "dumbways";
$koneksi    = mysqli_connect($host, $user, $password, $database);

// QUERY Ambil Data Penulis
$getBook = mysqli_query($koneksi, "SELECT *, writer_tb.name as writer_name, category_tb.category_name as category_name FROM `book_tb` JOIN category_tb JOIN writer_tb ON book_tb.category_id=category_tb.category_id AND book_tb.writer_id=writer_tb.writer_id");

$getPenulis = mysqli_query($koneksi, "SELECT `writer_id`, `name` FROM `writer_tb`");

$getAddPenulis = mysqli_query($koneksi, "SELECT `writer_id`, `name` FROM `writer_tb`");
$getPopPenulis = mysqli_query($koneksi, "SELECT `writer_id`, `name` FROM `writer_tb`");
$getKategori = mysqli_query($koneksi, "SELECT `category_id`, `category_name` FROM `category_tb`");
$getAddKategori = mysqli_query($koneksi, "SELECT `category_id`, `category_name` FROM `category_tb`");

$getPopKategori = mysqli_query($koneksi, "SELECT `category_id`, `category_name` FROM `category_tb`");

if (isset($_POST['addKategori'])) {
    $nama = $_POST['namaKategori'];
    mysqli_query($koneksi, "INSERT INTO `category_tb`(`category_id`, `category_name`) VALUES ('','$nama')");
    echo "<script>alert('Tambah Kategori Berhasil !');window.location.href = '4.php';</script>";
}

if (isset($_GET['hpuskategori'])) {
    $id = $_GET['hpuskategori'];
    mysqli_query($koneksi, "DELETE FROM `category_tb` WHERE `category_id`='$id'");
    echo "<script>alert('Kategori Berhasil dihapus !');window.location.href = '4.php';</script>";
}

if (isset($_POST['addWriter'])) {
    $nama = $_POST['namaPenulis'];
    mysqli_query($koneksi, "INSERT INTO `writer_tb`(`writer_id`, `name`) VALUES ('','$nama')");
    echo "<script>alert('Tambah Penulis Berhasil !');history.go(-1);</script>";
}

if (isset($_GET['hpuswriter'])) {
    $id = $_GET['hpuswriter'];
    mysqli_query($koneksi, "DELETE FROM `writer_tb` WHERE `writer_id`='$id'");
    echo "<script>alert('Penulis Berhasil dihapus !');window.location.href = '4.php';</script>";
}

if (isset($_POST['ubahpenulis'])) {
    $id = $_POST['id'];
    $name = $_POST['namaPenulis'];
    mysqli_query($koneksi, "UPDATE `writer_tb` SET `name`='$name' WHERE `writer_id`='$id'");
    echo "<script>alert('Penulis Berhasil diubah !');window.location.href = '4.php';</script>";
}

if (isset($_POST['addBook'])) {
    if (!isset($_FILES['image'])) {
        echo "<script>alert('Gambar Kosong !')</script>";
    } else {
        $image   = addslashes(file_get_contents($_FILES['image']['tmp_name']));
        $nmbuku = $_POST['namabuku'];
        $penulis = $_POST['namapenulis'];
        $kategori = $_POST['namakategori'];
        $publikasi = $_POST['publikasi'];
        //$image_name = addslashes($_FILES['image']['name']);
        $image_size = getimagesize($_FILES['image']['tmp_name']);
        if ($image_size == false) {
            echo "<script>alert('Gambar Salah !')</script>";
        } else {
            if (!$insert = mysqli_query($koneksi, "INSERT INTO `book_tb`(`id`, `name`, `category_id`, `writer_id`, `publication`, `img`) VALUES ('','$nmbuku','$kategori','$penulis','$publikasi','$image')")) {
                echo "<script>alert('Gambar Gagal diupload !')</script>";
            } else {
                // Informasi berhasil dan kembali ke inputan
                echo "<script>alert('Gambar Berhasil diupload !');history.go(-1);</script>";
            }
        }
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        

        #addBook {
            display: none;
        }

        #addWriter {
            display: none;
        }

        #addKategori {
            display: none;
        }
    </style>

</head>

<body>
    <div class="main">
        <nav class="navbar bg-light">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="4.php">Dump Library</a>
                </div>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" onclick="addBook()"><span class="glyphicon glyphicon-user"></span> Add Book</a></li>
                    <li><a href="#" onclick="addWriter()"><span class="glyphicon glyphicon-log-in"></span> Add Writer</a></li>
                    <li><a href="#" onclick="addKategori()"><span class="glyphicon glyphicon-user"></span> Add Category</a></li>
                </ul>
            </div>
        </nav>

        <!-- FORM ADD WRITER -->

        <div class="container" id="addWriter">
            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Penulis</label>
                    <input type="text" name="namaPenulis" class="form-control" placeholder="Masukan Nama Penulis">

                </div>


                <button type="submit" name="addWriter" class="btn btn-primary">Submit</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th colspan="2" class="text-center" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_array($getPenulis)) {
                    ?>
                        <tr>
                            <th scope="row"><?= $no++ ?></th>
                            <td><?= $row['name'] ?></td>
                            <td class="text-center"><button data-toggle="modal" data-target="#editWriter<?= $row['writer_id'] ?>">Ubah</button></td>
                            <td class="text-center"><a href="./4.php?hpuswriter=<?= $row['writer_id'] ?>"><button>Hapus</button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- FORM ADD Kategori -->

        <div class="container" id="addKategori">
            <form action="./4.php" method="POST">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="namaKategori" class="form-control" placeholder="Masukan Nama Kategori">

                </div>


                <button type="submit" name="addKategori" class="btn btn-primary">Submit</button>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kategori</th>
                        <th colspan="2" class="text-center" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_array($getKategori)) {
                    ?>
                        <tr>
                            <th scope="row"><?= $no++ ?></th>
                            <td><?= $row['category_name'] ?></td>
                            <td class="text-center"><button data-toggle="modal" data-target="#editKategori<?= $row['category_id'] ?>">Ubah</button></td>
                            <td class="text-center"><a href="?hpuskategori=<?= $row['category_id'] ?>"><button>Hapus</button></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- FORM ADD BOOK -->

        <div class="container" id="addBook">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" class="form-control" name="namabuku" placeholder="Masukan Nama" required>
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <select class="form-control" name="namapenulis">
                        <?php
                        while ($row = mysqli_fetch_array($getAddPenulis)) {
                        ?>
                            <option value="<?= $row['writer_id'] ?>"><?= $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="namakategori">
                        <?php
                        while ($row = mysqli_fetch_array($getAddKategori)) {
                        ?>
                            <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Publikasi</label>
                    <input type="text" name="publikasi" class="form-control" placeholder="Kategori" required>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" placeholder="Pilih Gambar" required>
                </div>


                <button type="submit" name="addBook" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <!-- LIST BOOK -->

        <div class="container" id="bukulist">
            <div class="row">
                <?php
                while ($row = mysqli_fetch_array($getBook)) {
                ?>
                    <div class="col-sm-3 mb-3">
                        <div class="card text-center" style="width: 18rem;">
                            <?= '<img style="height: 150px; width:100px;" src="data:image/jpeg;base64,' . base64_encode($row['img']) . '"/>'; ?>
                            <!-- <img class="card-img-top" src="img.jpg" alt="Card image cap" style="max-height: 200px; max-width:100px;"> -->
                            <div class="card-body text-center">
                                <strong>
                                    <p alig class="card-text"><?= $row['name'] ?></p>
                                </strong>
                                <button data-toggle="modal" data-target="#detail<?= $row['id'] ?>" class="btn btn-primary">View Details</button>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Modal Detail Buku -->
        
        <?php 
        $getPopBook = mysqli_query($koneksi, "SELECT book_tb.id as id_buku, book_tb.name as nama_buku, writer_tb.name as writer_name, book_tb.img as gambar, category_tb.category_name as kategori, book_tb.publication as publikasi FROM `book_tb` JOIN category_tb JOIN writer_tb ON book_tb.category_id=category_tb.category_id AND book_tb.writer_id=writer_tb.writer_id");
        while ($row = mysqli_fetch_array($getPopBook)) { ?>
            <div class="modal fade" id="detail<?= $row['id_buku'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Penulis</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Judul Buku</label>
                                    <input type="text" class="form-control" name="namabuku" id="namabuku" placeholder="Masukan Nama" value="<?= $row['nama_buku'] ?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label>Penulis</label>
                                    <select class="form-control" name="namapenulis" id="namapenulis" readonly>
                                        <option value="<?= $row['writer_id'] ?>"><?= $row['writer_name'] ?></option>
                                        <?php
                                        $getPopAddPenulis = mysqli_query($koneksi, "SELECT `writer_id`, `name` FROM `writer_tb`");
                                        while ($rows = mysqli_fetch_array($getPopAddPenulis)) {
                                        ?>
                                            <option value="<?= $rows['writer_id'] ?>"><?= $rows['name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control" name="namakategori" id="namakategori" readonly>
                                        <option><?= $row['kategori'] ?></option>
                                        <?php
                                        $getPopAddKategori = mysqli_query($koneksi, "SELECT `category_id`, `category_name` FROM `category_tb`");
                                        while ($rowz = mysqli_fetch_array($getPopAddKategori)) {
                                        ?>
                                            <option value="<?= $rowz['category_id'] ?>"><?= $rowz['category_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Publikasi</label>
                                    <input type="text" class="form-control" name="namapublikasi" id="namapublikasi" placeholder="Masukan Nama" value="<?= $row['publikasi'] ?>" required readonly>
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <?= '<img style="height: 150px; width:100px;" src="data:image/jpeg;base64,' . base64_encode($row['gambar']) . '"/>'; ?>
                                    <input type="file" name="image" class="form-control" placeholder="Pilih Gambar" required>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="btnEdit" onclick="edit()" name="edit" class="btn btn-primary">Edit</button>
                                <button type="submit" id="btnSimpan" name="simpanedit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>

        <!-- Modal Edit Writer -->
        <?php while ($row = mysqli_fetch_array($getPopPenulis)) { ?>
            <div class="modal fade" id="editWriter<?= $row['writer_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Penulis</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Penulis</label>
                                    <input type="hidden" name="id" value="<?= $row['writer_id'] ?>">
                                    <input type="text" name="namaPenulis" class="form-control" placeholder="Masukan Nama Penulis" value="<?= $row['name'] ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="ubahpenulis" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>

        <!-- Modal Edit Kategori -->
        <?php while ($row = mysqli_fetch_array($getPopKategori)) { ?>
            <div class="modal fade" id="editKategori<?= $row['category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="" method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Kategori</label>
                                    <input type="hidden" name="id" value="<?= $row['category_id'] ?>">
                                    <input type="text" name="namaKategori" class="form-control" placeholder="Masukan Nama Kategori" value="<?= $row['category_name'] ?>">

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="ubahpenulis" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>





</body>


</html>

<script>
    function addBook() {
        var addBook = document.getElementById("addBook");
        var listBook = document.getElementById("bukulist");
        var addKategori = document.getElementById("addKategori");
        var addWriter = document.getElementById("addWriter");
        if (addBook.style.display === "block") {
            addBook.style.display = "none";
            addKategori.style.display = "none";
            addWriter.style.display = "none";
            listBook.style.display = "block";
        } else {
            addWriter.style.display = "none";
            addKategori.style.display = "none";
            listBook.style.display = "none";
            addBook.style.display = "block";
        }
    }

    function edit() {
        document.getElementById("btnEdit").style.visibility = "hidden";
    }

    function addWriter() {
        var addBook = document.getElementById("addBook");
        var addWriter = document.getElementById("addWriter");
        var addKategori = document.getElementById("addKategori");
        var listBook = document.getElementById("bukulist");
        if (addWriter.style.display === "block") {
            addWriter.style.display = "none";
            addBook.style.display = "none";
            addKategori.style.display = "none";
            listBook.style.display = "block";
        } else {
            listBook.style.display = "none";
            addBook.style.display = "none";
            addKategori.style.display = "none";
            addWriter.style.display = "block";
        }
    }
    

    function addKategori() {
        var addBook = document.getElementById("addBook");
        var addWriter = document.getElementById("addWriter");
        var addKategori = document.getElementById("addKategori");
        var listBook = document.getElementById("bukulist");
        if (addKategori.style.display === "block") {
            addWriter.style.display = "none";
            addBook.style.display = "none";
            addKategori.style.display = "none";
            listBook.style.display = "block";
        } else {
            listBook.style.display = "none";
            addBook.style.display = "none";
            addWriter.style.display = "none";
            addKategori.style.display = "block";
        }
    }
</script>