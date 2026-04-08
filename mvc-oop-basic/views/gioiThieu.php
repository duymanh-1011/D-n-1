<?php require_once 'layout/header.php'; ?>
<?php require_once 'layout/menu.php'; ?>
<?php require_once 'layout/miniCart.php'; ?>

<main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- blog main wrapper start -->
    <div class="blog-main-wrapper section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-2 order-lg-1">
                    <aside class="blog-sidebar-wrapper">
                        <div class="blog-sidebar">
                            <h5 class="title">Search</h5>
                            <div class="sidebar-serch-form">
                                <form action="<?= BASE_URL . '?act=gioi-thieu' ?>" method="GET">
                                    <input type="hidden" name="act" value="gioi-thieu">
                                    <input type="text" name="q" class="search-field" placeholder="Search here">
                                    <button type="submit" class="search-btn"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="blog-sidebar">
                            <h5 class="title">Categories</h5>
                            <ul class="blog-archive blog-category">
                                <?php foreach ($listDanhMuc as $danhMuc) : ?>
                                    <li><a href="<?= BASE_URL . '?act=danh-sach-san-pham&danh_muc_id=' . $danhMuc['id'] ?>"><?= htmlspecialchars($danhMuc['ten_danh_muc']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="blog-sidebar">
                            <h5 class="title">Recent posts</h5>
                            <div class="recent-post">
                                <?php foreach ($listRecentPosts as $recent) : ?>
                                    <div class="recent-post-item">
                                        <figure class="product-thumb">
                                            <a href="<?= $recent['url'] ?>">
                                                <img src="<?= BASE_URL . $recent['image'] ?>" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="recent-post-description">
                                            <div class="product-name">
                                                <h6><a href="<?= $recent['url'] ?>"><?= htmlspecialchars($recent['title']) ?></a></h6>
                                                <p><?= htmlspecialchars($recent['date']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="blog-sidebar">
                            <h5 class="title">Tags</h5>
                            <ul class="blog-tags">
                                <?php foreach ($listDanhMuc as $danhMuc) : ?>
                                    <li><a href="<?= BASE_URL . '?act=danh-sach-san-pham&danh_muc_id=' . $danhMuc['id'] ?>"><?= htmlspecialchars($danhMuc['ten_danh_muc']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="blog-item-wrapper">
                        <div class="row mbn-30">
                            <?php foreach ($listBlogPosts as $post) : ?>
                                <div class="col-md-6">
                                    <div class="blog-post-item mb-30">
                                        <figure class="blog-thumb">
                                            <a href="<?= $post['url'] ?>">
                                                <img src="<?= BASE_URL . $post['image'] ?>" alt="blog image">
                                            </a>
                                        </figure>
                                        <div class="blog-content">
                                            <div class="blog-meta">
                                                <p><?= htmlspecialchars($post['date']) ?> | <a href="#"><?= htmlspecialchars($post['category']) ?></a></p>
                                            </div>
                                            <h4 class="blog-title">
                                                <a href="<?= $post['url'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                                            </h4>
                                            <p><?= htmlspecialchars($post['excerpt']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="paginatoin-area text-center">
                            <ul class="pagination-box">
                                <?php if ($currentPage > 1) : ?>
                                    <li><a href="<?= BASE_URL . '?act=gioi-thieu&page=' . ($currentPage - 1) ?>" class="previous"><i class="pe-7s-angle-left"></i></a></li>
                                <?php else : ?>
                                    <li class="disabled"><span><i class="pe-7s-angle-left"></i></span></li>
                                <?php endif; ?>

                                <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                    <li class="<?= $page === $currentPage ? 'active' : '' ?>">
                                        <a href="<?= BASE_URL . '?act=gioi-thieu&page=' . $page ?>"><?= $page ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages) : ?>
                                    <li><a href="<?= BASE_URL . '?act=gioi-thieu&page=' . ($currentPage + 1) ?>" class="next"><i class="pe-7s-angle-right"></i></a></li>
                                <?php else : ?>
                                    <li class="disabled"><span><i class="pe-7s-angle-right"></i></span></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog main wrapper end -->
</main>

<?php require_once 'layout/footer.php'; ?>
