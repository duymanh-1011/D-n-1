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
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="map-area section-padding">
        <div style="height: 420px; width: 100%; border: 1px solid rgba(0,0,0,0.08); overflow: hidden;">
            <iframe src="https://www.google.com/maps?q=FPT+Polytechnic+Hanoi&output=embed" width="100%" height="420" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>

    <section class="contact-area section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-message">
                        <h4 class="contact-title">Gửi câu hỏi cho chúng tôi</h4>
                        <form id="contact-form" action="<?= BASE_URL . '?act=lien-he' ?>" method="POST" class="contact-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <input name="first_name" placeholder="Họ và tên *" type="text" class="form-control" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <input name="phone" placeholder="Số điện thoại *" type="text" class="form-control" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <input name="email_address" placeholder="Email *" type="email" class="form-control" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                    <input name="contact_subject" placeholder="Tiêu đề" type="text" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <textarea placeholder="Nội dung *" name="message" class="form-control" rows="5" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn-contact-submit" type="submit">Gửi tin nhắn</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info">
                        <h4 class="contact-title">Thông tin liên hệ</h4>
                        <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn. Hãy gửi yêu cầu hoặc phản hồi của bạn đến đội ngũ ORVANI để được tư vấn nhanh nhất.</p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-map-marker"></i> Địa chỉ:  <a href="https://maps.app.goo.gl/wd3977KQLpwxngUQA" target="_blank" rel="noopener noreferrer">  Hà Nội</a></li>
                            <li><i class="fa fa-envelope"></i> Email: support@orvani.local</li>
                            <li><i class="fa fa-phone"></i> Hotline: 0123 456 789</li>
                        </ul>
                        <div class="working-time mt-4">
                            <h6>Giờ làm việc</h6>
                            <p><span>Thứ 2 – Thứ 7:</span> 08:00 – 22:00</p>
                            <p><span>Chủ nhật:</span> Nghỉ hoặc hỗ trợ online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'layout/footer.php'; ?>
