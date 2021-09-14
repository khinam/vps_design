<?php 
  require_once('header.php'); 
  require_once('config/all.php');

  $con = config::connect();

  $dstmt = $con->prepare("SELECT * FROM web_account");
  $dstmt->execute();
  $domains = $dstmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
  <div class="container-fluid">
    <div class="row">
        <?php require_once('sidebar.php'); ?>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-2 mb-3">
        <?php require_once('page_header.php'); ?>

        <div class="contractId">
          <div class="d-flex flex-row bd-highlight mb-4 con-p">
            <div class="p-2 bd-highlight">
              <span class="p-r-0 icon-s"><i class="fas fa-id-badge"></i></span>
              <span class="p-r-0 fw-bold">契約ID</span>
            </div>
            <div class="vl-2 p-2"></div>
            <div class="p-2 bd-highlight fw-bold">D000123</div>
          </div>
        </div>
        <div class="contractService pageWrapper">
            <div class="row">
              <div class="col-sm-12">
                <!-- Nav tabs -->
                <label for="" class="col-form-label fw-bold">契約サービス</label>
                <ul class="nav nav-tabs cus-tabs mt-4">
                  <li class="nav-item">
                    <a href="/admin" class="nav-link fw-bold active">共用サーバー</a>
                  </li>
                  <li class="nav-item">
                    <a href="vps.php"class="nav-link fw-bold">VPS/デスクトッププラン</a>
                  </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div id="shared-server" class="tab-pane active pr-3 pl-3 pb-3"><br>
                    <table class="table table-borderless mb-5">
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
                        <?php foreach($domains as $domain) { ?>
                          <tr class="row mb-3">
                            <td class="col-sm-2"><a href="" class="link-dark text-decoration-none" target="_blank"><?php echo $domain['domain'] ?></a>
                            </td>
                            <td class="col-sm-2">

                              <a href="/admin/share?webid=<?= $domain['id'] ?>" class="btn btn-outline-info btn-sm btn-border-radius" target="_blank">設定</a>
                            </td>
                            <td class="col-sm-2">
                              <span>0B</span>
                            </td>
                            <td class="col-sm-1">
                              <form action="/admin/app_setting/confirm" method = "post">
                                <input type="hidden" name="app" value="site">
                                <input type="hidden" name="domain" value="<?=$domain['domain'] ?>">
                                <input type="checkbox" data-toggle="toggle" data-style="ios" data-onstyle="info" data-offstyle="secondary" checked data-on="起動" data-off="停止" data-size="sm" name='onoff'>
                              </form>
                            </td>
                            <td class="col-sm-2">
                              <form action="/admin/app_setting/confirm" method = "post">
                                <input type="hidden" name="app" value="app">
                                <input type="hidden" name="domain" value="<?=$domain['domain'] ?>">
                                <input type="checkbox" data-toggle="toggle" data-style="ios" data-onstyle="info" data-offstyle="secondary" data-on="起動" data-off="停止" data-size="sm" name='onoff' onchange="">
                              </form>
                            </td>

                            <td class="col-sm-2">
                              <a href="" class="btn btn-outline-info btn-sm btn-border-radius">追加</a>
                              <a href="" class="btn btn-outline-danger btn-sm btn-border-radius">削除</a>
                            </td>

                            <td class="col-sm-1">
                              <button type="button" class="btn btn-outline-danger btn-sm btn-border-radius" disable>削除</button>
                            </td>
                          </tr>
                        <?php }?>
                      </tbody>
                    </table>

                    <div class="conButton d-flex justify-content-center mt-7">
                      <button type="button" class="btn btn-outline-info btn-sm btn-border-radius mr-2"  data-bs-toggle="modal" data-bs-target="#common_modal">マルチドメイン追加</button>
                      <a href="domain_transfer.php" class="domainAcq btn btn-outline-info btn-sm btn-border-radius mr-2">ドメイン取得/移管</a>
                      <a href="server.php" class="addServer btn btn-outline-info btn-sm btn-border-radius mr-2">サーバー追加</a>
                      <a href="/admin/servers?server=dns" class="addServer btn btn-outline-info btn-sm btn-border-radius mr-2">DNS情報</a>
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

        <div class="modal fade" id="common_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="">Add Multiple Domain</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="add_multidomain.php" method="post" id="add_multiple_domain" class="form-content">
                  <input type="hidden" name="token" value="<?php echo $token ;?>">
                  <div class="row mb-3">
                      <label for="domain" class="col-sm-2 col-form-label">ドメイン名</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" id="domain" column="domain" name="domain" placeholder="ドメイン名">
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="document" class="col-sm-2 col-form-label">ドキュメントルート</label>
                      <div class="col-sm-1">
                          root/
                      </div>
                      <div class="col-sm-7">
                          <input type="text" class="form-control" id="web_dir" name="web_dir" placeholder="8～20文字、半角英数字記号">
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="ftp_user" class="col-sm-2 col-form-label">FTPユーザー名</label>
                      <div class="col-sm-8">
                          <input type="text" class="form-control" id="ftp_user" name="ftp_user" column="username" placeholder="1～255文字、半角英数小文字と_-.@">
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="password" class="col-sm-2 col-form-label">パスワード</label>
                      <div class="col-sm-8">
                          <input type="password" class="form-control" id="password" name="password" placeholder="8～70文字、半角英数字記号">
                      </div>
                  </div>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

        <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="300"></canvas> -->

      </main>
    </div>
  </div>
  <?php require_once("footer.php") ?>