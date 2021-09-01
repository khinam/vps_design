<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Design for common server</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">

    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/fontawesome.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-info sidebar collapse">
      <h2><a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Winserver</a></h2>
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span><i class="fas fa-server"></i></span>
              サーバー設定
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span><i class="far fa-id-badge"></i></span>
              ご契約情報
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span><i class="fas fa-file-signature"></i></span>
              マニュアル
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span><i class="far fa-comment-dots"></i></span>
              お問合せ
            </a>
          </li>
        </ul>

      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h3>Winserver Control Panel</h3>
        <div class="mb-2 mb-md-0">
            <ul id="subNavMenu">
                <li>
                  <form action="" method="post">
                    <span><img src="../img/logout.png" id="logout"></span>
                    <input type="submit" value="ログアウト">
                  </form>
                </li>
            </ul>
        </div>
      </div>

      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

    </main>
  </div>
</div>

</body>
</html>