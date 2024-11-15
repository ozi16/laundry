<?php
include 'koneksi.php';
session_start();
$queryCustomer = mysqli_query($koneksi, "SELECT * FROM customer");
$queryPaket = mysqli_query($koneksi, "SELECT * FROM type_of_service");

$rowPaket = [];
while ($data = mysqli_fetch_assoc($queryPaket)) {
    $rowPaket[] = $data;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $id_level = $_POST['id_paket'];

    $sql = "INSERT INTO user (id_level,nama,email,username,password) VALUES ('$id_level','$nama','$email','$username','$password')";
    $result = mysqli_query($koneksi, $sql);
    if ($result) {
        header("Location: trans_order.php");
    } else {
        echo "Error disimpan";
        echo mysqli_error($koneksi);
    }
}
// Parameter Edit
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($koneksi, "SELECT * FROM user WHERE id = '$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['edit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_level = $_POST['id_level'];

    //jika password di isi oleh user
    if ($_POST['password']) {
        $password = $_POST['password'];
    } else {
        $password = $rowEdit['password'];
    }

    $update = mysqli_query($koneksi, "UPDATE user SET id_level='$id_level', nama='$nama', email='$email', password='$password' WHERE id='$id'");
    header("location:user.php?ubah=berhasil");
}

// if (isset($_GET['delete'])) {
//   $id = $_GET['id'];
//   $delete = mysqli_query($koneksi, "DELETE FROM user WHERE id='$id'");
//   header("location:user.php?delete=berhasil");
// }


?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
-->
<!-- beautify ignore:start -->
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="assets/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Analytics | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <?php include 'inc/head.php' ?>
</head>
<style>
    placeholder {
        margin-top: 2rem;
    }
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <?php include 'inc/sidebar.php' ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include 'inc/nav.php' ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card mt-5">
                                    <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Transaksi</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])) : ?>
                                            <div class="alert alert-success" role="alert">
                                                Data berhasil Di hapus
                                            </div>
                                        <?php endif; ?>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-12 mb-4">
                                                    <label for="">Pilih Customer</label>
                                                    <select class="form-control" name="id_level" id="">
                                                        <option value="">--Pilih Customer--</option>
                                                        <?php while ($rowCustomer = mysqli_fetch_assoc($queryCustomer)) {
                                                            // if (isset($_GET['edit']) && $rod'w['i] == $rowEdit['id_level']) {
                                                            //   $selected = 'selected';
                                                            // } else {
                                                            //   $selected = '';
                                                            // }
                                                        ?>
                                                            <option value="<?php echo $rowCustomer['id'] ?>"><?php echo $rowCustomer['customer_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6 mb-4">
                                                    <label for="">No Invoice</label>
                                                    <input type="text" class="form-control" placeholder="Masukan Invoice" readonly>
                                                </div>
                                                <div class="col-sm-6 mb-4">
                                                    <label for="">Tanggal Laundry</label>
                                                    <input type="date" class="form-control" name="password" id="" placeholder="Masukan Pelanggan">
                                                </div>

                                                <div class="col-sm-6">
                                                    <button type="submit" class=" btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card mt-5">
                                    <div class="card-header">Detail Transaksi</div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])) : ?>
                                            <div class="alert alert-success" role="alert">
                                                Data berhasil Di hapus
                                            </div>
                                        <?php endif; ?>

                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="mb-3 row">
                                                <div class="col-sm-3 mb-4">
                                                    <label for="">Pilih Paket</label>
                                                </div>
                                                <div class="col-9">
                                                    <select class="form-control" name="id_service[]" id="">
                                                        <option value="">--Pilih Paket--</option>
                                                        <?php foreach ($rowPaket as $key => $value) { ?>
                                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['service_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mb-4">
                                                    <label for="">QTY</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control" name="qty" placeholder="Masukan QTY">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <div class="col-sm-3 mb-4">
                                                    <label for="">Pilih Paket</label>
                                                </div>
                                                <div class="col-9">
                                                    <select class="form-control" name="id_service[]" id="">
                                                        <option value="">--Pilih Paket--</option>
                                                        <?php foreach ($rowPaket as $key => $value) {

                                                        ?>
                                                            <option value="<?php echo $value['id'] ?>"><?php echo $value['service_name'] ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mb-4">
                                                    <label for="">QTY</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="number" class="form-control" name="qty" placeholder="Masukan QTY">
                                                </div>



                                                <div class="col-sm-6">
                                                    <button type="submit" class=" btn btn-primary" name="<?php echo isset($_GET['edit']) ? 'edit' : 'simpan' ?>">Simpan</button>
                                                </div>
                                            </div>


                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- / Content -->

                    <!-- Footer -->
                    <div class="container">
                        <div class="row ">
                            <?php include 'inc/footer.php' ?>
                        </div>
                    </div>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div> -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="assets/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/assets/vendor/js/bootstrap.js"></script>
    <script src="assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="assets/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="assets/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>