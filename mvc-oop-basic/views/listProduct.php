<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="product-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Danh sách sản phẩm</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php foreach ($listProduct as $product): ?>
                    <?php
                    $idSanPham = (int)($product['id'] ?? 0);
                    $urlChiTiet = BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $idSanPham;
                    $gia = isset($product['gia_san_pham']) ? (float)$product['gia_san_pham'] : 0;
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                        <div class="product-item">
                            <div class="product-caption text-center">
                                <h6 class="product-name">
                                    <a href="<?= htmlspecialchars($urlChiTiet) ?>\"><?= htmlspecialchars($product['ten_san_pham'] ?? 'Sản phẩm') ?></a>
                                </h6>
                                <div class="price-box">
                                    <span class="price-regular"><?= number_format($gia, 0, ',', '.') ?>đ</span>
                                </div>
                                <div class="mt-2">
                                    <a class="btn btn-cart2" href="<?= htmlspecialchars($urlChiTiet) ?>">Chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>