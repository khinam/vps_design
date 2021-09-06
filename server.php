<?php require_once('header.php') ?>
	<body>
		<div class="container-fluid">
		    <div class="row">
		      <?php require_once('sidebar.php') ?>

		      	<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-2 mb-3">
		        <?php require_once('page_header.php'); ?>

			        <div class="contractId">
			          <div class="d-flex flex-row bd-highlight mb-3">
			            <div class="p-2 bd-highlight">
			              <span class="p-r-10"><i class="fas fa-id-badge"></i></span>
			              契約ID
			            </div>
			            <div class="vl-2 p-2"></div>
			            <div class="p-2 bd-highlight">D000123</div>
			          </div>
			        </div>
			        <div class="pageWrapper pb-4">
			        	 <p class="text-center"><span class="saba-tsuika">サーバー追加</span></p>
				            <div class="row row-border">
				                <div class="col-sm-3">
				                    <div class="kyoyo-saba">共用サーバー</div>
				                </div>
				                <div class="col-sm-3">
				                    <div class="vps-saba">VPSサーバー</div>
				                    <div class="vps-btn btn-group" role="group" data-toggle="buttons">
				                        <button type="button" class="btn btn-primary btn-ssd active" onclick="vpsSSD()" checked autocomplete="off"> SSD</button>
				                        <button type="button" class="btn btn-primary btn-hdd" onclick="vpsHDD()" autocomplete="off"> HDD</button>
				                    </div>

				                </div>
				                <div class="col-sm-3">
				                    <div class="wd-saba">WindowsDesktop</div>
				                    <div class="wd-btn btn-group" role="group" data-toggle="buttons">
				                        <button type="button" class="btn btn-primary btn-ssd" onclick="wdSSD()" autocomplete="off"> SSD</button>
				                        <button type="button" class="btn btn-primary btn-hdd" onclick="wdHDD()" autocomplete="off"> HDD</button>
				                    </div>
				                </div>
				                <div class="col-sm-3">
				                    <div class="senyo-saba">専用サーバー</div>
				                </div>
				            </div>

				            <div class="row saba-result">
				                <div id="vps-ssd"> VPS SSD </div>
				                <div id="vps-hdd"> VPS HDD </div>
				                <div id="wd-ssd"> WD SSD </div>
				                <div id="wd-hdd"> WD HDD </div>
				            </div>
				            <div class="pt-3"><a href="index.php" class="btn btn-outline-info btn-sm">戻る</a></div>
			        </div>
			    </main>
			</div>
		</div>

<?php require_once('footer.php') ?>