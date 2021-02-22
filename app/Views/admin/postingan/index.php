<?= $this->extend("admin/layout/template"); ?>

<?= $this->section("pageStyling"); ?>
<style>
    tr td img {
        width: 160px;
        max-height: 80px;
        object-fit: cover;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section("main-container"); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Postingan</h1>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('sukses'); ?>
    </div>
<?php elseif (session()->getFlashdata('errorDelete')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('errorDelete'); ?>
    </div>
<?php endif; ?>
<?php $i = 1; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between flex-wrap">
        <h6 class="m-0 my-auto font-weight-bold text-primary"><?= $page; ?></h6>
        <a class="btn btn-sm btn-primary" href="<?= base_url("admin/postingan/add"); ?>">Tambah Postingan</a>
    </div>
    <div class="card-body">
        <table id="example" class="display table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Thumbnail</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($d['judul']); ?></td>
                        <td><?= esc($d['nama_kategori']); ?></td>
                        <td>
                            <img src="<?= base_url("src/images/thumbnail/" . $d['thumbnail']) ?>" alt="">
                        </td>
                        <td class="text-<?= $d['data_status'] == 'ditampilkan' ? 'success' : 'danger' ?>"><?= ucfirst($d['data_status']); ?></td>
                        <td>
                            <a href="<?= base_url("admin/postingan/edit/" . $d['slug']) ?>" class="badge badge-primary">Ubah</a>
                            <form action="<?= base_url("admin/postingan/delete/" . $d['slug']); ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" data-target="<?= $d['slug']; ?>" class="badge badge-danger del-btn" style="outline:unset;border:unset;">Hapus</button>
                                <button type="submit" data-id="<?= $d['slug']; ?>" style="display:none;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("pageScript"); ?>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            columnDefs: [{
                orderable: false,
                targets: [3, 5]
            }],
            responsive: true
        });
    });

    $(".del-btn").on("click", function() {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data yang telah dihapus tidak bisa dikembalikan lagi!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`button[data-id=${$(this).data('target')}]`).click();
            }
        })
    })
</script>
<?= $this->endSection(); ?>