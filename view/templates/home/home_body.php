<div class="layout-demo-wrapper mt-0">
	<div class="layout-demo-placeholder">
	 
	</div>
	<div class="">
	    
	     <div class="row g-6">
                <div class="col-xl-12">
                  <!--<h6 class="text-body-secondary">Available</h6>-->
                  <div class="nav-align-top">
                    <ul class="nav nav-pills mb-4" role="tablist">
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link active"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-home"
                          aria-controls="navs-pills-top-home"
                          aria-selected="true">
                          Available
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-profile"
                          aria-controls="navs-pills-top-profile"
                          aria-selected="false">
                          On Rent
                        </button>
                      </li>
                      <li class="nav-item">
                        <button
                          type="button"
                          class="nav-link"
                          role="tab"
                          data-bs-toggle="tab"
                          data-bs-target="#navs-pills-top-messages"
                          aria-controls="navs-pills-top-messages"
                          aria-selected="false">
                          On Maintenance
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
                        <?php include ROOT_PATH . '/view/templates/home/avl_vehicle_list.php';?>
                      </div>
                      <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                        <?php include ROOT_PATH . '/view/templates/home/avl_list.php';?>
                      </div>
                      <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
                        <?php include ROOT_PATH . '/view/templates/home/avl_list.php';?>
                      </div>
                    </div>
                  </div>
                </div> 
	    
	    </div>
	    
	    
	    
        
	</div>
</div>