<?php

$db = db_connect();
$kategori = $db->table("tb_kategori")->get()->getResultArray();

?>

<nav class="navbar fixed-top navbar-expand-lg shadow-sm navbar-light bg-white border-bottom">
    <div class="container navbar-container py-2">
        <a class="navbar-brand" href="<?= base_url(); ?>">Ed Creative</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kategori
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php foreach ($kategori as $ktgr) : ?>
                            <a class="dropdown-item" href="<?= base_url("kategori/" . strtolower($ktgr['nama_kategori'])); ?>"><?= esc($ktgr['nama_kategori']); ?></a>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Tentang</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link " href="<?= base_url(); ?>"><i class="fa fa-search"></i></a>
                </li>
                <?php if (logged_in()) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= user()->toArray()['username']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <?php if (in_groups(['admin', 'superadmin', 'dev'])) : ?>
                                <a class="dropdown-item" href="<?= base_url("admin/dashboard"); ?>">Dashboard Admin</a>
                            <?php endif; ?>
                            <a class="dropdown-item" href="<?= base_url("logout"); ?>">Keluar</a>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?= base_url("login"); ?>">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link daftar-btn" href="<?= base_url("register"); ?>">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>