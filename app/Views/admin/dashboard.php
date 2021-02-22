<?= $this->extend("admin/layout/template"); ?>

<?= $this->section("pageStyling"); ?>
<style>
    .pagination>li>a,
    .pagination>li>span {
        color: #5A5C69 !important;
    }

    .pagination>li.active>a,
    .pagination>li.active>span {
        background-color: #5A5C69 !important;
        color: white !important;
        border: unset !important;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section("main-container"); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<?php $i = 1; ?>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Kategori Postingan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($kategori_postingan); ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-sticky-note fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Postingan Ditampilkan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $postingan_ditampilkan; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-clipboard-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Postingan Diarsipkan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $postingan_diarsipkan; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fa fa-archive fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Jumlah User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_user; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pengelompokan Postingan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table id="example" class="display table table-hover font-weight-bold" style="width:100%">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Ditampilkan</th>
                            <th>Diarsipkan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rincian_postingan as $rp) : ?>
                            <tr class="text-center">
                                <td><?= $i++; ?></td>
                                <td><?= $rp['nama_kategori']; ?></td>
                                <td class="text-success"><?= $rp['ditampilkan']; ?></td>
                                <td class="text-danger"><?= $rp['diarsipkan']; ?></td>
                                <td class="text-primary"><?= $rp['total']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>

<?= $this->section("pageScript"); ?>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            searching: false,
            lengthChange: false
        });
    });
</script>

<?= $this->endSection(); ?>