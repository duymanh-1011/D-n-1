<?php require_once 'views/layout/header.php'; ?>
<?php require_once 'views/layout/menu.php'; ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Download</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="myaccount-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="myaccount-content">
                        <h3>Download</h3>
                        <p>Đây là trang Download. Bạn có thể cung cấp các tài liệu, hoá đơn, hướng dẫn hoặc nội dung tải xuống cho khách hàng ở đây.</p>
                        <ul class="list-unstyled">
                            <li><a href="#" class="btn btn-sqr">Tải hóa đơn mua hàng</a></li>
                            <li class="mt-2"><a href="#" class="btn btn-sqr">Tải hướng dẫn sử dụng</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/layout/footer.php'; ?>