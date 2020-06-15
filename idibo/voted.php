<?php require_once("../idibo.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $admin_title;?> | Voted </title>
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
    
    if(!isset($_SESSION["tesojue"]))
    {
        echo error_admin_msg("You are not allowed to view this page because you're not logged in. <br/> Click <a href='index.php'><b>HERE</b></a> to login now.");
    }
    else if(isset($_SESSION["tesojue"]))
    {
        $baba = $_SESSION["tesojue"];
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
                    <li><a href="change_password.php"><i class="icon-key"></i> Change Password </a> </li>
                    <li><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')"><i class="icon-signout"></i> Logout </a> </li>        

                </ul>

            </nav>

        </div>
        <!-- END HEADER SECTION -->

        <!-- MENU SECTION -->
       <div id="left">
            <ul id="menu" class="collapse">
                <li class="panel">
                    <a href="dashboard.php">
                        <i class="icon-dashboard"></i> Dashboard
                    </a>                   
                </li>
                <li class="panel">
                    <a href="aspirants.php">
                        <i class="icon-location-arrow"></i> Aspirants &nbsp; <span id='count_aspirants' class="label label-primary"><?php echo count_aspirants();?></span>&nbsp; 
                    </a>                   
                </li>
                
                <li class="panel active">
                    <a href="voters.php">
                        <i class="icon-user"></i> Voters &nbsp; <span  id='count_voters' class="label label-green"><?php echo count_voters();?></span>&nbsp;
                    </a>                   
                </li>
                <li class="panel">
                    <a href="keys.php">
                        <i class="icon-key"></i> Voting keys &nbsp; <span  id='count_keys' class="label label-purple"><?php echo count_keys();?></span>&nbsp;
                    </a>                   
                </li>
                <li class="panel">
                    <a href="posts.php">
                        <i class="icon-spinner"></i> Posts &nbsp; <span  id='count_posts' class="label label-default"><?php echo count_posts();?></span>&nbsp;
                    </a>                   
                </li>
                <li class="panel">
                    <a href="departments.php">
                        <i class="icon-star"></i> Departments &nbsp; <span  id='count_depts' class="label label-red"><?php echo count_depts();?></span>&nbsp;
                    </a>                   
                </li>
                
                 <li class="panel">
                    <a href="result.php">
                        <i class="icon-thumbs-up"></i> Election result
                    </a>                   
                </li>
                
            </ul>

        </div>
        <!--END MENU SECTION -->

        
		<!--PAGE CONTENT -->
        <div id="content">
            
			<div class="inner" style="min-height: 700px;">

            <div class="row">
				<h2 align="center"><i class="icon-user"></i> All voters<hr/> </h2>
                
				<div class="col-lg-12">
					
					<script type="text/javascript">
	
						$(document).ready(function()
						{
							var per_page = 50;
							var current_page = 1;
							var dataString = "current_page="+current_page+"&per_page="+per_page;
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#fetch").html("Retrieving all voters &nbsp; <img src='../images/loading_bar.gif'/><br/>");
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
								url:"display.php?DisplayAllVoters",
								
								success:function(msg)
								{
									$("#display_voters").html(msg);
								}
							});
						});
							
					</script>
					
					<div id='fetch'>  </div>	
					<div id='display_voters'>  </div>	
					<div id='display_search_voters'>  </div>    
					<div id='display_modify_voters'>  </div>
					<div id='display_search_modify_voters'>  </div>
					<div class="clearfix"> </div>
				</div>
				
                </div>
                
                </div>
            
			</div> 
		</div>
	</div>              
            
          <!--END PAGE CONTENT -->

	<!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <?php include("footer.php"); } ?>
	<!--END FOOTER -->
      <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

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
        <script>
            $(function () { formInit(); });
        </script>
	
    <!-- END BODY -->
</html>
