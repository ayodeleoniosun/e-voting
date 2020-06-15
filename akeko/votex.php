<?php require_once("../idibo.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $student_title;?> | Vote </title>
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

    <body class="padTop53">

		<style>
			.hide{display: none;}
			input[type=radio] {
				width: 1.8em; height: 1.8em;
			}
		</style>    
	<?php
    
    if(!isset($_SESSION["tesojue_student"]))
    {
        echo error_admin_msg("You are not allowed to view this page because you're not logged in. <br/> Click <a href='index'><b>HERE</b></a> to login now.");
    }
    else if(isset($_SESSION["tesojue_student"]))
    {
        $student = $_SESSION["tesojue_student"];
        $key = $_SESSION["tesojue_key"];
        $constituency = $_SESSION["tesojue_constituency"];
        $logged_student_id = get_student_id($student);
    ?>
    
    <div id="wrap">
        
       
    <!-- HEADER SECTION -->
        <div id="top">
			<nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
                <header class="navbar-header">
                    <a href="#" class="navbar-brand">
                        <?php echo $vote_title;?>
                    </a>
                </header>
            </nav>
        </div>
        <!-- END HEADER SECTION -->

		<!--PAGE CONTENT -->
            
        <br/>

    <div class="white vote_div">
            
	<div id="vote_area">
		<h4> Dear <b><?php echo $student;?> </b>, you are welcome to Independence hall voting platform. Kindly read these instructions and then click on the proceed button. </h4>
		<form id="vote_form" method="post">
			
			<input type="hidden" name="student" value="<?php echo $student;?>"/>
			<input type="hidden" name="key" value="<?php echo $key;?>"/>

            <?php

            list($start_date,$start_time,$end_time)  = get_election_settings();
	    	
	    	$formatted_start_date = strtotime($start_date);
	    	$formatted_current_date = strtotime($current_date);
	    	$formatted_start_time = strtotime($start_time);
	    	$formatted_current_time = strtotime($current_time);
	    	$formatted_end_time = strtotime($end_time);
	    	
	    	if($formatted_current_date < $formatted_start_date) {
				echo error_admin_msg("Sorry, election date has not started. Check back later.");
			}
			else if ( ( ($formatted_current_date < $formatted_start_date) || ($formatted_current_date == $formatted_start_date) ) && ($formatted_current_time < $formatted_start_time) ) {
				echo error_admin_msg("Sorry, election has not started. Check back later.");
			}
			
			else if($formatted_current_date > $formatted_start_date) {
				echo error_admin_msg("Sorry, election date had ended. Thanks.");
			}
			else if ( ( ($formatted_current_date > $formatted_start_date) || ($formatted_current_date == $formatted_start_date) ) && ($formatted_current_time > $formatted_end_time) ) {
				echo error_admin_msg("Sorry, election had ended. Thanks.");
			}
			else
			{
				?>

				<div id="all_floor_reps_div">

					<?php

					//floor rep

					$rep_query = $db_handle->prepare("SELECT *FROM `floor_reps` WHERE `constituency` = ? ORDER BY `rep_id`");
					$rep_query->bindparam(1,$constituency);
					$rep_query->execute();
					$rep_rows = $rep_query->rowCount();
					$i=1;
					
					if($rep_rows == 0)
					{
						echo error_admin_msg("No floor rep yet for your constituency.");

						?>
						<input type="hidden" name="total_rep" value="0"/>
						<input type="hidden" name="constituency" value="none"/>
						<input type="radio" value="none" name="rep" style="display:none" checked="checked"/> 

						<div align="center">
							<button class='continue_to_aspirants btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>
						</div>

						<?php
					}
					else
					{
						?>

						<input type="hidden" name="total_rep" value="<?php echo $rep_rows;?>"/>
						<input type="hidden" name="constituency" value="<?php echo $constituency;?>"/>

						<div class="vote_head" align='center'>FLOOR REP FOR <?php echo strtoupper($constituency);?> CONSTITUENCY</div>
						
						<?php

						while($fetch = $rep_query->fetch())
						{	
							
							$rep_id = $fetch['rep_id'];
							$unique_id = $fetch['unique_id'];
							$aspirant_fullname = strtoupper($fetch['fullname']);
							$aspirant_nickname = ucfirst($fetch['nickname']);
							$path = $fetch['path'];
							
							if($path == "")
							{
								$folder = "../images/";
								$full_path = $folder."default.png"; 
							}
							else
							{
								$full_path = "../floor-reps/".$path;
							}
						
							
							if($rep_rows == 1) {
								?>         
									
								<div class="col-md-12 col-sm-12">
											
									<div align="center">
										<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
									</div>
									
									<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/><i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
									
									<div align="center">
										<input type="radio" id="yes-rep<?php echo $rep_id;?>" name="rep" value="yes-<?php echo $rep_id;?>"/>
									
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('yes-rep<?php echo $rep_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

										<input type="radio" id="no-rep<?php echo $rep_id;?>" name="rep" value="no-<?php echo $rep_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('no-rep<?php echo $rep_id;?>').checked = true"> NO</span></b> &nbsp; &nbsp; &nbsp;

									</div>
									
								</div>
								
							<?php
						
							} else {
								?>

								<div class="col-md-4 col-sm-4">
											
									<div align="center">
										<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
									</div>
									
									<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/><i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
									
									<div align="center">
										<input type="radio" id="rep<?php echo $rep_id;?>" name="rep" value="yes-<?php echo $rep_id;?>"/>
									
									<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('rep<?php echo $rep_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; 
										</div>
									
								</div>
								
								<?php
							}
						}
						?>
						<div style="clear:both"></div>
						
						<div align="center">
							<input type="radio" value="none" name="rep" style="display:none" checked="checked"/> 
							<hr/><input type="radio" value="none" name="rep" id="none<?php echo $rep_id;?>"/> 
								<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $rep_id;?>').checked = true">Vote for none</span></b>
							<br/>
						</div> 
						<br/>

						<div align="center">
							<button class='continue_aspirants btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>
						</div> 
				<?php
				}
						
				//aspirants

				?>
				</div>

				<div id="all_aspirants_div" style="display:none">

				<?php

				$post_query = $db_handle->prepare("SELECT DISTINCT `post_id` FROM `aspirants` ORDER BY `post_id`");
				$post_query->execute();
				$rows = $post_query->rowCount();
				$i=1;
				
				?>
				<input type="hidden" name="total" value="<?php echo $rows;?>"/>

				<?php

				if($rows == 0)
				{
					echo error_admin_msg("No aspirant yet.");
				}
				else
				{
					?>

					<div align="center">
						<button class='back_reps btn btn-lg btn-success' type='button'><i class="icon-chevron-left"></i> Back to floor rep</button>
					</div> <br/><br/>
						
					<?php

					while($row = $post_query->fetch())
					{	
						$post_id = $row['post_id'];
						$post_name = get_post_name($post_id);

						$query = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `post_id` = ? AND `qualify` = '1'");
						$query->bindparam(1,$post_id);
						$query->execute();
						$count = $query->rowCount();
						
						if($count == 0) 
						{
							echo error_admin_msg("No aspirant yet for the post of <b>$post_name </b>.");
						}
						
						if( ($i==1) && ($i == $rows) ) 
						{
							if($count == 1)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-12 col-sm-12">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/><i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="yes-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('yes-post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

											<input type="radio" id="no-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="no-<?php echo $aspirant_id;?>"/>
											
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('no-post<?php echo $aspirant_id;?>').checked = true"> NO</span></b> &nbsp; &nbsp; &nbsp;

										</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">No, I don't want to vote for anybody here.</span></b>
								</div> <br/>
							
								<div align="center">
								<button id='<?php echo $i;?>' class='continue btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>

								</div> 
							</div>
							<?php
							}
							
							else if($count == 2)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-6 col-sm-6">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/><i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
							
								<div align="center">
								<button id='<?php echo $i;?>' class='continue btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>

								</div> 
							</div>
							<?php
							}
							else
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-4 col-sm-4">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<div style="min-height:150px">
											<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										</div>

										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES </span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
							
								<div align="center">
								<button id='<?php echo $i;?>' class='continue btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>

								</div> 
							</div>
							<?php
							}
						}
						
						else if( ($i==1) && ($i !== $rows) ) 
						{
							if($count == 1)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>XPOST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-12 col-sm-12">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/><i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										

										<div align="center">
											<input type="radio" id="yes-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('yes-post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

											<input type="radio" id="no-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="no-<?php echo $aspirant_id;?>"/>
											
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('no-post<?php echo $aspirant_id;?>').checked = true"> NO</span></b> &nbsp; &nbsp; &nbsp;

										</div>

									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
							
								<div align="center">
									<button id='<?php echo $i;?>' class='next btn btn-lg btn-primary' type='button' >Next <i class="icon-arrow-right"></i></button>
								</div> 
								
							</div>
							<?php
							}
							
							else if($count == 2)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-6 col-sm-6">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/><i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
							
								<div align="center">
									<button id='<?php echo $i;?>' class='next btn btn-lg btn-primary' type='button' >Next <i class="icon-arrow-right"></i></button>
								</div> 
								
							</div>
							<?php
							}
							else
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>PST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-4 col-sm-4">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<div style="min-height:150px">
											<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										</div>

										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
							
								<div align="center">
									<button id='<?php echo $i;?>' class='next btn btn-lg btn-primary' type='button' >Next <i class="icon-arrow-right"></i></button>
								</div> 
							 
							</div>
							<?php
							}
						}
						else if($i < $rows)
						{
							if($count == 1)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POXST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-12 col-sm-12">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="yes-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('yes-post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

											<input type="radio" id="no-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="no-<?php echo $aspirant_id;?>"/>
											
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('no-post<?php echo $aspirant_id;?>').checked = true"> NO</span></b> &nbsp; &nbsp; &nbsp;

										</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
											
									<div align="center">
										<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'><i class="icon-arrow-left"></i> Previous </button> &nbsp; &nbsp;
										
										<button id='<?php echo $i;?>' class='next btn btn-lg btn-info' type='button' >Next <i class="icon-arrow-right"></i></button>
									</div> 
								</div>
								<?php
							}
							else if($count == 2)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POSTR OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-6 col-sm-6">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
											<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
											
													
									<div align="center">
										<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'><i class="icon-arrow-left"></i> Previous </button> &nbsp; &nbsp;
										
										<button id='<?php echo $i;?>' class='next btn btn-lg btn-info' type='button' >Next <i class="icon-arrow-right"></i></button>
									</div> 
								</div>
								<?php
							}
							else
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POXST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-4 col-sm-4">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<div style="min-height:150px">
											<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										</div>

										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
											
													
									<div align="center">
										<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'><i class="icon-arrow-left"></i> Previous </button> &nbsp; &nbsp;
										
										<button id='<?php echo $i;?>' class='next btn btn-lg btn-info' type='button' >Next <i class="icon-arrow-right"></i></button>
									</div> 
								</div>
								<?php
							}
						}
						else if($i == $rows)
						{
							if($count == 1)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POSTOP OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-12 col-sm-12">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="yes-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('yes-post<?php echo $aspirant_id;?>').checked = true"> YES</span></b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

											<input type="radio" id="no-post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="no-<?php echo $aspirant_id;?>"/>
											
											<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('no-post<?php echo $aspirant_id;?>').checked = true"> NO</span></b> &nbsp; &nbsp; &nbsp;

										</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
											
								<div align="center">
									<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'>&laquo; Previous</button> &nbsp; &nbsp;
											
									<button id='<?php echo $i;?>' class='continue btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>
								</div>
								</div>
								<?php
							}
							else if($count == 2)
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>POSTXOP OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-6 col-sm-6">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
											<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										
										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES </span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
								
								<div align="center">
									<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'>&laquo; Previous</button> &nbsp; &nbsp;
											
									<button id='<?php echo $i;?>' class='continue btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>
								</div>
								
								</div>
								<?php
							}
							else
							{
								?>
								
								<div id="vote_div<?php echo $i;?>" class="all_votes_div">
								
								<div class="vote_head" align='center'>PROOST OF THE <?php echo strtoupper($post_name);?></div>
								
								<input type="hidden" name="post_id<?php echo $i;?>" value="<?php echo $post_id;?>"/>
									
								<?php

								for($k=1;$k<=$count;$k++)
								{
									$fetch = $query->fetch();
									$aspirant_id = $fetch['aspirant_id'];
									$unique_id = $fetch['unique_id'];
									$aspirant_student_id = "";
									$dept_id = "";
									$dept_name = "";
									$level = "";
									$course = "";
									$aspirant_fullname = ucwords($fetch['fullname']);
									$aspirant_nickname = ucfirst($fetch['nickname']);
									$path = $fetch['path'];
									
									if($path == "")
									{
										$folder = "../images/";
										$full_path = $folder."default.png"; 
									}
									else
									{
										$full_path = "../aspirants/".$path;
									}
								
									?>         
										
									<div class="col-md-4 col-sm-4">
												
										<div align="center">
											<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" width="200px"/> 
										</div>
										
										<div style="min-height:150px">
											<h3 align="center"> <b><span class='text-info'><?php echo $aspirant_fullname;?></b> <br/> <i>(<?php echo $aspirant_nickname;?>)</i></span> </b> </h3><br/>
										</div>

										<div align="center">
											<input type="radio" id="post<?php echo $aspirant_id;?>" name="aspirant<?php echo $i;?>" value="yes-<?php echo $aspirant_id;?>"/>
										
										<b><span style='cursor:pointer;font-size:30px;color:#39CCCC' onclick="document.getElementById('post<?php echo $aspirant_id;?>').checked = true"> YES </span></b> &nbsp; &nbsp; &nbsp; 
											</div>
										
									</div>
									
								<?php
								
								}
								?>
								<div style="clear:both"></div>
								<div align="center">
									<input type="radio" value="none" name="aspirant<?php echo $i;?>" style="display:none" checked="checked"/> 
									<hr/><input type="radio" value="none" name="aspirant<?php echo $i;?>" id="none<?php echo $aspirant_id;?>"/> 
									<b> <span style='cursor:pointer;font-size:25px;color:#00A4CC' onclick="document.getElementById('none<?php echo $aspirant_id;?>').checked = true">Vote for none.</span></b>
								</div> <br/>
											
													
								<div align="center">
									<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'>&laquo; Previous</button> &nbsp; &nbsp;
											
									<button id='<?php echo $i;?>' class='continue btn btn-lg btn-info' type='button'> Continue <i class="icon-chevron-right"></i></button>
								</div>
								
								</div>
								<?php
							}
							
						}
					$i++;
					}
				}
				
				echo "</div>";
			}
	}
	
		?>
		
