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
        
        <div class="pageWrapper p-4">
                <h4>Contact Us</h4>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="" placeholder="Enter Name">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email Address:</label>
                                <input type="email" class="form-control" id="" placeholder="Enter Email">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone:</label>
                                <input type="text" class="form-control" id="" placeholder="Enter Phone">
                            </div>
                        </div>
                        <!-- <div class="col-md-1">
                            <div class="vl"></div>
                        </div> -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Message:</label>
                                <textarea id="message" class="form-control" name="message" rows="4" placeholder="Enter Message ....."></textarea>
                            </div>
                            <div class="mb-3 con-submit col-auto">
                                <button class="btn btn-outline-info form-control">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

      </main>
    </div>
  </div>
  <?php require_once('footer.php') ?>