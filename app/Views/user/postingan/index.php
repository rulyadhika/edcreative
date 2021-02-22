<?= $this->extend("user/layout/template"); ?>
<?= $this->section("main-container"); ?>

<div class="container mt-5 py-5 main-container">
    <h4 class="mb-1" style="font-weight: 600;">Pembelajaran Kategori <?= ucwords(esc($kategori)); ?></h4>
    <small class="text-muted d-block mb-2">Tersedia <?= count($post); ?> Pembelajaran</small>
    <div class="content-grid row">
        <?php if (count($post) == 0) : ?>
            <div class="col mt-4">
                <small class="d-block text-center font-italic">Belum ada pembelajaran yang tersedia. Kembali ke <a href="<?= base_url(); ?>">beranda</a>.</small>
            </div>
        <?php else : ?>
            <?php foreach ($post as $p) : ?>
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