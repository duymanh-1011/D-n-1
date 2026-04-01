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
                                <li class="breadcrumb-item active" aria-current="page">Payment Method</li>
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
                        <h3>Payment Method</h3>
                        <p>Chọn phương thức thanh toán mặc định của bạn. Hiện tại bạn có thể xem các lựa chọn và đổi phương thức.</p>
                        <div class="mb-3">
                            <strong>Phương thức hiện tại:</strong> Chuyển khoản ngân hàng
                        </div>
                        <div>
                            <a href="#" class="btn btn-sqr">Thêm thẻ tín dụng</a>
                            <a href="#" class="btn btn-sqr ml-2">Chỉnh sửa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'views/layout/footer.php'; ?>