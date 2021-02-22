<?= $this->extend("admin/layout/template"); ?>

<?= $this->section("main-container"); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola User</h1>
</div>

<?php if (session()->getFlashdata('sukses')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('sukses'); ?>
    </div>
<?php elseif (session()->getFlashdata('failed')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('failed'); ?>
    </div>
<?php endif; ?>

<?php $errors = session()->getFlashdata('errors');
$i = 1; ?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between flex-wrap">
        <h6 class="m-0 my-auto font-weight-bold text-primary"><?= $page; ?></h6>
    </div>
    <div class="card-body">
        <table id="example" class="display table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['email']; ?></td>
                        <td>
                            <?php if ($user['role'] == 'dev') : ?>
                                <span class="badge badge-dark"><?= $user['role']; ?></span>
                            <?php elseif ($user['role'] == 'superadmin') : ?>
                                <span class="badge badge-success"><?= $user['role']; ?></span>
                            <?php elseif ($user['role'] == 'admin') : ?>
                                <span class="badge badge-info"><?= $user['role']; ?></span>
                            <?php else : ?>
                                <span class="badge badge-warning"><?= $user['role']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['role'] == 'dev' && (in_groups('dev') == false)) : ?>
                                -
                            <?php else : ?>
                                <a href="javascript:void(0)" class="badge badge-primary edit-btn" data-id="<?= $user['user_id']; ?>">Ubah</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="userModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <form action="<?= base_url("admin/user/update") ?>" method="POST" id="form-kategori">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id">
                    <input type="hidden" name="old_role">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control  <?= isset($errors['role']) ? 'is-invalid' : '' ?>" id="role" name="role">
                            <?php foreach ($roles as $role) : ?>
                                <?php if ($role['name'] == 'dev' && (in_groups('dev') == false)) : ?>
                                <?php else : ?>
                                    <option value="<?= $role['name']; ?>"><?= ucwords($role['name']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <div id="validationServer03Feedback" class="invalid-feedback d-block">
                            <?= isset($errors['role']) ? $errors['role'] : ''; ?>
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
                targets: [4]
            }],
            responsive: true
        });
    });

    $(".edit-btn").on("click", function(e) {
        $.ajax({
            type: "GET",
            url: "<?= base_url("admin/user/getSingleData"); ?>",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                id: $(this).data("id")
            },
            dataType: "JSON",
            success: function(data) {

                $('input[id="email"]').val(data.email);
                $('input[id="username"]').val(data.username);
                $('select[name="role"]').val(data.role);

                $('input[name="id"]').val(data.user_id);
                $('input[name="old_role"]').val(data.role);

                $('#userModal').modal('show')
            }
        });
    })
</script>

<?php if ($errors) : ?>
    <script>
        $('#userModal').modal('show');
    </script>
<?php endif; ?>
<?= $this->endSection(); ?>