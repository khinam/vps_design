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
                <span><i class="fas fa-id-badge"></i></span>
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
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

        <div class="contractId">
          <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
              <span><i class="fas fa-id-badge"></i></span>
              契約ID
            </div>
            <div class="p-2 bd-highlight">D000123</div>
          </div>
        </div>
        <div class="contractService">
            <div class="row mt-4">
              <div class="col-sm-12">
                <!-- Nav tabs -->
                <label for="" class="col-form-label">契約サービス</label>
                <ul class="nav nav-tabs cus-tabs">
                  <li class="nav-item">
                    <a href="/admin" class="nav-link active">共用サーバー</a>
                  </li>
                  <li class="nav-item">
                    <a href="/admin/vps"class="nav-link">VPS/デスクトッププラン</a>
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div id="shared-server" class="tab-pane active pr-3 pl-3 pb-3"><br>
                    <table class="table table-borderless">
                      <thead>
                        <tr class="row">
                          <th class="col-sm-2">契約ド</th>
                          <th class="col-sm-2">Site Setting</th>
                          <th class="col-sm-2">使用容量</th>
                          <th class="col-sm-1">サイト</th>
                          <th class="col-sm-2">アプリケーションプール</th>
                          <th class="col-sm-2">エイリアス</th>
                          <th class="col-sm-1">削除</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach($multidomain as $domain) {
                          ?>
                          <tr class="row">
                            <td class="col-sm-2"><a href="http://<?php echo $domain['domain'] ?>" class="link-success" target="_blank"><?php echo $domain['domain'] ?></a>
                            </td>
                            <td class="col-sm-2">

                              <a href="/admin/share?webid=<?= $domain['id'] ?>" class="btn btn-outline-primary btn-sm" target="_blank">設定</a>
                            </td>
                            <td class="col-sm-2">
                              <span><?php echo sizeFormat(folderSize("E:/webroot/LocalUser/$domain[user]")) ?></span>
                            </td>
                            <td class="col-sm-1">
                              <form action="/admin/app_setting/confirm" method = "post">
                                <input type="hidden" name="app" value="site">
                                <input type="hidden" name="domain" value="<?=$domain['domain'] ?>">
                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="起動" data-off="停止" data-size="sm" <?php if($domain['stopped']==0){echo "checked";}  ?> name='onoff' onchange="this.form.submit()">
                              </form>
                            </td>
                            <td class="col-sm-2">
                              <form action="/admin/app_setting/confirm" method = "post">
                                <input type="hidden" name="app" value="app">
                                <input type="hidden" name="domain" value="<?=$domain['domain'] ?>">
                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="起動" data-off="停止" data-size="sm" <?php if($domain['appstopped']==0){echo "checked";} ?> name='onoff' onchange="this.form.submit()">
                              </form>
                            </td>

                            <td class="col-sm-2">
                              <a href="/admin/servers/sitebinding?id=<?=$domain[id]?>&act=new&site=<?=$domain[user]?>" class="btn btn-success btn-sm text-white">追加</a>
                              <a href="/admin/servers/sitebinding?id=<?=$domain[id]?>&act=delete&site=<?=$domain[user]?>" class="btn btn-danger btn-sm text-white">削除</a>
                            </td>

                            <td class="col-sm-1">
                              <!-- <a href="delete_website.php?domainid=<?php echo $domain['id'] ?>" class="btn btn-danger btn-sm">削除</a> -->
                              <button type="button" class="btn btn-danger btn-sm" disable>削除</button>
                            </td>
                          </tr>
                          <?php
                        }
                        ?>
                      </tbody>
                    </table>

                    <div class="conButton d-flex justify-content-center">
                      <button class="domainAdd btn btn-outline-info btn-sm common_modal mr-2"  data-toggle="modal" data-target="#common_modal" gourl="/admin/add_multi_domain">マルチドメイン追加</button>
                      <a href="/admin/servers/domain_transfer mr-2" class="domainAcq btn btn-outline-info btn-sm mr-2">ドメイン取得/移管</a>
                      <a href="/admin/servers" class="addServer btn btn-outline-info btn-sm mr-2">サーバー追加</a>
                      <a href="/admin/servers?server=dns" class="addServer btn btn-outline-info btn-sm mr-2">DNS情報</a>
                    </div>
                  </div>
                  <div id="vps-desktop" class="tab-pane fade"><br>
                    <table class="table table-borderless">
                      <thead>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th>使用容量</th>
                          <th>サイト</th>
                          <th>アプリケーションプール</th>
                          <th>削除</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>

        <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

      </main>
    </div>
  </div>

</body>
</html>