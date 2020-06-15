<?php require_once("../idibo.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $admin_title;?> | Executives </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES 	-->

    <!-- PAGE LEVEL STYLES -->
    <link href="../assets/plugins/flot/examples/examples.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/plugins/timeline/timeline.css" />
    <link rel="stylesheet" href="../assets/plugins/validationengine/css/validationEngine.jquery.css" />
    <link rel="stylesheet" href="../assets/plugins/uniform/themes/default/css/uniform.default.css" />
	<link rel="stylesheet" href="../assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
	<link rel="stylesheet" href="../assets/plugins/chosen/chosen.min.css" />
	<link rel="stylesheet" href="../assets/plugins/colorpicker/css/colorpicker.css" />
	<link rel="stylesheet" href="../assets/plugins/tagsinput/jquery.tagsinput.css" />
	<link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker-bs3.css" />
	<link rel="stylesheet" href="../assets/plugins/datepicker/css/datepicker.css" />
	<link rel="stylesheet" href="../assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />
	<link rel="stylesheet" href="../assets/plugins/switch/static/stylesheets/bootstrap-switch.css" />
	
    <script src="../assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/idibo.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.confirm.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css" />
	    <link href="../assets/datatables/css/datatables.css" rel="stylesheet" />
    <link href="../assets/datatables/css/button.min.css" rel="stylesheet" />

</head>
    
    <div align='center'> <div id='support_ajax_status' class='support_status'> </div> </div>
    <div align='center'> <div id='ajax_status' class='support_status'> </div> </div>

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body class="padTop53">

    <!-- MAIN WRAPPER -->
    
    <?php
    
    if(!isset($_SESSION["tesojue_admin"]))
    {
        echo error_admin_msg("You are not allowed to view this page because you're not logged in. <br/> Click <a href='index'><b>HERE</b></a> to login now.");
    }
    else if(isset($_SESSION["tesojue_admin"]))
    {
        $baba = $_SESSION["tesojue_admin"];
        $logged_admin_id = get_admin_id($baba);
    
    ?>
    
    <div id="wrap">
        
       
    <!-- HEADER SECTION -->
        <div id="top">

            <nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-success btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
                    <i class="icon-align-justify"></i> MENU
                </a>
                <!-- LOGO SECTION -->
                <header class="navbar-header">
                    <a href="#" class="navbar-brand">
                    		<?php echo strtoupper($admin_title);?> PANEL
                	</a>
                </header>
                <!-- END LOGO SECTION -->
                <ul class="nav navbar-top-links navbar-right">
                    <li><a href="change_password"><i class="icon-key"></i> Change Password </a> </li>
                    <li><a href="logout" onclick="return confirm('Are you sure you want to logout?')"><i class="icon-signout"></i> Logout </a> </li>        

                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <div id="left">
            <ul id="menu" class="collapse">
                <li class="panel">
                    <a href="dashboard">
                        <i class="icon-dashboard"></i> Dashboard
                    </a>                   
                </li>
                <li class="panel active">
                    <a href="aspirants">
                        <i class="icon-location-arrow"></i> Executives &nbsp; <span id='count_aspirants' class="label label-default"><?php echo count_aspirants();?></span>&nbsp; 
                    </a>                   
                </li>

                <li class="panel">
                    <a href="floor-reps">
                        <i class="icon-location-arrow"></i> Floor reps &nbsp; <span id='count_aspirants' class="label label-default"><?php echo count_floor_reps();?></span>&nbsp; 
                    </a>                   
                </li>
                
                <li class="panel">
                    <a href="voters">
                        <i class="icon-user"></i> Voters &nbsp; <span  id='count_voters' class="label label-default"><?php echo count_voters();?></span>&nbsp;
                    </a>                   
                </li>
                <li class="panel">
                    <a href="accreditation">
                        <i class="icon-spinner"></i> Accreditation 
                    </a>                   
                </li>
                <li class="panel">
                    <a href="keys">
                        <i class="icon-key"></i> Voting PINs &nbsp; <span  id='count_keys' class="label label-default"><?php echo count_keys();?></span>&nbsp;
                    </a>                   
                </li>
                <li class="panel">
                    <a href="posts">
                        <i class="icon-spinner"></i> Posts &nbsp; <span  id='count_posts' class="label label-default"><?php echo count_posts();?></span>&nbsp;
                    </a>                   
                </li>
                <!-- <li class="panel">
                    <a href="constituencies">
                        <i class="icon-star"></i> Constituencies &nbsp; <span  id='count_depts' class="label label-default"><?php echo count_depts();?></span>&nbsp;
                    </a>                   
                </li> -->
                
                <li class="panel">
                    <a href="settings">
                        <i class="icon-wrench"></i> Settings
                    </a>                   
                </li>
                
                <li class="panel">
                    <a href="aspirants-result">
                        <i class="icon-thumbs-up"></i> Executives Election result
                    </a>                   
                </li>
                <li class="panel">
	                <a href="floor-reps-result">
	                    <i class="icon-signal"></i> Floor Reps Election result
	                </a>                   
	            </li>
                
            </ul>

        </div>
        <!--END MENU SECTION -->

        
		<!--PAGE CONTENT -->
        <div id="content">
            
			<div class="inner" style="min-height: 700px;">

            <div class="row">
            	<br/>
				<h2 align="center"><i class="icon-group"></i> All Aspirants<hr/> </h2>
                
				<div class="col-md-12 col-sm-12">
					
					<ul class="nav nav-tabs">
						<li class="active"><a href="#add-aspirants" data-toggle="tab">Add Aspirants</a>
						</li>
						<li><a href="#view-aspirants" data-toggle="tab">View Aspirants <span id='count_vote_aspirants' class="label label-default"><?php echo count_aspirants();?></span></a>
						</li>
					</ul>

					<div class="tab-content">
						
						<div class="tab-pane fade in active" id="add-aspirants">
							
							<?php

							$post_added = is_post_added();
							
							if(!$post_added)
							{ 
								echo error_admin_msg("No post yet. Click <a href='posts'><b>HERE</b></a> to add new post.");
							}
							else
							{
							?>
								<h4><i class="icon-plus"></i> Add Aspirants <hr/></h4>
								<div class="form-group">
										<p><i><b> Ensure that a photo of 640px by 640px is uploaded, else the photo will be distorted. </b></i></p><br/>
                                        
                                    <form id="add_aspirant_form" method="post" class="form-horizontal" enctype="multipart/form-data">
										
										<div class="col-md-12 col-sm-12">
							
											<div class="col-md-4 col-sm-4">
												<label>Upload Aspirant picture</label>
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
														<div>
															<br/><span class="btn btn-file btn-info"><span class="fileupload-new"><i class="icon-camera"></i>  Select aspirant's photo</span><span class="fileupload-exists"><i class="icon-mail-forward "></i> Change</span>
															<input type="file" id="aspirant_photo" name="aspirant_photo" accept=".jpg,.jpeg,.png,.JPG,.PNG,.JPEG"/>
																</span>
															<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-remove"></i> Remove</a>
														</div>
													</div>
											</div>

											<div class="col-md-1 col-sm-1"></div>
						
											<div class="col-md-6 col-sm-6">
											
											<div class="form-group">
												<label>Select post</label>
												<?php echo fetch_all_posts();?>
											</div>
											
											<div class="form-group">
												<label>Fullname </label>
												<input type="text" id="fullname" name="fullname" class="form-control" placeholder="John Doe"/>
											</div>
											
											<div class="form-group">
												<label>Nickname  <i>(Optional)</i></label>
												<input type="text" id="nickname" name="nickname" class="form-control" placeholder="Doe"/>
											</div>
											
										<br/>
										
										<button type="submit" class="btn btn-success btn-lg pull-right"><i class="icon-plus"></i> Add</button>
										<br/><br/><br/><br/><br/><br/>
										
										</div>

									</form>
									</div>
								</div> 
								<?php
								}
							?>
						</div>


						<div class="tab-pane fade" id="view-aspirants">
							
								<script type="text/javascript">
				
									$(document).ready(function()
									{
										var per_page = 20;
										var current_page = 1;
										var dataString = "current_page="+current_page+"&per_page="+per_page;
										
										$.ajaxSetup(
										{
											beforeSend: function()
											{
												$("#fetch").html("Retrieving all aspirants &nbsp; <img src='../images/loading_bar.gif'/><br/>");
											},
											complete: function()
											{
												$("#fetch").html("");
											}
										});
										
										$.ajax(
										{
											type:"POST",
											data: dataString,
											cache:false,
											url:"display?DisplayAllAspirants",
											
											success:function(msg)
											{
												$("#display_aspirants").html(msg);
											}
										});
									});
										
								</script>
								
								<div id='fetch'>  </div>	
								<div id='display_aspirants'>  </div>	
								<div id='display_search_aspirants'>  </div>	
								<div id='display_search_modify_aspirants'>  </div>
								<div id='display_modify_aspirants'>  </div>
								<div class="clearfix"> </div>
						</div>  
							
							<br/><br/><br/><br/>  
							
								<!-- <script>
								
									$('.all_votes_div').addClass('hide');
									$('#vote_div'+1).removeClass('hide');
								 
									$('.next').click(function()
									{
										var current_num = parseInt($(this).attr('id'));     
										var next_num = current_num+1;
										$('#vote_div'+current_num).addClass('hide');
										$('#vote_div'+next_num).removeClass('hide');
									});
								 
									$('.previous').click(function()
									{
										var current_num = parseInt($(this).attr('id'));     
										var prev_num = current_num-1;
										$('#vote_div'+current_num).addClass('hide');
										$('#vote_div'+prev_num).removeClass('hide');
									});
								
								</script>	 -->

							</div>  

								
						</div>
						
					</div>
                      
                </div>
                
                </div>
            
			</div> 
		</div>
	</div>              
            
          <!--END PAGE CONTENT -->

	<!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <?php include("../footer.php"); } ?>
	
    <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

    <script src="../assets/datatables/js/datatables.js"></script>
	<script src="../assets/datatables/js/button.min.js"></script>
	<script src="../assets/datatables/js/button.flash.min.js"></script>
	<script src="../assets/datatables/js/button.html5.min.js"></script>
	<script src="../assets/datatables/js/button.print.min.js"></script>
	<script src="../assets/datatables/js/jzip.min.js"></script>
	<script src="../assets/datatables/js/pdffont.min.js"></script>
	<script src="../assets/datatables/js/pdfmake.min.js"></script>

    
    <!-- PAGE LEVEL SCRIPTS -->
    <script src="../assets/plugins/jasny/js/bootstrap-fileupload.js"></script>
	<script src="../assets/js/jquery-ui.min.js"></script>
    <script src="../assets/plugins/uniform/jquery.uniform.min.js"></script>
	<script src="../assets/plugins/inputlimiter/jquery.inputlimiter.1.3.1.min.js"></script>
	<script src="../assets/plugins/chosen/chosen.jquery.min.js"></script>
	<script src="../assets/plugins/colorpicker/js/bootstrap-colorpicker.js"></script>
	<script src="../assets/plugins/tagsinput/jquery.tagsinput.min.js"></script>
	<script src="../assets/plugins/validVal/js/jquery.validVal.min.js"></script>
	<script src="../assets/plugins/daterangepicker/daterangepicker.js"></script>
	<script src="../assets/plugins/daterangepicker/moment.min.js"></script>
	<script src="../assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
	<script src="../assets/plugins/timepicker/js/bootstrap-timepicker.min.js"></script>
	<script src="../assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>
	<script src="../assets/plugins/jquery.dualListbox-1.3/jquery.dualListBox-1.3.min.js"></script>
	<script src="../assets/plugins/autosize/jquery.autosize.min.js"></script>
	<script src="../assets/plugins/jasny/js/bootstrap-inputmask.js"></script>
	<script src="../assets/plugins/jquery-steps-master/lib/jquery.cookie-1.3.1.js"></script>
 
	<script src="../assets/js/formsInit.js"></script>
    
    <!-- END BODY -->
</html>
