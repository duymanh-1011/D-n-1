<?php require_once __DIR__ . '/layout/header.php'; ?>
<?php require_once __DIR__ . '/layout/menu.php'; ?>

<?php
$hinhAnhMacDinh = 'assets/img/product/product-1.jpg';
$hinhAnh = $hinhAnhMacDinh;
$hinhAnhDb = trim((string)($sanPham['hinh_anh'] ?? ''));

if ($hinhAnhDb !== '') {
    $hinhAnhDb = str_replace('\\', '/', $hinhAnhDb);
    $hinhAnhDb = preg_replace('#^\./#', '', $hinhAnhDb);
    $hinhAnhDb = ltrim($hinhAnhDb, '/');

    if (preg_match('#^https?://#i', $hinhAnhDb)) {
        $hinhAnh = $hinhAnhDb;
    } elseif (file_exists(PATH_ROOT . $hinhAnhDb)) {
        $hinhAnh = BASE_URL . $hinhAnhDb;
    }
}

$giaGoc = isset($sanPham['gia_san_pham']) ? (float)$sanPham['gia_san_pham'] : 0;
$giaKhuyenMai = isset($sanPham['gia_khuyen_mai']) ? (float)$sanPham['gia_khuyen_mai'] : 0;
$coKhuyenMai = $giaKhuyenMai > 0 && $giaKhuyenMai < $giaGoc;
$tenSanPham = htmlspecialchars($sanPham['ten_san_pham'] ?? 'Sản phẩm');
$moTaSanPham = nl2br(htmlspecialchars($sanPham['mo_ta'] ?? 'Chưa có mô tả cho sản phẩm này.'));
$tongBinhLuan = count($listBinhLuan ?? []);
?>

