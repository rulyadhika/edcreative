<?= $this->extend("user/layout/template"); ?>
<?= $this->section("main-container"); ?>

<div class="container main-container detail-page">
    <div class="py-4 py-md-5 px-0 px-md-5">
        <div class="border-bottom mb-4 pb-2">
            <h1 class="mb-2 content-title">
                <?= esc($data_post['judul']); ?>
            </h1>
            <div class="d-flex justify-content-between flex-wrap text-muted post-info">
                <small class="mr-2 d-inline-block">Kategori :
                    <a href="<?= base_url("kategori/" . strtolower($data_post['nama_kategori'])); ?>"><?= esc($data_post['nama_kategori']); ?></a>
                    | <span class="badge badge-success">Gratis</span>
                </small>
                <small>
                    <i class="fa fa-pen mr-1"></i> <?= date("d-m-Y", strtotime($data_post['created_at'])); ?>
                </small>
            </div>
        </div>
        <div class="post-thumbnail">
            <img src="<?= base_url('src/images/thumbnail/' . $data_post['thumbnail']); ?>" alt="">
        </div>
        <div class="ck-content">
            <?= str_replace('&nbsp;', ' ', $data_post['content']); ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>