<?= $this->extend("admin/layout/template"); ?>

<?= $this->section("main-container"); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Kategori</h1>
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

<?php $errors = session()->getFlashdata('errors');
$i = 1; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between flex-wrap">
        <h6 class="m-0 my-auto font-weight-bold text-primary"><?= $page; ?></h6>
        <button class="btn btn-sm btn-primary tambah-btn" data-toggle="modal" data-target="#kategoriModal">Tambah Kategori</button>
    </div>
    <div class="card-body">
        <table id="example" class="display table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= esc($d['nama_kategori']); ?></td>
                        <td>
                            <a href="javascript:void(0)" class="badge badge-primary edit-btn" data-id="<?= $d['id']; ?>">Ubah</a>
                            <form action="<?= base_url("admin/kategori/delete/" . $d['id']); ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" data-target="<?= $d['id']; ?>" class="badge badge-danger del-btn" style="outline:unset;border:unset;">Hapus</button>
                                <button type="submit" data-id="<?= $d['id']; ?>" style="display:none;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kategoriModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="kategoriModalLabel" aria-hidden="true">
    <form action="<?= base_url("admin/kategori/insert") ?>" method="POST" id="form-kategori">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control <?= isset($errors['nama_kategori']) ? 'is-invalid' : '' ?>" id="nama_kategori" name="nama_kategori" placeholder="Masukan nama kategori">
                        <div id="validationServer03Feedback" class="invalid-feedback d-block">
                            <?= isset($errors['nama_kategori']) ? $errors['nama_kategori'] : ''; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection(); ?>

<?= $this->section("pageScript"); ?>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            columnDefs: [{
                orderable: false,
                targets: [2]
            }],
            responsive: true
        });
    });

    $(".edit-btn").on("click", function(e) {
        $.ajax({
            type: "GET",
            url: "<?= base_url("admin/kategori/getSingleData"); ?>",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                id: $(this).data("id")
            },
            dataType: "JSON",
            success: function(data) {

                $("#form-kategori").attr("action", "<?= base_url("admin/kategori/update"); ?>");
                $("#kategoriModalLabel").text("Ubah Kategori");
                $('input[name="nama_kategori"]').val(data.nama_kategori);
                $('input[name="id"]').val(data.id);

                $('#kategoriModal').modal('show')
            }
        });
    })

    $(".tambah-btn").on("click", () => {
        $("#form-kategori").attr("action", "<?= base_url("admin/kategori/insert"); ?>");
        $("#kategoriModalLabel").text("Tambah Kategori");
        $('input[name="nama_kategori"]').val("");
        $('input[name="id"]').val("");
    })

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

<?php if ($errors) : ?>
    <script>
        $('#kategoriModal').modal('show');
    </script>
<?php endif; ?>
<?= $this->endSection(); ?>