<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập Admin</title>

  <!-- CSS -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">

<div class="login-box">
  <div class="card card-outline card-primary">

    <div class="card-header text-center">
      <h1>Bán Quần Áo</h1>
    </div>

    <div class="card-body">

      <?php if (isset($_SESSION['error'])): ?>
        <p class="text-danger text-center"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
      <?php else: ?>
        <p class="login-box-msg">Vui lòng đăng nhập</p>
      <?php endif; ?>

      <form action="<?= BASE_URL_ADMIN . '?act=check-login-admin' ?>" method="POST">

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>

      </form>

    </div>
  </div>
</div>

<!-- JS -->
<script src="./assets/plugins/jquery/jquery.min.js"></script>
<script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./assets/dist/js/adminlte.min.js"></script>

</body>
</html>