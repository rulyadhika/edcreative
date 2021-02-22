<?= $this->extend("user/layout/template"); ?>
<?= $this->section("main-container"); ?>

<?php $db = db_connect();
$list_kategori = $db->table("tb_kategori")->get()->getResultArray();
?>

<div class="banner">
    <div class="banner-box-content">
        <h1>Cari Hal Yang Ingin Kamu Pelajari</h1>
        <p>Pendidikan adalah merupakan senjata yang paling mematikan di dunia, karena hanya dengan pendidikan kamu
            bisa mengubah dunia.</p>
        <div class="form-wrapper">
            <form action="<?= base_url("pencarian/"); ?>" method="GET">
                <div class="row no-gutters">
                    <div class="col-8 pr-1 input-wrapper">
                        <i class="fa fa-search"></i>
                        <input type="text" name="query" placeholder="Pencarian ..." required>
                    </div>
                    <div class="col-4">
                        <select id="inputState" name="kategori" required>
                            <option value="semua">Semua Kategori</option>
                            <?php foreach ($list_kategori as $list) : ?>
                                <option value="<?= strtolower($list['nama_kategori']); ?>"><?= esc($list['nama_kategori']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" style="display: none;">search</button>
            </form>
        </div>
    </div>

</div>

<div class="container py-5 main-container">
    <h4 class="mb-1" style="font-weight: 600;">Pembelajaran Terbaru</h4>
    <small class="text-muted d-block mb-2">Materi pembelajaran terbaru dari berbagai kategori</small>
    <div class="content-grid row">
        <?php if (count($post_terbaru) == 0) : ?>
            <div class="col mt-4">
                <small class="d-block text-center font-italic">Belum ada pembelajaran terbaru. Stay tune!</small>
            </div>
        <?php else : ?>
            <?php foreach ($post_terbaru as $p) : ?>
                <div class="card-wrapper col-md-4">
                    <a class="card shadow-sm" href="<?= base_url('read/' . $p['slug']); ?>">
                        <div class="card-img">
                            <i class="fa fa-book-open"></i>
                            <img src="<?= base_url("src/images/thumbnail/" . $p['thumbnail']); ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h6 class="card-title"><?= esc($p['judul']); ?></h6>
                            <small class="text-muted"><?= esc($p['nama_kategori']); ?></small>
                            <span class="badge badge-success float-right">Gratis</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section("pageScript"); ?>
<script>
    $("select[name='kategori']").on("change", function() {
        if ($("input[name='query']").val() != "") {
            $("button[type='submit']").click();
        }
    });
</script>
<?= $this->endSection(); ?>