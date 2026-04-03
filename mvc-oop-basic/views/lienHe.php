<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>

<main>
    <section class="breadcrumb-area hidden-xs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <h2 class="breadcrumb-title">Liên hệ</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Thông tin liên hệ</h3>
                    <p>Email: support@orvani.local</p>
                    <p>Hotline: 0123 456 789</p>
                    <p>Địa chỉ: Hà Nội, Việt Nam</p>
                </div>
                <div class="col-lg-6">
                    <h3>Gửi tin nhắn</h3>
                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Họ và tên">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Nội dung"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary">Gửi liên hệ</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'layout/footer.php'; ?>
