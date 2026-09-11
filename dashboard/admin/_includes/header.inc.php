<?php
if (empty($_SESSION['admin_email']) && isset($conn) && !empty($_SESSION['user_id'])) {
    $admin_id_sess = $_SESSION['user_id'];
    $fetch_email_q = $conn->query("SELECT email FROM admin WHERE id = '{$admin_id_sess}'");
    if ($fetch_email_q && $r = $fetch_email_q->fetch_assoc()) {
        $_SESSION['admin_email'] = $r['email'];
    }
}
?>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-15">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <!-- profile start -->
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <!-- <div class="image">
                                        <img src="assets/images/profile/profile-image.png" alt="">
                                    </div> -->
                                    <div>
                                        <h6 class="fw-500">Admin</h6>
                                        <!-- <p>Admin</p> -->
                                    </div>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profile">
                            <li>
                                <div class="author-info p-3 border-bottom">
                                    <div class="content">
                                        <h6 class="text-sm fw-bold mb-0">Administrator</h6>
                                        <span class="text-muted text-xs"><?= htmlspecialchars($_SESSION['admin_email'] ?? 'admin@gmail.com') ?></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="<?= ROOT_URL ?>dashboard/admin/settings.php">
                                    <i class="lni lni-key me-2"></i> Change Password
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="<?= ROOT_URL ?>dashboard/admin/logout.php">
                                    <i class="lni lni-exit me-2"></i> Sign Out
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- profile end -->
                </div>
            </div>
        </div>
    </div>
</header>