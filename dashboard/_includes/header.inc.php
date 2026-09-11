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
                    <!-- notification start -->
                    <!-- <div class="notification-box ml-15 d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg width="22" height="22" viewbox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 20.1667C9.88317 20.1667 8.88718 19.63 8.23901 18.7917H13.761C13.113 19.63 12.1169 20.1667 11 20.1667Z" fill=""></path>
                                <path d="M10.1157 2.74999C10.1157 2.24374 10.5117 1.83333 11 1.83333C11.4883 1.83333 11.8842 2.24374 11.8842 2.74999V2.82604C14.3932 3.26245 16.3051 5.52474 16.3051 8.24999V14.287C16.3051 14.5301 16.3982 14.7633 16.564 14.9352L18.2029 16.6342C18.4814 16.9229 18.2842 17.4167 17.8903 17.4167H4.10961C3.71574 17.4167 3.5185 16.9229 3.797 16.6342L5.43589 14.9352C5.6017 14.7633 5.69485 14.5301 5.69485 14.287V8.24999C5.69485 5.52474 7.60672 3.26245 10.1157 2.82604V2.74999Z" fill=""></path>
                            </svg>
                            <span></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                            <li>
                                <a href="<?= ROOT_URL ?>dashboard/#0">
                                    <div class="image">
                                        <img src="<?= ROOT_URL ?>dashboard/assets/images/lead/lead-6.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h6>
                                            John Doe
                                            <span class="text-regular">
                                                comment on a product.
                                            </span>
                                        </h6>
                                        <p>
                                            Lorem ipsum dolor sit amet, consect etur adipiscing
                                            elit Vivamus tortor.
                                        </p>
                                        <span>10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="<?= ROOT_URL ?>dashboard/#0">
                                    <div class="image">
                                        <img src="<?= ROOT_URL ?>dashboard/assets/images/lead/lead-1.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h6>
                                            Jonathon
                                            <span class="text-regular">
                                                like on a product.
                                            </span>
                                        </h6>
                                        <p>
                                            Lorem ipsum dolor sit amet, consect etur adipiscing
                                            elit Vivamus tortor.
                                        </p>
                                        <span>10 mins ago</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div> -->
                    <!-- notification end -->
                    <!-- profile start -->
                    <?php 
                        $header_pic = (!empty($user_row['profile_pic']) && file_exists(WEB_ROOT . "backend/account/profileImages/" . $user_row['profile_pic'])) 
                            ? $user_row['profile_pic'] 
                            : 'default.png';
                    ?>
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <div class="image">
                                        <img src="<?= ROOT_URL ?>backend/account/profileImages/<?= $header_pic ?>" alt="Avatar" onerror="this.onerror=null; this.src='<?= ROOT_URL ?>backend/account/profileImages/default.png';">
                                    </div>
                                    <div>
                                        <h6 class="fw-500"><?= $user_row['first_name'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <li>
                                <div class="author-info flex items-center !p-1">
                                    <div class="image">
                                        <img src="<?= ROOT_URL ?>backend/account/profileImages/<?= $header_pic ?>" alt="Avatar" onerror="this.onerror=null; this.src='<?= ROOT_URL ?>backend/account/profileImages/default.png';">
                                    </div>
                                    <div class="content">
                                        <h4 class="text-sm"><?= $user_row['first_name'] ?></h4>
                                        <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="<?= ROOT_URL ?>dashboard/#"><?= $user_row['email'] ?></a>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= ROOT_URL ?>dashboard/user/profile">
                                    <i class="lni lni-user"></i> View Profile
                                </a>
                            </li>
                            <li>
                                <a href="<?= ROOT_URL ?>dashboard/user/profile#password">
                                    <i class="lni lni-lock"></i> Change Password
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= ROOT_URL ?>dashboard/user/logout.php">
                                    <i class="lni lni-exit"></i> Sign Out
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