<main>
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>?act=danh-sach-san-pham">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($sanPham)) : ?>
        <div class="shop-main-wrapper section-padding">
            <div class="container">
                <div class="alert alert-warning text-center">
                    Không tìm thấy sản phẩm. Vui lòng quay lại trang chủ và chọn sản phẩm khác.
                </div>
            </div>
        </div>
    <?php else : ?>

    <div class="shop-main-wrapper section-padding pb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="product-large-slider">
                                    <div class="pro-large-img img-zoom">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="<?= $tenSanPham ?>">
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="<?= $tenSanPham ?>">
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="<?= $tenSanPham ?>">
                                    </div>
                                    <div class="pro-large-img img-zoom">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="<?= $tenSanPham ?>">
                                    </div>
                                </div>
                                <div class="pro-nav slick-row-10 slick-arrow-style">
                                    <div class="pro-nav-thumb">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="product-details" />
                                    </div>
                                    <div class="pro-nav-thumb">
                                        <img src="<?= htmlspecialchars($hinhAnh) ?>" alt="product-details" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <div class="manufacturer-name">
                                        <a href="#">Thú cưng FPL</a>
                                    </div>

                                    <h3 class="product-name"><?= $tenSanPham ?></h3>

                                    <div class="ratings d-flex">
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <span><i class="fa fa-star-o"></i></span>
                                        <div class="pro-review">
                                            <span><?= $tongBinhLuan ?> bình luận</span>
                                        </div>
                                    </div>

                                    <div class="price-box">
                                        <?php if ($coKhuyenMai) : ?>
                                            <span class="price-regular"><?= number_format($giaKhuyenMai, 0, ',', '.') ?>đ</span>
                                            <span class="price-old"><del><?= number_format($giaGoc, 0, ',', '.') ?>đ</del></span>
                                        <?php else : ?>
                                            <span class="price-regular"><?= number_format($giaGoc, 0, ',', '.') ?>đ</span>
                                        <?php endif; ?>
                                    </div>

                                    <h5 class="offer-text"><strong>Nhanh tay!</strong> Ưu đãi sẽ kết thúc sau:</h5>
                                    <div class="product-countdown" data-countdown="2027/12/31"></div>

                                    <div class="availability">
                                        <i class="fa fa-check-circle"></i>
                                        <span><?= (int)($sanPham['so_luong'] ?? 0) ?> sản phẩm trong kho</span>
                                    </div>

                                    <p class="pro-desc">
                                        <?= $moTaSanPham ?>
                                    </p>

                                    <div class="quantity-cart-box d-flex align-items-center">
                                        <h6 class="option-title">Số lượng:</h6>
                                        <form action="<?= BASE_URL ?>?act=them-gio-hang" method="post" class="d-flex align-items-center">
                                            <div class="quantity">
                                                <div class="pro-qty"><input type="text" name="so_luong" value="1"></div>
                                            </div>
                                            <input type="hidden" name="san_pham_id" value="<?= (int)($sanPham['id'] ?? 0) ?>">
                                            <div class="action_link">
                                                <button class="btn btn-cart2" type="submit">Thêm vào giỏ hàng</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="pro-size">
                                        <h6 class="option-title">Kích cỡ:</h6>
                                        <select class="nice-select">
                                            <option>S</option>
                                            <option>M</option>
                                            <option>L</option>
                                            <option>XL</option>
                                        </select>
                                    </div>

                                    <div class="color-option">
                                        <h6 class="option-title">Màu sắc:</h6>
                                        <ul class="color-categories">
                                            <li><a class="c-lightblue" href="#" title="LightSteelblue"></a></li>
                                            <li><a class="c-darktan" href="#" title="Darktan"></a></li>
                                            <li><a class="c-grey" href="#" title="Grey"></a></li>
                                            <li><a class="c-brown" href="#" title="Brown"></a></li>
                                        </ul>
                                    </div>

                                    <div class="useful-links">
                                        <a href="#" data-bs-toggle="tooltip" title="So sánh"><i class="pe-7s-refresh-2"></i>so sánh</a>
                                        <a href="#" data-bs-toggle="tooltip" title="Yêu thích"><i class="pe-7s-like"></i>yêu thích</a>
                                    </div>

                                    <div class="like-icon">
                                        <a class="facebook" href="#"><i class="fa fa-facebook"></i>thích</a>
                                        <a class="twitter" href="#"><i class="fa fa-twitter"></i>chia sẻ</a>
                                        <a class="pinterest" href="#"><i class="fa fa-pinterest"></i>lưu</a>
                                        <a class="google" href="#"><i class="fa fa-google-plus"></i>chia sẻ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-details-reviews section-padding pb-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-review-info">
                            <ul class="nav review-tab">
                                <li>
                                    <a data-bs-toggle="tab" href="#tab_mo_ta">Mô tả</a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tab" href="#tab_thong_tin">Thông tin</a>
                                </li>
                                <li>
                                    <a class="active" data-bs-toggle="tab" href="#tab_binh_luan">Bình luận (<?= count($listBinhLuan) ?>)</a>
                                </li>
                            </ul>
                            <div class="tab-content reviews-tab">
                                <div class="tab-pane fade" id="tab_mo_ta">
                                    <div class="tab-one">
                                        <p><?= nl2br(htmlspecialchars($sanPham['mo_ta'] ?? 'Sản phẩm hiện chưa có mô tả.')) ?></p>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab_thong_tin">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Mã sản phẩm</td>
                                                <td>#<?= (int)($sanPham['id'] ?? 0) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Số lượng</td>
                                                <td><?= (int)($sanPham['so_luong'] ?? 0) ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ngày nhập</td>
                                                <td><?= htmlspecialchars(formatDate($sanPham['ngay_nhap'] ?? '')) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade show active" id="tab_binh_luan">
                                    <form action="<?= BASE_URL ?>?act=chi-tiet-san-pham&id_san_pham=<?= (int)($sanPham['id'] ?? 0) ?>#tab_binh_luan" method="post" class="review-form">
                                        <h5><?= count($listBinhLuan) ?> bình luận cho <span><?= htmlspecialchars($sanPham['ten_san_pham'] ?? 'Sản phẩm') ?></span></h5>

                                        <?php if (!empty($listBinhLuan)) : ?>
                                            <?php foreach ($listBinhLuan as $binhLuan) : ?>
                                                <div class="total-reviews">
                                                    <div class="rev-avatar">
                                                        <img src="assets/img/about/avatar.jpg" alt="avatar">
                                                    </div>
                                                    <div class="review-box">
                                                        <div class="post-author">
                                                            <p>
                                                                <span><?= htmlspecialchars($binhLuan['ho_ten'] ?? 'Khách hàng') ?> -</span>
                                                                <?= htmlspecialchars(formatDate($binhLuan['ngay_dang'] ?? '')) ?>
                                                            </p>
                                                        </div>
                                                        <p><?= nl2br(htmlspecialchars($binhLuan['noi_dung'] ?? '')) ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <p>Chưa có bình luận nào cho sản phẩm này.</p>
                                        <?php endif; ?>

                                        <div class="form-group row">
                                            <div class="col">
                                                <label class="col-form-label"><span class="text-danger">*</span> Nội dung bình luận</label>
                                                <textarea class="form-control" name="noi_dung" required></textarea>
                                            </div>
                                        </div>

                                        <div class="buttons">
                                            <button class="btn btn-sqr" type="submit">Bình luận</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($listLienQuan)) : ?>
        <section class="related-products section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h2 class="title">Sản phẩm liên quan</h2>
                            <p class="sub-title">Khám phá thêm các sản phẩm tương tự</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($listLienQuan as $item) : ?>
                        <?php
                        $anhLienQuan = 'assets/img/product/product-1.jpg';
                        $anhDb = trim((string)($item['hinh_anh'] ?? ''));
                        if ($anhDb !== '') {
                            $anhDb = str_replace('\\', '/', $anhDb);
                            $anhDb = preg_replace('#^\./#', '', $anhDb);
                            $anhDb = ltrim($anhDb, '/');
                            if (preg_match('#^https?://#i', $anhDb)) {
                                $anhLienQuan = $anhDb;
                            } elseif (file_exists(PATH_ROOT . $anhDb)) {
                                $anhLienQuan = BASE_URL . $anhDb;
                            }
                        }
                        $giaItem = isset($item['gia_san_pham']) ? (float)$item['gia_san_pham'] : 0;
                        $idItem = (int)($item['id'] ?? 0);
                        $urlItem = BASE_URL . '?act=chi-tiet-san-pham&id_san_pham=' . $idItem;
                        ?>
                        <div class="col-md-3 col-sm-6 mb-30">
                            <div class="product-item">
                                <figure class="product-thumb">
                                    <a href="<?= htmlspecialchars($urlItem) ?>">
                                        <img class="pri-img" src="<?= htmlspecialchars($anhLienQuan) ?>" alt="<?= htmlspecialchars($item['ten_san_pham'] ?? 'Sản phẩm') ?>">
                                    </a>
                                </figure>
                                <div class="product-caption text-center">
                                    <h6 class="product-name">
                                        <a href="<?= htmlspecialchars($urlItem) ?>"><?= htmlspecialchars($item['ten_san_pham'] ?? 'Sản phẩm') ?></a>
                                    </h6>
                                    <div class="price-box">
                                        <span class="price-regular"><?= number_format($giaItem, 0, ',', '.') ?>đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
