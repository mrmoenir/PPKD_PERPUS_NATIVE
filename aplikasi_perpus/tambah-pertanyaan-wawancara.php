<?php
session_start();
include 'config/config.php';
// kalo /jika session tidak ada, tolong redirect ke login
if (!isset($_SESSION['nama']))
    header("location:index.php?error=acces-failed");


// jika button disubmit, ambil nilai dari form, nama, email, password
if (isset($_POST['simpan'])) {
    $nama_pertanyaan = $_POST['nama_pertanyaaan'];
    $id_jurusan = $_POST['id_jurusan'];

    // masukkan ke dalam table user dimana kolom nama di ambil nilainya dari inputan nama 
    $insert = mysqli_query($koneksi, "INSERT INTO
        pertanyaan_wawancara (nama_pertanyaan,  id_jurusan)
        VALUES('$nama_pertanyaan','$id_jurusan')");
    header("location:pertanyaan_wawancara.php?notif=tambah-success");
}

// jika parameter delete ada, buat perintah/query delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = mysqli_query($koneksi, "DELETE FROM pertanyaan_wawancara WHERE id='$id'");
    header('location:pertanyaan_wawancara.php?notif=delete-success');
}

// tampilkan semua data dari tabel user dimana id nya di ambil dari params edit
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $queryEdit = mysqli_query($koneksi, "SELECT * FROM pertanyaan_wawancara WHERE id='$id'");
    $dataEdit  = mysqli_fetch_assoc($queryEdit);
}

if (isset($_POST['edit'])) {
    $nama_pertanyaan = $_POST['nama_pertanyaan'];
    $id_jurusan = $_POST['id_jurusan'];

    $id = $_GET['edit'];

    // ubah data dari table user dimana nilai nama di ambil dari inputan nama 
    // dan nilai id user nya di ambil dari parameter

    $edit = mysqli_query($koneksi, "UPDATE pertanyaan_wawancara SET 
        nama_pertanyaan='$nama_pertanyaan',
        id_jurusan ='$id_jurusan'
        WHERE id = '$id'");
    header("location:pertanyaan_wawancara.php?edit=berhasil");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="assets/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="assets/admin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'inc/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'inc/navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <?php if (isset($_GET['edit'])) { ?>
                        <h1 class="h3 mb-4 text-gray-800">Edit Pengguna</h1>
                    <?php } else { ?>
                        <h1 class="h3 mb-4 text-gray-800">Tambah Pengguna</h1>
                    <?php } ?>

                    <?php if (isset($_GET['edit'])) { ?>
                        <div class="card">
                            <div class="card-header">Edit Pertanyaan</div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="">Nama Pertanyaan</label>
                                        <input value="<?php echo $dataEdit['nama_pertanyaan'] ?>" type="text" class="form-control" name="nama_pertanyaan" placeholder="Masukkan Nama Lengkap Anda..">
                                    </div> 
                                    <div class="mb-3">
                                        <label for="">Jurusan</label>
                                        <select name="id_jurusan" id="" class="form-control">
                                            <option value="">Pilih Jurusan</option>
                                            <?php $queryJurusan = mysqli_query($koneksi, "SELECT * FROM jurusan"); ?>
                                            <?php while ($dataJurusan = mysqli_fetch_assoc($queryJurusan)) { ?>
                                                <option <?php echo ($dataEdit['id_jurusan'] == $dataJurusan['id']) ? 'selected' : '' ?> value="<?php echo $dataJurusan['id']; ?>"><?php echo $dataJurusan['nama_jurusan'] ?></option>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="edit" value="Ubah">
                                        <a href="user.php" class="btn btn-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="card">
                            <div class="card-header">Tambah Pertanyaan</div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <label for="">Nama Pertanyaan</label>
                                        <input type="text" class="form-control" name="nama_pertanyaaan" placeholder="Masukkan Nama Pertanyaan">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Jurusan</label>
                                        <select name="id_jurusan" id="" class="form-control">
                                            <option value="">Pilih Jurusan</option>
                                            <?php $queryJurusan = mysqli_query($koneksi, "SELECT * FROM jurusan"); ?>
                                            <?php while ($dataJurusan = mysqli_fetch_assoc($queryJurusan)) { ?>
                                                <option value="<?php echo $dataJurusan['id']; ?>"><?php echo $dataJurusan['nama_jurusan'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <input type="submit" class="btn btn-primary" name="simpan" value="Simpan">
                                        <a href="user.php" class="btn btn-danger">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="assets/admin/vendor/jquery/jquery.min.js"></script>
    <script src="assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="assets/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="assets/admin/js/sb-admin-2.min.js"></script>

</body>

</html>