<?php 

require_once("../idibo.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?php echo $admin_title;?> | Dashboard </title>
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
	
	if(!isset($_SESSION['tesojue_admin']))
	{
		echo error_admin_msg("You are not allowed to view this page because you're not logged in. <br/> Click <a href='index'><b>HERE</b></a> to login now.");
	}
	else if(isset($_SESSION['tesojue_admin']))
	{
		$baba = $_SESSION['tesojue_admin'];
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
				<li class="panel active">
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
                    <div class="col-lg-12">
                        <h1 align="center"> Welcome to <?php echo $admin_title;?> Dashboard Overview</h1>
                    </div>
                </div>
                <hr/>
                
                <?php
                
                $count_voted = count_voted();
                $count_voters = count_voters();
                
                if($count_voted > 0)
                {
                	$percent = ceil(($count_voted*100)/$count_voters);
                
	                ?>
		               <div align="center">
			                <h2 align="center"> ELECTION STATUS </h2> 
							<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $percent;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent;?>%">
								<b><span style="font-size:17px"><?php echo $percent;?>%</span></b></span>
								</div>
							</div>
						</div>
						<h4> <i class="icon-thumbs-up"></i> Only <b><?php echo $count_voted;?> (<?php echo $percent;?>%)</b> out of <b><?php echo $count_voters;?></b> voters voted.  &nbsp; <a href='voters' class='btn btn-sm btn-success'>Click to view all that have voted </a> </h4><br/><br/>
				
					<?php
				}
			
				?>

				
				      
				<div class="row">
					
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-aqua">
							<a href="voters" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_voters();?>
									</h3>
									<p>
	                                    Voters
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-group"></i>
							</div>
							<a href="voters" class="small-box-footer">
								View all voters <i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-yellow">
							<a href="accreditation" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_accredited();?>
									</h3>
									<p>
										Accredited Voters
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-user"></i>
							</div>
							<a href="accreditation" class="small-box-footer">
								View all accredited voters <i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-green">
							<a href="voters" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_voted();?>
									</h3>
									<p>
	                                    Voted
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-thumbs-up"></i>
							</div>
							<a href="voters" class="small-box-footer">
								View all voteds <i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-yellow">
							<a href="aspirants" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_aspirants();?>
									</h3>
									<p>
										Executives
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-user"></i>
							</div>
							<a href="aspirants" class="small-box-footer">
								View all executives <i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-red">
							<a href="keys" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_keys();?>
									</h3>
									<p>
										Voting PINs
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-key"></i>
							</div>
							<a href="keys" class="small-box-footer">
								View all voting keys <i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-teal">
							<a href="posts" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_posts();?>
									</h3>
									<p>
										Executive Posts
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-location-arrow"></i>
							</div>
							<a href="posts" class="small-box-footer">
								View all posts <i class="icon-arrow-right"></i>
							</a>
						</div>
					</div><!-- ./col -->
					
					<div class="col-lg-3 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-maroon">
							<a href="constituencies" style="color:#fff;text-decoration: none">
								<div class="inn">
									<h3>
										<?php echo count_constituencies();?>
									</h3>
									<p>
										Constituencies
									</p>
								</div>
							</a>
							<div class="icon">
								<i class="icon-star"></i>
							</div>
							<a href="constituencies" class="small-box-footer">
								View all constituencies <i class="icon-arrow-right"></i>
							</a>
						</div><br/><br/>
		
				</div><!-- ./col -->
					
				                
			<div style="clear:both"></div>

			<div class="col-md-12 col-sm-12">

			<?php
				
			/*
			$post_query = $db_handle->prepare("SELECT DISTINCT `post_id` FROM `aspirants` ORDER BY `post_id`");
            $post_query->execute();
            $rows = $post_query->rowCount();
			$i=1;
			
			if($rows == 0)
			{
				echo error_admin_msg("No aspirant yet.");
			}
			else
			{
				echo "<hr/><br/>";

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
					
					if( ($i==1) && ($i !== $rows) ) 
					{
						?>
						
						<div id="vote_div<?php echo $i;?>" class="all_votes_div">
						
						<div align="center">
							<button onClick="Print('print_result_div<?php echo $i;?>');"class="btn btn-success"><i class="icon-print"></i> Print result for the post of <?php echo ucfirst($post_name);?></b> </button> 
						</div><br/><br/>
						
						
						<div id="print_result_div<?php echo $i;?>">
						
						<div class="vote_head" align='center'>ELECTION RESULT FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						

						<?php

						$votes_array = array();
						$aspirant_array = array();
						$max = 0;

						for($k=1;$k<=$count;$k++)
						{
							$fetch = $query->fetch();
							$aspirant_id = $fetch['aspirant_id'];
							$unique_id = $fetch['unique_id'];
							$aspirant_fullname = ucwords($fetch['fullname']);
							$aspirant_nickname = $fetch['nickname'];
							$path = $fetch['path'];
							$count_votes = count_aspirant_votes($aspirant_id);	
							$votes_array[] = $count_votes;
							$aspirant_array[] = $aspirant_id;

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
									<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" style="max-width:200px;max-height:200px"/> <br/><br/><br/>
								</div>
										
								<div class="col-md-8 col-sm-8">
									<h3> Fullname &raquo; <b><span class='text-info'><?php echo $aspirant_fullname;?></span> <?php if($aspirant_nickname !== "") { echo "(<i>$aspirant_nickname</i>)"; } ?> </b> </h3><br/>

									<h3> Total votes : <span class="vote_count"> <?php echo $count_votes;?> </span> </h3> 
									
								</div>
								<div style="clear:both"></div> <hr/>
						<?php
						}

						?>
						<div class="vote_head" align='center'>WINNER FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						
						<?php

						$combine_array = combine_array($aspirant_array,$votes_array);
						$max_vote = max($combine_array);
						
						foreach($combine_array as $each_aspirant=>$each_vote)
						{
							if($max_vote == $each_vote) 
							{
								list($winner_fullname,$winner_path,$winner_nickname,$winner_course) = get_aspirant_preview_details($each_aspirant);
								?>
								<h3 align="center"> Winner - <b><span class='text-info'><?php echo $winner_fullname;?></span> <?php if($winner_nickname !== "") { echo "(<i>$winner_nickname</i>)"; } ?> </b> <img src="../images/winner.png" width="70px"/></h3><br/>
								<?php
							}
						}

						?>
						</div>

						<div align="center">
								<button id='<?php echo $i;?>' class='next btn btn-lg btn-success' type='button' >Next &raquo;</button>
							</div> 
						</div>
						<?php
					}
					else if( ($i==1) && ($i == $rows) ) 
					{
						?>
						
						<div id="vote_div<?php echo $i;?>" class="all_votes_div">
						
						<div align="center">
							<button onClick="Print('print_result_div<?php echo $i;?>');"class="btn btn-success"><i class="icon-print"></i> Print result for the post of <?php echo ucfirst($post_name);?></b> </button> 
						</div><br/><br/>
						
						
						<div id="print_result_div<?php echo $i;?>">
						
						<div class="vote_head" align='center'>ELECTION RESULT FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						

						<?php

						$votes_array = array();
						$aspirant_array = array();
						$max = 0;

						for($k=1;$k<=$count;$k++)
						{
							$fetch = $query->fetch();
							$aspirant_id = $fetch['aspirant_id'];
							$unique_id = $fetch['unique_id'];
							$aspirant_student_id = $fetch['aspirant_student_id'];
							$aspirant_fullname = ucwords($fetch['fullname']);
							$aspirant_nickname = $fetch['nickname'];
							$path = $fetch['path'];
							$count_votes = count_aspirant_votes($aspirant_id);	
							$votes_array[] = $count_votes;
							$aspirant_array[] = $aspirant_id;

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
									<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" style="max-width:200px;max-height:200px"/> <br/><br/><br/>
								</div>
										
								<div class="col-md-8 col-sm-8">
									<h3> Fullname &raquo; <b><span class='text-info'><?php echo $aspirant_fullname;?></span> <?php if($aspirant_nickname !== "") { echo "(<i>$aspirant_nickname</i>)"; } ?> </b> </h3><br/>

									<h3> Total votes : <span class="vote_count"> <?php echo $count_votes;?> </span> </h3> 
									
								</div>
								<div style="clear:both"></div> <hr/>
						<?php
						}

						?>
						<div class="vote_head" align='center'>WINNER FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						
						<?php

						$combine_array = combine_array($aspirant_array,$votes_array);
						$max_vote = max($combine_array);
						
						foreach($combine_array as $each_aspirant=>$each_vote)
						{
							if($max_vote == $each_vote) 
							{
								list($winner_fullname,$winner_path,$winner_nickname,$winner_course) = get_aspirant_preview_details($each_aspirant);
								?>
								<h3 align="center"> Winner - <b><span class='text-info'><?php echo $winner_fullname;?></span> <?php if($winner_nickname !== "") { echo "(<i>$winner_nickname</i>)"; } ?> </b> <img src="../images/winner.png" width="70px"/></h3><br/>
								<?php
							}
						}

						?>
						</div>

						<?php
					}
					
					else if($i<$rows)
					{
						?>
						<div id="vote_div<?php echo $i;?>" class="all_votes_div">
						
						<div align="center">
							<button onClick="Print('print_result_div<?php echo $i;?>');"class="btn btn-success"><i class="icon-print"></i> Print result for the post of <?php echo ucfirst($post_name);?></b> </button> 
						</div><br/><br/>
						
						
						<div id="print_result_div<?php echo $i;?>">
						
						<div class="vote_head" align='center'>ELECTION RESULT FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						
						<?php

						$votes_array = array();
						$aspirant_array = array();
						$max = 0;

						for($k=1;$k<=$count;$k++)
						{
							$fetch = $query->fetch();
							$aspirant_id = $fetch['aspirant_id'];
							$unique_id = $fetch['unique_id'];
							$aspirant_student_id = $fetch['aspirant_student_id'];
							$aspirant_fullname = ucwords($fetch['fullname']);
							$aspirant_nickname = $fetch['nickname'];
							$path = $fetch['path'];
							$count_votes = count_aspirant_votes($aspirant_id);	
							$votes_array[] = $count_votes;
							$aspirant_array[] = $aspirant_id;

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
									<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" style="max-width:200px;max-height:200px"/> <br/><br/><br/>
								</div>
										
								<div class="col-md-8 col-sm-8">
									<h3> Fullname &raquo; <b><span class='text-info'><?php echo $aspirant_fullname;?></span> <?php if($aspirant_nickname !== "") { echo "(<i>$aspirant_nickname</i>)"; } ?> </b> </h3><br/>

									<h3> Total votes : <span class="vote_count"> <?php echo $count_votes;?> </span> </h3> 
									
								</div>
								<div style="clear:both"></div> <hr/>
						<?php
						}

						?>
						<div class="vote_head" align='center'>WINNER FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						
						<?php

						$combine_array = combine_array($aspirant_array,$votes_array);
						$max_vote = max($combine_array);
						
						foreach($combine_array as $each_aspirant=>$each_vote)
						{
							if($max_vote == $each_vote) 
							{
								list($winner_fullname,$winner_path,$winner_nickname,$winner_course) = get_aspirant_preview_details($each_aspirant);
								?>
								<h3 align="center"> Winner - <b><span class='text-info'><?php echo $winner_fullname;?></span> <?php if($winner_nickname !== "") { echo "(<i>$winner_nickname</i>)"; } ?> </b> <img src="../images/winner.png" width="70px"/></h3><br/>
								<?php
							}
						}

						?>
						</div>

						<div align="center">
								<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button' >&laquo; Previous </button> &nbsp; &nbsp;
								
								<button id='<?php echo $i;?>' class='next btn btn-lg btn-success' type='button' >Next &raquo;</button>
							</div> 
						</div>
						<?php
					}
					
					else if($i == $rows)
					{
						?>
						<div id="vote_div<?php echo $i;?>" class="all_votes_div">
						
						<div align="center">
							<button onClick="Print('print_result_div<?php echo $i;?>');"class="btn btn-success"><i class="icon-print"></i> Print result for the post of <?php echo ucfirst($post_name);?></b> </button> 
						</div><br/><br/>
						
						<div id="print_result_div<?php echo $i;?>">
						
						<div class="vote_head" align='center'>ELECTION RESULT FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						
							
						<?php

						$votes_array = array();
						$aspirant_array = array();
						$max = 0;

						for($k=1;$k<=$count;$k++)
						{
							$fetch = $query->fetch();
							$aspirant_id = $fetch['aspirant_id'];
							$unique_id = $fetch['unique_id'];
							$aspirant_student_id = $fetch['aspirant_student_id'];
							$aspirant_fullname = ucwords($fetch['fullname']);
							$aspirant_nickname = $fetch['nickname'];
							$path = $fetch['path'];
							$count_votes = count_aspirant_votes($aspirant_id);	
							$votes_array[] = $count_votes;
							$aspirant_array[] = $aspirant_id;

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
									<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" style="max-width:200px;max-height:200px"/> <br/><br/><br/>
								</div>
										
								<div class="col-md-8 col-sm-8">
									<h3> Fullname &raquo; <b><span class='text-info'><?php echo $aspirant_fullname;?></span> <?php if($aspirant_nickname !== "") { echo "(<i>$aspirant_nickname</i>)"; } ?> </b> </h3><br/>

									<h3> Total votes : <span class="vote_count"> <?php echo $count_votes;?> </span> </h3> 
									
								</div>
								<div style="clear:both"></div> <hr/>
						<?php
						}

						?>
						<div class="vote_head" align='center'>WINNER FOR THE POST OF THE <?php echo strtoupper($post_name);?></div>
						
						<?php

						$combine_array = combine_array($aspirant_array,$votes_array);
						$max_vote = max($combine_array);
						
						foreach($combine_array as $each_aspirant=>$each_vote)
						{
							if($max_vote == $each_vote) 
							{
								list($winner_fullname,$winner_path,$winner_nickname,$winner_course) = get_aspirant_preview_details($each_aspirant);
								?>
								<h3 align="center"> Winner - <b><span class='text-info'><?php echo $winner_fullname;?></span> <?php if($winner_nickname !== "") { echo "(<i>$winner_nickname</i>)"; } ?> </b> <img src="../images/winner.png" width="70px"/></h3><br/>
								<?php
							}
						}

						?>
						</div>

						<div align="center">
								<button id='<?php echo $i;?>' class='previous btn btn-lg btn-success' type='button'>&laquo; Previous</button> &nbsp; &nbsp;
										
							</div> 
						</div>
						<?php
					}
				$i++;
				}
			} */
		}

	?>
		</div>
	</div> 
        <br/><br/><br/><br/>  
	
		<script>
		
			$('.all_votes_div').addClass('hide');
			$('#vote_div'+1).removeClass('hide');
		 
			$('.next').click(function()
			{
				var current_num = parseInt($(this).attr('id'));     
				var next_num = current_num+1;
				$('#vote_div'+current_num).addClass('hide');
				$('#vote_div'+next_num).removeClass('hide');
				$("html, body").animate({ scrollTop: 700}, "slow");
			});
		 
			$('.previous').click(function()
			{
				var current_num = parseInt($(this).attr('id'));     
				var prev_num = current_num-1;
				$('#vote_div'+current_num).addClass('hide');
				$('#vote_div'+prev_num).removeClass('hide');
				$("html, body").animate({ scrollTop: 700}, "slow");
			});
			
		</script>

                
        </div>
         <!-- END RIGHT STRIP  SECTION -->
    </div>

	
	<!--END MAIN WRAPPER -->

    <!-- FOOTER -->
    <?php //include("footer.php");?>
	<!--END FOOTER -->
	
	

    <!-- GLOBAL SCRIPTS -->
    <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
     <script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!-- END GLOBAL SCRIPTS -->

        <script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
     <script>
         $(document).ready(function () {
             $('#dataTables-example').dataTable();
         });
    </script>

    <!-- END PAGE LEVEL SCRIPTS -->


</body>

    <!-- END BODY -->
</html>
