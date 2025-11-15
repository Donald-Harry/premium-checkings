<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="index.htm">
            <img src="<?= ROOT_URL ?>assets/images/logo.png" alt="logo">
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li class="nav-item <?= (isset($location) and $location == "dashboard") ? "active" : ""; ?>">
                <a href="<?= ROOT_URL ?>dashboard/user" class="<?= (isset($location) and $location == "withdraw") ? "active" : ""; ?>">
                    <span class="icon">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm320 96c0-26.9-16.5-49.9-40-59.3V88c0-13.3-10.7-24-24-24s-24 10.7-24 24V292.7c-23.5 9.5-40 32.5-40 59.3c0 35.3 28.7 64 64 64s64-28.7 64-64zM144 176a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm-16 80a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM400 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                        </svg>
                    </span>
                    <span class="text">
                        Overview
                    </span>
                </a>
            </li>
            <span class="divider">
                <hr>
            </span>
            <li class="nav-item <?= (isset($location) and $location == "dashboard") ? "active" : ""; ?>">
                <a href="<?= ROOT_URL ?>dashboard/admin/users" class="">
                    <span class="icon">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/>
                        </svg>
                    </span>
                    <span class="text">
                        Users
                    </span>
                </a>
            </li>
            <li class="nav-item <?= (isset($location) and $location == "addUsers") ? "active" : ""; ?>">
                <a href="<?= ROOT_URL ?>dashboard/admin/users/add-users.php" class="">
                    <span class="icon">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                            <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/>
                        </svg>
                    </span>
                    <span class="text">
                        Add Users
                    </span>
                </a>
            </li>
            <!-- <li class="nav-item <?= (isset($location) and $location == "addUsers") ? "active" : ""; ?>">
                <a href="<?= ROOT_URL ?>dashboard/admin/users/kyc-info/list.php" class="">
                    <span class="icon">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm320 96c0-26.9-16.5-49.9-40-59.3V88c0-13.3-10.7-24-24-24s-24 10.7-24 24V292.7c-23.5 9.5-40 32.5-40 59.3c0 35.3 28.7 64 64 64s64-28.7 64-64zM144 176a32 32 0 1 0 0-64 32 32 0 1 0 0 64zm-16 80a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zm288 32a32 32 0 1 0 0-64 32 32 0 1 0 0 64zM400 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                        </svg>
                    </span>
                    <span class="text">
                        Kyc Users
                    </span>
                </a>
            </li> -->
            
            <span class="divider">
                <hr>
            </span>
            <li class="nav-item">
                <a href="<?= ROOT_URL ?>dashboard/admin/logout.php" class="">
                    <span class="icon">
                        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                        </svg>
                    </span>
                    <span class="text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>