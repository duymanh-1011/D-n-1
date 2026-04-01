<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>

    <main>
        <!-- breadcrumb area start -->
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
        <!-- breadcrumb area end -->

        <!-- contact area start -->
        <div class="contact-area section-padding pt-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-message">
                            <h4 class="contact-title">Gửi tin nhắn cho chúng tôi</h4>
                            <form id="contact-form" action="<?= BASE_URL . '?act=lien-he' ?>" method="post" class="contact-form">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="first_name" placeholder="Họ tên *" type="text" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="phone" placeholder="Số điện thoại *" type="text" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="email_address" placeholder="Email *" type="email" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <input name="contact_subject" placeholder="Chủ đề *" type="text">
                                    </div>
                                    <div class="col-12">
                                        <div class="contact2-textarea text-center">
                                            <textarea placeholder="Nội dung tin nhắn *" name="message" class="form-control2" required=""></textarea>
                                        </div>
                                        <div class="contact-btn">
                                            <button class="btn btn-sqr" type="submit">Gửi tin nhắn</button>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <p class="form-messege"></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-info">
                            <h4 class="contact-title">Thông tin liên hệ</h4>
                            <p>Chúng tôi hoan nghênh bạn liên lạc với chúng tôi qua các hình thức dưới đây. Đội ngũ của chúng tôi sẽ phản hồi trong thời gian sớm nhất.</p>
                            <ul>
                                <li><i class="fa fa-fax"></i> Địa chỉ: 123 Đường Hai Bà Trưng, Thành phố Hồ Chí Minh</li>
                                <li><i class="fa fa-phone"></i> Điện thoại: 0123 456 789</li>
                                <li><i class="fa fa-envelope-o"></i> Email: info@yourdomain.com</li>
                            </ul>
                            <div class="working-time">
                                <h6>Giờ làm việc</h6>
                                <p><span>Thứ Hai – Thứ Bảy:</span> 09:00 - 18:00</p>
                                <p><span>Chủ Nhật:</span> Nghỉ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- contact area end -->
    </main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>