</div>		
		</form>

		
		<div id="preview_the_votes"></div>
			
			
			</div>
				
		</div> 
		
			
			<script type='text/javascript'>
			
				$('.all_votes_div').addClass('hide');
				$('#vote_div'+1).removeClass('hide');
			 
				$('.continue_aspirants').click(function()
				{
					$('#all_floor_reps_div').hide('fast');
					$('#all_aspirants_div').show('fast');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				});

				$('.continue_to_aspirants').click(function()
				{
					$('#all_floor_reps_div').hide('fast');
					$('#all_aspirants_div').show('fast');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				});

				$('.back_reps').click(function()
				{
					$('#all_floor_reps_div').show('fast');
					$('#all_aspirants_div').hide('fast');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				});

				$('.next').click(function()
				{
					var current_num = parseInt($(this).attr('id'));     
					var next_num = current_num+1;
					$('#vote_div'+current_num).addClass('hide');
					$('#vote_div'+next_num).removeClass('hide');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				});
			 
				$('.previous').click(function()
				{
					var current_num = parseInt($(this).attr('id'));     
					var prev_num = current_num-1;
					$('#vote_div'+current_num).addClass('hide');
					$('#vote_div'+prev_num).removeClass('hide');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				});
				
				//$("form#vote_form").submit(function()
				
				$(".continue").click(function()
				{
					$('#all_floor_reps_div').hide('fast');
					$('#all_aspirants_div').show('fast');
					$("html, body").animate({ scrollTop: 0 }, "slow");
					
					var data = $("form#vote_form").serialize();
					var support_ajax_status = $("#support_ajax_status");
					var ajax_status = $("#ajax_status");
					support_ajax_status.show();

					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").hide("fast");
						}
					});
						
					$.ajax(
					{
						type: "POST",
						url: "../confirm?PreviewVote",
						data: data,
						cache: false,
						
						success:function(msg)
						{
							$("#vote_area").hide("fast");
							$("#preview_the_votes").show("fast");
							$("#preview_the_votes").html(msg);
						}
					});
				});

			</script>

			