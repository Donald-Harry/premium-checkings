<div class="header_navbar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="<?= ROOT_URL ?>">
                        <img src="<?= ROOT_URL ?>assets/images/logo-no-background.svg" alt="Logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                        <ul id="nav" class="navbar-nav ml-auto">
                            <li class="nav-item <?=( isset($location)and $location == "home")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>#home">Home</a>
                            </li>
                            <li class="nav-item <?=( isset($location)and $location == "about")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>about.php">About</a>
                            </li>
                            <li class="nav-item <?=( isset($location)and $location == "card")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>card.php">Card</a>
                            </li>
                            <li class="nav-item <?=( isset($location)and $location == "contact")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>contact.php">Contact</a>
                            </li>
                            <li class="nav-item <?=( isset($location)and $location == "ways")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>ways-to-bank">Ways to bank</a>
                            </li>
                            <!-- <li class="nav-item <?=( isset($location)and $location == "dashboard")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>#team">Team</a>
                            </li>
                            <li class="nav-item <?=( isset($location)and $location == "dashboard")? "active" : ""; ?>">
                                <a class="page-scroll" href="<?= ROOT_URL ?>#blog">Blog</a>
                            </li> -->
                        </ul>
                    </div> <!-- navbar collapse -->
                    <!-- d-none -->
                    <div class="navbar-btn  d-sm-inline-block">
                        <a class="main-btn" data-scroll-nav="0" href="<?= ROOT_URL ?>account">Login</a>
                    </div>
                </nav> <!-- navbar -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div> <!-- header navbar -->