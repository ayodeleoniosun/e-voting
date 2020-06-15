<?php require_once("../idibo.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $admin_title;?> | Change password </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

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
    <script src="../assets/js/jquery.confirm.js" type="text/javascript"></script>
    <script src="../assets/js/idibo.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css" />
<link href="../assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
        
    
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
                    <li class="active"><a href="change_password"><i class="icon-key"></i> Change Password </a> </li>
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
                <li class="panel">
                    <a href="aspirants">
                        <i class="icon-location-arrow"></i> Executives &nbsp; <span id='count_aspirants' class="label label-default"><?php echo count_aspirants();?></span>&nbsp; 
                    </a>                   
                </li>

                <li class="panel">
                    <a href="aspirants">
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
                    <a href="departments">
                        <i class="icon-star"></i> Departments &nbsp; <span  id='count_depts' class="label label-default"><?php echo count_depts();?></span>&nbsp;
                    </a>                   
                </li>
                 -->
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
                    <div class="col-md-12 col-sm-12">
                        <h1 align="center"><i class="icon-key"></i> Change Password </h1>
                    </div>
                </div>
                  <hr/>
					
					<div class="well col-md-12 col-sm-12">
						<div class="white">
							<div id="collapse2" class="body collapse in">
							   <h4 align="center"><i class="icon-key"></i> Change Password </h5>
							   <form id="change_password_form" method="post" class="form-horizontal">
									<input type="hidden" name="gotcha" value="<?php echo $logged_admin_id;?>"/>
									<div class="form-group">
										
										<div class="col-md-12 col-sm-12">
                                            <label>Current Password</label>
										    <input type="password" id="current_password" name="current_password" class="form-control">
										</div> <br/>
										
										<div class="col-md-12  col-sm-12">
                                            <label>New Password</label>
											<input type="password" id="new_password" name="new_password" class="form-control">
										</div> <br/>
										
										<div class="col-md-12  col-sm-12">
                                            <label>Confirm New Password</label>
                                        	<input type="password" id="confirm_new_password" name="confirm_new_password" class="form-control">
										</div>
										
									</div>
									
									<button type="submit" class="btn btn-success btn-md"><i class="icon-check"></i> Change Password</button>
									<br/><br/>
								</form>
							</div>
						</div>
					</div>
					
			</div>

        </div>
        <!--END PAGE CONTENT -->

    </div>

    <!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <?php } include("../footer.php");?>
	<!--END FOOTER -->




    <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

         <!-- PAGE LEVEL SCRIPTS -->
    <script src="../assets/plugins/jasny/js/bootstrap-fileupload.js"></script>
	 <script src="../assets/js/jquery-ui.min.js"></script>
	

 <script src="../assets/plugins/uniform/jquery.uniform.min.js"></script>
       <script src="../assets/js/formsInit.js"></script>
        <script>
            $(function () { formInit(); });
        </script>
<script>
        $(function () { formWysiwyg(); });
        </script>
     <!--END PAGE LEVEL SCRIPTS -->
     
</body>

    <!-- END BODY -->
</html>
