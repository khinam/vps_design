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
			        	<form action="" method="post">
			        		<div class="mt-3 mb-3">ドメイン取得</div>
			        		<div class="row mb-3">
			        			<label for="domain" class="col-sm-3 col-form-label">ドメイン名</label>
			        			<div class="col-sm-7">
                                    <input type="text" class="form-control" name="domain" id="">
                                </div>
                                <div class="col-sm-2">
                                	<button type="submit" class="btn btn-info btn-sm">他社移管申請</button>
                                </div>
			        		</div>
			        	</form>
	                    <form action="" method="post">
	                    	<div class="mt-3 mb-4">ドメイン移管（他社から弊社に移管）</div>
	                    	<div class="row mb-3">
	                    		<label for="domain" class="col-sm-3 col-form-label">ドメイン名</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="domain" id="usdomain">
                                </div>
	                    	</div>
	                    	<div class="row mb-3">
                                <label for="authcode" class="col-sm-3 col-form-label">AuthCode</label>
                                <div class="col-sm-7">
                                	<input type="text" class="form-control" id="authcode" name="authcode">
                                </div>
                            </div>
                           	<div class="row mb-3">
                           		<div class="col-sm-3"></div>
                           		<div class="col-sm-6"></div>
                           		<div class="col-sm-3">
                           			<button type="submit" class="btn btn-info btn-sm">申請</button>
                           		</div>
                           	</div>
	                    </form>  
			        	<form action="" method="post">
			        		<div class="mb-3">ドメイン移管（弊社から他社に移管）</div>
			        		<div class="row mb-3">
                                <label for="domain" class="col-sm-3 col-form-label">ドメイン名</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="domain">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6"></div>
                                <div class="col-sm-3">
                                	<button type="submit" class="btn btn-info btn-sm">他社移管申請</button>
                                </div>
                            </div>
			        	</form>
			        	<div class="pt-3">
			        		<a href="index.php" class="btn btn-outline-info btn-sm back-btn">戻る</a>
			        	</div>
			        </div>
			    </main>
			</div>
		</div>

<?php require_once('footer.php') ?>