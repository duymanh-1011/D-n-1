 <!-- Start Header Area -->
    <header class="header-area header-wide">
        <!-- main header start -->
        <div class="main-header d-none d-lg-block">
            <!-- header top start -->
            <div class="header-top bdr-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="welcome-message">
                                <p>helo</p>
                            </div>
                        </div>
                        <div class="col-lg-6 text-right">
                            <div class="header-top-settings">
                                <ul class="nav align-items-center justify-content-end">
                                    <li class="curreny-wrap">
                                        $ Currency
                                        <i class="fa fa-angle-down"></i>
                                        <ul class="dropdown-list curreny-list">
                                            <li><a href="#">$ USD</a></li>
                                            <li><a href="#">€ EURO</a></li>
                                        </ul>
                                    </li>
                                    <li class="language">
                                        <img src="assets/img/icon/en.png" alt="flag"> English
                                        <i class="fa fa-angle-down"></i>
                                        <ul class="dropdown-list">
                                            <li><a href="#"><img src="assets/img/icon/en.png" alt="flag"> english</a></li>
                                            <li><a href="#"><img src="assets/img/icon/fr.png" alt="flag"> french</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header top end -->

            <!-- header middle area start -->
            <div class="header-main-area sticky">
                <div class="container">
                    <div class="row align-items-center position-relative">

                        <!-- start logo area -->
                        <div class="col-lg-2">
                            <div class="logo">
                                <a href="<?= BASE_URL ?>">
                                    <img src="assets/img/logo/logo.png" alt="Brand Logo">
                                </a>
                            </div>
                        </div>
                        <!-- start logo area -->

                        <!-- main menu area start -->
                        <div class="col-lg-6 position-static">
                            <div class="main-menu-area">
                                <div class="main-menu">
                                    <!-- main menu navbar start -->
                                    <nav class="desktop-menu">
                                        <ul>
                                            <li><a href="<?= BASE_URL ?>">Trang chủ</a>
                                                
                                            </li>
                                           
                                            <li><a href="<?= BASE_URL ?>?act=danh-sach-san-pham">Sản phẩm <i class="fa fa-angle-down"></i></a>
                                                <ul class="dropdown">
                                                    <li><a href="<?= BASE_URL ?>?act=danh-sach-san-pham">Danh sách sản phẩm</a></li>
                                                    
                                                </ul>
                                            </li>
                                            <li><a href="<?= BASE_URL ?>?act=gioi-thieu">Giới thiệu</a></li>
                                            <li><a href="<?= BASE_URL ?>?act=lien-he">Liên hệ</a></li>
                                        </ul>
                                    </nav>
                                    <!-- main menu navbar end -->
                                </div>
                            </div>
                        </div>
                        <!-- main menu area end -->

                        <!-- mini cart area start -->
                        <div class="col-lg-4">
                            <div class="header-right d-flex align-items-center justify-content-xl-between justify-content-lg-end">
                                <div class="header-search-container"> 
                                    <button class="search-trigger d-xl-none d-lg-block"><i class="pe-7s-search"></i></button>
                                    <form class="header-search-box d-lg-none d-xl-block">
                                        <input type="text" placeholder="Nhập tên sản phẩm" class="header-search-field">
                                        <button class="header-search-btn"><i class="pe-7s-search"></i></button>
                                    </form>
                                </div>
                                <div class="header-configure-area">
                                    <ul class="nav justify-content-end">
                                        <li class="user-hover">
                                            <a href="#">
                                                <i class="pe-7s-user"></i>
                                            </a>
                                            <ul class="dropdown-list">
                                                <?php if (!empty($_SESSION['user_client'])) : ?>
                                                    <li><a href="#">Xin chào, <?= htmlspecialchars($_SESSION['user_client']['ho_ten'] ?? 'Khách hàng') ?></a></li>
                                                    <li><a href="<?= BASE_URL ?>?act=lich-su-mua-hang">Lịch sử mua hàng</a></li>
                                                    <li><a href="<?= BASE_URL ?>?act=logout-client">Đăng xuất</a></li>
                                                <?php else : ?>
                                                    <li><a href="<?= BASE_URL ?>?act=login">Đăng nhập</a></li>
                                                    <li><a href="<?= BASE_URL ?>?act=login">Đăng ký</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </li>
                                       
                                        <li>
                                            <a href="<?= BASE_URL ?>?act=gio-hang" class="minicart-btn">
                                                <i class="pe-7s-shopbag"></i>
                                                <div class="notification">2</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- mini cart area end -->

                    </div>
                </div>
            </div>
            <!-- header middle area end -->
        </div>
        <!-- main header start -->

    </header>
    <!-- end Header Area -->