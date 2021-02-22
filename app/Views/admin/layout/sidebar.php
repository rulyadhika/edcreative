<?php

$db = db_connect();

$parentMenu = $db->table("menu_admin_page")->get()->getResultArray();

?>

<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-0">Admin - Ed Creative</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item  <?= ($page == 'Dashboard') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url("admin/dashboard"); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php foreach ($parentMenu as $p) : ?>
        <div class="sidebar-heading">
            <?= $p['nama']; ?>
        </div>

        <?php $subMenu = $db->table("submenu_admin_page")->where("parent_id", $p['id'])->get()->getResultArray(); ?>
        <?php foreach ($subMenu as $s) : ?>

            <?php if ($s['nama'] == 'List Users') : ?>
                <?php if (in_groups(['superadmin', 'dev'])) : ?>
                    <li class="nav-item <?= $page == $s['nama'] ? 'active' : ''; ?>">
                        <a class="nav-link" href="<?= base_url($s['url']) ?>">
                            <i class="<?= $s['icon']; ?>"></i>
                            <span><?= $s['nama']; ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php else : ?>
                <li class="nav-item <?= $page == $s['nama'] ? 'active' : ''; ?>">
                    <a class="nav-link" href="<?= base_url($s['url']) ?>">
                        <i class="<?= $s['icon']; ?>"></i>
                        <span><?= $s['nama']; ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>

        <hr class="sidebar-divider">
    <?php endforeach; ?>


    <!-- Heading -->
    <!-- <div class="sidebar-heading">
        Addons
    </div> -->

    <!-- Nav Item - Pages Collapse Menu -->
    <!-- <li class="nav-item active">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="login.html">Login</a>
                <a class="collapse-item" href="register.html">Register</a>
                <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="404.html">404 Page</a>
                <a class="collapse-item active" href="blank.html">Blank Page</a>
            </div>
        </div>
    </li> -->

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>