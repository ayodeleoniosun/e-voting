<?php require_once("../idibo.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8" />
    <title><?php echo $admin_title;?> | Settings </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!--END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="../assets/css/jquery-ui.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="../assets/plugins/wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css" />
    <link rel="stylesheet" href="../assets/css/Markdown.Editor.hack.css" />
    <link rel="stylesheet" href="../assets/plugins/CLEditor1_4_3/jquery.cleditor.css" />
    <link rel="stylesheet" href="../assets/css/jquery.cleditor-hack.css" />
    <link rel="stylesheet" href="../assets/css/bootstrap-wysihtml5-hack.css"/>
    <script src="../assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.confirm.js" type="text/javascript"></script>
    <script src="../assets/js/idibo.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/css/bootstrap-fileupload.min.css" />
    
     <link href="../assets/css/jquery-ui.css" rel="stylesheet" />
<link rel="stylesheet" href="../assets/plugins/uniform/themes/default/css/uniform.default.css" />
<link rel="stylesheet" href="../assets/plugins/inputlimiter/jquery.inputlimiter.1.0.css" />
<link rel="stylesheet" href="../assets/plugins/chosen/chosen.min.css" />
<link rel="stylesheet" href="../assets/plugins/colorpicker/css/colorpicker.css" />
<link rel="stylesheet" href="../assets/plugins/tagsinput/jquery.tagsinput.css" />
<link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker-bs3.css" />
<link rel="stylesheet" href="../assets/plugins/datepicker/css/datepicker.css" />
<link rel="stylesheet" href="../assets/plugins/timepicker/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="../assets/plugins/switch/static/stylesheets/bootstrap-switch.css" />
   
<script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
    

     <style>
        ul.wys
        ihtml5-toolbar > li {
            position: relative;
        }
       #cleditorDiv
       {
            display:none;
       }
    </style>
</head>

<body class="padTop53 ">
    <div align='center'> <div id='support_ajax_status' class='support_status'> </div> </div>
    <div align='center'> <div id='ajax_status' class='support_status'> </div> </div>

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
                    <li class="divider"></li>
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
                <li class="panel">
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
                
                <li class="panel active">
                    <a href="settings">
                        <i class="icon-wrench"></i> Settings
                    </a>                   
                </li>
                
                <li class="panel">
                    <a href="aspirants-result">
                        <i class="icon-thumbs-up"></i>Executives Election result
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
                   
                    <br/>
                    
                    <div class="row">
                        
                        <div class="col-md-12 col-sm-12">
                             
                            <h3 align="center"><i class="icon-wrench"></i> Update election settings </h3>
                                
                           <div class="white">
                            
                                <form id="settings_form" method="post" class="form-horizontal">
                                        
                                    <div id="cleditorDiv" class="body collapse in">
                                        <textarea id="cleditor"></textarea>

                                    </div>
                                    
                                    <br/>
                                    
                                    <?php
									
									$settings_exist = is_settings_exist();
									
									if(!$settings_exist)
									{
									?>
									<div class="col-md-12 col-sm-12">
                                        <h4><i class="icon-calendar"></i> Election date</h4>
                                        <hr/>
                                        <div class="form-group">
                                            <label>Select date</label>

                                            <div class="input-group bootstrap-timepicker">
                                                <input type="text" class="form-control"  data-date-format="dd-mm-yyyy" id="dp2" value="<?php echo $current_date;?>" name="start_date" readonly/>
                                                <span class="input-group-addon add-on"><i class="icon-calendar"></i></span>
                                            </div>  
                                        </div>
                                    </div>
                                    
                                    <br/>
                                    
                                    <div class="col-md-12 col-sm-12">
                                        <h4><i class="icon-time"></i> Election Time</h4>
                                        <hr/>
                                        <div class="form-group">
                                            <label>Select start time</label>

                                            <div class="input-group bootstrap-timepicker">
                                                <input class="form-control timepicker-default" type="text" id="start_time" name="start_time" value=""readonly/>
                                                <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                                            </div>  
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Select end time</label>

                                            <div class="input-group bootstrap-timepicker">
                                                <input class="form-control timepicker-default" type="text" id="end_time" name="end_time" value=""readonly/>
                                                <span class="input-group-addon add-on"><i class="icon-time"></i></span>
                                            </div>  
                                        
                                    <br/>
                                    <button type="submit" class="btn btn-success "><i class="icon-check"></i> Update </button>
                                        </div>
                                    </div>
                                    
                                    <br/>
                                    <div class="col-md-12 col-sm-12">
                                    
                                    <br/>
									<?php
									}
									else if($settings_exist)
									{
										list($start_date,$start_time,$end_time)  = get_election_settings();

                                        ?>
											<div class="col-md-12">
											<h4><i class="icon-calendar"></i> Election date</h4>
											<hr/>
											<div class="form-group">
												<label>Select date</label>

												<div class="input-group bootstrap-timepicker">
													<input type="text" class="form-control"  data-date-format="dd-mm-yyyy" id="dp2" name="start_date"  value="<?php echo $start_date;?>"readonly/>
													<span class="input-group-addon add-on"><i class="icon-calendar"></i></span>
												</div>  
											</div>
										</div>
										
										<br/>
										
										<div class="col-md-12">
											<h4><i class="icon-time"></i> Election Time</h4>
											<hr/>
											<div class="form-group">
												<label>Select start time</label>

												<div class="input-group bootstrap-timepicker">
													<input class="form-control timepicker-default" type="text" id="start_time" name="start_time"  value="<?php echo $start_time;?>"readonly/>
													<span class="input-group-addon add-on"><i class="icon-time"></i></span>
												</div>  
											</div>
											
											<div class="form-group">
												<label>Select end time</label>

												<div class="input-group bootstrap-timepicker">
													<input class="form-control timepicker-default" type="text" id="end_time" name="end_time"  value="<?php echo $end_time;?>" readonly/>
													<span class="input-group-addon add-on"><i class="icon-time"></i></span>
												</div>  
											
										<br/>
										<button type="submit" class="btn btn-success "><i class="icon-check"></i> Save changes </button>
											</div>
										</div>
										
										<br/>
										<div class="col-md-12 col-sm-12">
										
										<br/>
										<?php
									
									}
								?>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="hide_stupid" class="row">
                        <div class="col-lg-12">
                            <div class="box">
                                <div id="div-3" class="body tab-content">
                                    <div class="tab-pane fade active in" id="markdown">
                                        <div class="wmd-panel">
                                            <div id="wmd-button-bar" class="btn-toolbar"></div>
                                            <textarea class="form-control wmd-input" rows="10" name="description" id="wmd-input"></textarea>
                                        
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>


            </div>

        </div>
        <div style="clear:both"></div>
    </div><!--END PAGE CONTENT -->

    <!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <br/><br/><br/><br/><?php include("../footer.php"); } ?>
    <!--END FOOTER -->


     <!-- GLOBAL SCRIPTS -->
    <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

         <!-- PAGE LEVEL SCRIPTS -->
     <script src="../assets/plugins/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="../assets/plugins/bootstrap-wysihtml5-hack.js"></script>
    <script src="../assets/plugins/CLEditor1_4_3/jquery.cleditor.min.js"></script>
    <script src="../assets/plugins/pagedown/Markdown.Converter.js"></script>
    <script src="../assets/plugins/pagedown/Markdown.Sanitizer.js"></script>
    <script src="../assets/plugins/Markdown.Editor-hack.js"></script>
    <script src="../assets/js/editorInit.js"></script>
    <script src="../assets/plugins/jasny/js/bootstrap-fileupload.js"></script>
     <script src="../assets/js/jquery-ui.min.js"></script>
    

      <!-- PAGE LEVEL SCRIPT-->
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
    <script src="../assets/plugins/jquery-steps-master/build/jquery.steps.js"></script>   
         <script src="../assets/plugins/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
    <script src="../assets/plugins/bootstrap-wysihtml5-hack.js"></script>
    <script src="../assets/plugins/CLEditor1_4_3/jquery.cleditor.min.js"></script>
    <script src="../assets/plugins/pagedown/Markdown.Converter.js"></script>
    <script src="../assets/plugins/pagedown/Markdown.Sanitizer.js"></script>
    <script src="../assets/plugins/Markdown.Editor-hack.js"></script>
    <script src="../assets/js/editorInit.js"></script>

    <script>
        $(function () { formWysiwyg(); });
        </script>
        <script src="../assets/js/formsInit.js"></script>
        <script>
            $(function () { formInit(); });
        </script>
        
     <!--END PAGE LEVEL SCRIPTS -->
     
</body>

    <!-- END BODY -->
</html>
