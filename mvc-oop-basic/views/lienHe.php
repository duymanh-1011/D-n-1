<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<?php require_once 'layout/miniCart.php'; ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="contact-info">
                        <h2 class="contact-title">Liên hệ với Orvani</h2>
                        <p>Nếu bạn cần tư vấn sản phẩm hoặc hỗ trợ đơn hàng, hãy liên hệ với chúng tôi qua các thông tin bên dưới.</p>
                        <ul>
                            <li><i class="pe-7s-home"></i> 13 Trịnh Văn Bô, Nam Từ Liêm, Hà Nội</li>
                            <li><i class="pe-7s-mail"></i> <a href="mailto:support@orvani.vn">support@orvani.vn</a></li>
                            <li><i class="pe-7s-call"></i> <a href="tel:0123456789">0123 456 789</a></li>
                        </ul>
                        <div class="working-time">
                            <h6>Thời gian hỗ trợ</h6>
                            <p>Thứ 2 - Thứ 7: <span>08:00 - 21:00</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-message">
                        <h2>Gửi tin nhắn cho chúng tôi</h2>
                        <form onsubmit="return false;">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" placeholder="Họ và tên">
                                </div>
                                <div class="col-md-6">
                                    <input type="email" placeholder="Email">
                                </div>
                                <div class="col-12">
                                    <input type="text" placeholder="Tiêu đề">
                                </div>
                                <div class="col-12">
                                    <textarea placeholder="Nội dung tin nhắn"></textarea>
                                    <button class="btn btn-sqr" type="submit">Gửi liên hệ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'layout/footer.php'; ?>
