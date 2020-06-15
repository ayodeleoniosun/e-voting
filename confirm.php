<?php

require_once("idibo.php");
require_once("image.php");

if(isset($_GET['AdminLogin'])) {
	
	$username =  $_POST['username'];
	$password = md5(trim($_POST['password']));
	$check_admin = check_admin_log_in($username,$password);

	if(!$check_admin) 
	{
		echo errors("Incorrect login details");
	}
	else 
	{
		echo successes("Login successful. Please wait <img src='../assets/images/loading_bar.gif'/>");
		$_SESSION['tesojue_admin'] = $username;
		redirect_to("dashboard");
	}
}

else if(isset($_GET['StudentLogin'])){
	
	$matric =  trim($_POST['matric']);
	$key = trim($_POST['key']);
	$voter_exists = is_voter_exist($matric);
	$key_exists = is_key_exists($key);
	$key_used = is_key_used($key);
	$voter_voted = is_voter_voted($matric);
	$voter_qualified = is_voter_matric_qualified($matric);
	$voter_accredited = is_voter_accredited($matric);
	$is_voter_pin_attached = is_voter_pin_attached($matric,$key);
	$constituency = get_the_voter_constituency($matric);

	if(!$voter_exists)  {
		echo errors("Invalid voter.");
	}
	else if(!$key_exists) {
		echo errors("Invalid voting PIN.");
	}
	else if($voter_voted) 
	{
		echo errors("Sorry, you have voted before. Good day!");
	}
	else if(!$voter_qualified) 
	{
		echo errors("Sorry, you are not eligible to vote. Good day!");
	} 
	else if(!$voter_accredited) 
	{
		echo errors("Sorry, you have not been accredited!");
	}
	else if(!$is_voter_pin_attached) 
	{
		echo errors("Incorrect login details. Ensure that you use the pin attached with your matric number at the accreditation centre");
	}
	else if($key_used) 
	{
		echo errors("Voting PIN has been used by another user. Good day!");
	}
	else 
	{
		echo successes("Login successful. Please wait <img src='../images/loading_bar.gif'/>");
		$_SESSION['tesojue_student'] = $matric;
		$_SESSION['tesojue_key'] = $key;
		$_SESSION['tesojue_constituency'] = $constituency;
		redirect_to("vote");
	}
}

else if(isset($_GET['StudentxLogin'])){
	
	$matric =  trim($_POST['matric']);
	$key = trim($_POST['key']);
	$voter_exists = is_voter_exist($matric);
	$key_exists = is_key_exists($key);
	$key_used = is_key_used($key);
	$voter_voted = is_voter_voted($matric);
	$voter_qualified = is_voter_matric_qualified($matric);
	$constituency = get_the_voter_constituency($matric);

	if(!$voter_exists)  {
		echo errors("Invalid voter.");
	}else if(!$key_exists) {
		echo errors("Invalid voting PIN.");
	}
	else if($voter_voted) 
	{
		echo errors("Sorry, you have voted before. Good day!");
	}
	else if(!$voter_qualified) 
	{
		echo errors("Sorry, you are not eligible to vote. Good day!");
	}
	else if($key_used) 
	{
		echo errors("Voting PIN has been used by another user. Good day!");
	}
	else 
	{
		echo successes("Login successful. Please wait <img src='../images/loading_bar.gif'/>");
		$_SESSION['tesojue_student'] = $matric;
		$_SESSION['tesojue_key'] = $key;
		$_SESSION['tesojue_constituency'] = $constituency;
		redirect_to("vote");
	}
}

else if(isset($_GET['ChangePassword']))
{
	$current_password = md5($_POST['current_password']);
	$new_password = md5($_POST['new_password']);
	$confirm_new_password = md5($_POST['confirm_new_password']);
	$admin_id = $_POST['gotcha'];
	$get_admin_password = get_admin_password($admin_id);
	

	if(empty($new_password) || empty($confirm_new_password) )
	{
		echo errors("Please enter the new and the confirm new password.");
	}
	else if(strcmp($new_password,$confirm_new_password) !== 0)
	{
		echo errors("Password does not match.");
	}
	else if($current_password !== $get_admin_password)
	{
		echo errors("Incorrect current password.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `alagbara` SET `kokoro` = ? WHERE `agbara_id` = ?");
			$query->bindparam(1,$new_password);
			$query->bindparam(2,$admin_id);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Your password was successfully changed.");
				?>
				<script>
					$("#current_password").val("");
					$("#new_password").val("");
					$("#confirm_new_password").val("");
				</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to change password. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to change password. Please try again.");
		}
	}
}

else if(isset($_GET['SubmitVote']))
{
	$total = $_POST['total'];
	$student = $_POST['student'];
	$student_id = get_student_id($student);
    $key = $_POST['key'];
	$done =  false;
	$voted_on = date("Y-m-d H:i:s");
	$constituency = $_POST['constituency'];
	$rep = $_POST['rep'];
	$total_rep = $_POST['total_rep'];
	$done =  false;
	
	$voter_exists = is_voter_exist($student);
	$key_exists = is_key_exists($key);
	$key_used = is_key_used($key);
	$voter_voted = is_voter_voted($student);
	$voter_qualified = is_voter_matric_qualified($student);
	$voter_accredited = is_voter_accredited($student);
	$is_voter_pin_attached = is_voter_pin_attached($student,$key);
	
	if(!$voter_exists)  {
		echo errors("Invalid voter.");
	}
	else if(!$key_exists) {
		echo errors("Invalid voting PIN.");
	}
	else if($voter_voted) 
	{
		echo errors("Sorry, you have voted before. Good day!");
	}
	else if(!$voter_qualified) 
	{
		echo errors("Sorry, you are not eligible to vote. Good day!");
	} 
	else if(!$voter_accredited) 
	{
		echo errors("Sorry, you have not been accredited!");
	}
	else if(!$is_voter_pin_attached) 
	{
		echo errors("Incorrect details. Ensure that you use the pin attached with your matric number at the accreditation centre");
	}
	else if($key_used) 
	{
		echo errors("Voting PIN has been used by another user. Good day!");
	} 
	else {

		if($constituency !== "none") {
			
			if($rep !== "none")
			{
				$split_rep = explode("-",$rep);
				$rep_option = $split_rep[0];
				$rep_id = $split_rep[1];
				
				try{
					$count_rep_votes = count_floor_rep_votes($rep_id);	
					$new_rep_vote = $count_rep_votes+=1;
					
					$count_rep_against_votes = count_floor_rep_against_votes($rep_id);	
					$new_rep_against_vote = $count_rep_against_votes+=1;
					
					if($rep_option == "yes") {
						$query = $db_handle->prepare("UPDATE `floor_reps` SET `votes`= ? WHERE `rep_id` = ?");
						$query->bindparam(1,$new_rep_vote);
						$query->bindparam(2,$rep_id);
						$query->execute();
					} else if($rep_option == "no") {
						$query = $db_handle->prepare("UPDATE `floor_reps` SET `against`= ? WHERE `rep_id` = ?");
						$query->bindparam(1,$new_rep_against_vote);
						$query->bindparam(2,$rep_id);
						$query->execute();
					}

					if($query->execute())
					{
						$done =  true;
					}
					else
					{
						$done =  false;
					}
				}
				catch(PDOException $error){
					$done =  false;
				}
			} else {
				
				try{
					$count_rep_void_votes = count_floor_rep_void_votes($constituency);	
					$new_rep_void_vote = $count_rep_void_votes+=1;
			
					$query = $db_handle->prepare("UPDATE `void_rep_votes` SET `voids`= ? WHERE `constituency` = ?");
					$query->bindparam(1,$new_rep_void_vote);
					$query->bindparam(2,$constituency);
					$query->execute();
					
					if($query->execute())
					{
						$done =  true;
					}
					else
					{
						$done =  false;
					}
				}
				catch(PDOException $error){
					$done =  false;
				}
			}
		}

		for($i=1;$i<=$total;$i++) 
		{
			$post = "post_id$i";
			$aspirant = "aspirant$i";
			$post_id = $_POST[$post];
			$the_aspirant_id = $_POST[$aspirant];

			if($the_aspirant_id !== "none")
			{
				$split_aspirant = explode("-",$the_aspirant_id);
				$aspirant_option = $split_aspirant[0];
				$aspirant_id = $split_aspirant[1];

				$count_aspirant_votes = count_aspirant_votes($aspirant_id);	
				$new_aspirant_vote = $count_aspirant_votes+=1;
				
				$count_aspirant_against_votes = count_aspirant_against_votes($aspirant_id);	
				$new_aspirant_against_vote = $count_aspirant_against_votes+=1;
				
				try{
					
					if($aspirant_option == "yes") {
						$query = $db_handle->prepare("UPDATE `aspirants` SET `votes`= ? WHERE `aspirant_id` = ?");
						$query->bindparam(1,$new_aspirant_vote);
						$query->bindparam(2,$aspirant_id);
						$query->execute();
					} else if($aspirant_option == "no") {
						$query = $db_handle->prepare("UPDATE `aspirants` SET `against`= ? WHERE `aspirant_id` = ?");
						$query->bindparam(1,$new_aspirant_against_vote);
						$query->bindparam(2,$aspirant_id);
						$query->execute();
					}
					
					if($query->execute())
					{
						$done =  true;
					}
					else
					{
						$done =  false;
					}
				}
				catch(PDOException $error){
					$done =  false;
				}
			}

			else {
				
				try{
					$count_executive_void_votes = count_aspirant_void_votes($post_id);	
					$new_executive_void_vote = $count_executive_void_votes+=1;
			
					$query = $db_handle->prepare("UPDATE `void_executives_votes` SET `voids`= ? WHERE `post_id` = ?");
					$query->bindparam(1,$new_executive_void_vote);
					$query->bindparam(2,$post_id);
					$query->execute();
					
					if($query->execute())
					{
						$done =  true;
					}
					else
					{
						$done =  false;
					}
				}
				catch(PDOException $error){
					$done =  false;
				}
			}
		}

		if($done ==  true)
		{
			$update_student_query = $db_handle->prepare("UPDATE `voters` SET `voted`= '1', `voted_on` = ?, `key_used` = ? WHERE `matric` = ?");
			$update_student_query->bindparam(1,$voted_on);
			$update_student_query->bindparam(2,$key);
			$update_student_query->bindparam(3,$student);
			$update_student_query->execute();
			
			$update_key_query = $db_handle->prepare("UPDATE `voting_keys` SET `voted`= '1', `used_by` = ? WHERE `keys` = ?");
			$update_key_query->bindparam(1,$student_id);
			$update_key_query->bindparam(2,$key);
			$update_key_query->execute();
				
			echo successes("Your vote was successfully submitted.");
			unset($_SESSION["tesojue_student"]);
			unset($_SESSION["tesojue_key"]);
			unset($_SESSION["tesojue_constituency"]);
			$_SESSION['voted_out'] = "true";
			?>
				<script>
					//alert("Thanks for voting. Bye!");
					window.location = "index";
				</script>
			<?php
		}
		else
		{
			echo errors("An error occured. Unable to submit your vote. Please try again.");
		}
	}
}

else if(isset($_GET['PreviewVote']))
{
	$total = $_POST['total'];
	$student = $_POST['student'];
	$student_id = get_student_id($student);
    $key = $_POST['key'];
	$constituency = $_POST['constituency'];
	$rep = $_POST['rep'];
	$total_rep = $_POST['total_rep'];
	$done =  false;
	
	//selected floor rep details

	if($rep !== "none") {
		$split_rep = explode("-",$rep);
		$rep_option = $split_rep[0];
		$rep_id = $split_rep[1];
		
		if($total_rep == 1) {
			if($rep_option == "no") {
				$the_rep_option = "<span class='text-danger'> Voted against </span>";
			} else {
				$the_rep_option = "<span class='text-success'> Voted for </span>";
			}
		}

		list($rep_fullname,$rep_nickname,$rep_path) = get_floor_rep_preview_details($rep_id);

		if($rep_path == "")
		{
			$folder = "../images/";
			$rep_full_path = $folder."default.png"; 
		}
		else
		{
			$rep_full_path = "../floor-reps/".$rep_path;
		}
	}

	?>

	<hr/><h4 align='center'>DEAR <b><?php echo $student;?></b>, THE PREVIEW OF THE ASPIRANTS YOU VOTED FOR ARE AS FOLLOW</h4>
	<p align='center'><i> Should you make any mistake, you can click on the <b>adjust button</b> below, else, click on the <b>submit button</b> to finalise your vote.</i></p>
	

	<script type='text/javascript'>

		$('#back').click(function()
		{
			$("#vote_area").show("fast");
			$("#preview_the_votes").hide("fast");
			$('#all_floor_reps_div').hide('fast');
			$('#all_aspirants_div').show('fast');
		});
		
		$('#back_to_vote').click(function()
		{
			$("#vote_area").show("fast");
			$("#preview_the_votes").hide("fast");
			$('#all_floor_reps_div').hide('fast');
			$('#all_aspirants_div').show('fast');
		});
		
		$("#submit_vote").click(function()
		{
			var confirm = window.confirm("Are you sure you want to submit your vote? ");

			if(confirm ==  false)
			{
				return false;
			}
			else
			{
				var data = $("form#vote_form").serialize();
				var support_ajax_status = $("#support_ajax_status");
				var ajax_status = $("#ajax_status");
				support_ajax_status.show();
				
				$.ajaxSetup(
				{
					beforeSend: function()
					{
						support_ajax_status.html("Please wait while your vote is submitted <img src='../images/loading_bar.gif'/>");
					},
					complete: function()
					{
						support_ajax_status.html("").delay(4000).fadeOut("slow");
					}
				});
					
				$.ajax(
				{
					type: "POST",
					url: "../confirm?SubmitVote",
					data: data,
					cache: false,
					
					success:function(msg)
					{
						ajax_status.show();
						ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
					}
				});
			}
		});

		$("#submit_my_vote").click(function()
		{
			var confirm = window.confirm("Are you sure you want to submit your vote? ");

			if(confirm ==  false)
			{
				return false;
			}
			else
			{
				var data = $("form#vote_form").serialize();
				var support_ajax_status = $("#support_ajax_status");
				var ajax_status = $("#ajax_status");
				support_ajax_status.show();
				
				$.ajaxSetup(
				{
					beforeSend: function()
					{
						support_ajax_status.html("Please wait while your vote is submitted <img src='../images/loading_bar.gif'/>");
					},
					complete: function()
					{
						support_ajax_status.html("").delay(4000).fadeOut("slow");
					}
				});
					
				$.ajax(
				{
					type: "POST",
					url: "../confirm?SubmitVote",
					data: data,
					cache: false,
					
					success:function(msg)
					{
						ajax_status.show();
						ajax_status.html("<div align='center'>"+msg+"</div>").delay(4000).fadeOut("slow");
					}
				});
			}
		});
	</script>

	<div align="center">
		
		<button id='back' class='btn btn-md btn-primary' type='button'><i class="icon-pencil"></i> Adjust </button> &nbsp; &nbsp; 
				
		<button id='submit_vote' class='btn btn-md btn-success' type='button'> <i class="icon-check"></i> Submit</button>
	</div>  

	<br/> <br/>

	<?php

	if($constituency !== "none") {
	?>

	<div class="vote_head" align='center'>POST OF THE FLOOR REP OF <?php echo $constituency;?> CONSTITUENCY</div>

		<?php

		if($rep !== "none") {
		?>
			<div class="col-md-4 col-sm-4">
										
				<img src="<?php echo $rep_full_path;?>" alt="<?php echo $rep_fullname;?>" class="img-responsive img-circle" style="max-width:200px;max-height:200px"/> <br/><br/><br/>
			</div>
					
			<div class="col-md-8 col-sm-8">
				<h3> Fullname &raquo; <b><span class='text-info'><?php echo $rep_fullname;?></span> </b> </h4><br/>

				<h4> Nickname &raquo; <?php echo $rep_nickname;?> </h4><br/>
				
				<?php

				if($total_rep == 1) {
				?>
					<h4> Selected option &raquo; <?php echo $the_rep_option;?> </h4><br/>
				<?php
				} 
				?>			
			</div>
		<?php
		} else {
			?>
				<div class='alert alert-danger' align='center'> <i class='icon-remove'></i> You voted for none! </div>
			<?php
		}
	}
	
	?>
	<div style="clear:both"></div>
	
	<br/> <br/>

	<?php

	for($i=1;$i<=$total;$i++) 
	{
		$post = "post_id$i";
		$aspirant = "aspirant$i";
		$post_id = $_POST[$post];
		
		// if(isset($_POST[$aspirant]))
		{
			$the_aspirant_id = $_POST[$aspirant];
			
			if($the_aspirant_id !== "none")
			{
				$split_aspirant = explode("-",$the_aspirant_id);
				$aspirant_option = $split_aspirant[0];
				$aspirant_id = $split_aspirant[1];

				if($aspirant_option == "no") {
					$the_aspirant_option = "<span class='text-danger'> Voted against </span>";
				} else {
					$the_aspirant_option = "<span class='text-success'> Voted for </span>";
				}
				
				list($fullname,$path,$nickname,$course) = get_aspirant_preview_details($aspirant_id);
			
				$post_name = get_post_name($post_id);
				
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
				
				<div class="vote_head" align='center'>POST OF THE <?php echo strtoupper($post_name);?></div>

					<div class="col-md-4 col-sm-4">
												
						<img src="<?php echo $full_path;?>" alt="<?php echo $aspirant_fullname;?>" class="img-responsive img-circle" style="max-width:200px;max-height:200px"/> <br/><br/><br/>
					</div>
							
					<div class="col-md-8 col-sm-8">
						<h3> Fullname &raquo; <b><span class='text-info'><?php echo $fullname;?></span> </b> </h4><br/>

						<h4> Nickname &raquo; <?php echo $nickname;?> </h4><br/>
						
						<h4> Selected option &raquo; <?php echo $the_aspirant_option;?> </h4><br/>
										
					</div>

				<div style="clear:both"></div>
				
				<?php
			}
			else
			{
				$post_name = get_post_name($post_id);
				
				?>
				
				<div class="vote_head" align='center'>POST OF THE <?php echo strtoupper($post_name);?></div>

				<div class='alert alert-danger ' align='center'> <i class='icon-remove'></i> You voted for none! </div>

				<br/>
				
				<?php
			}
			
		}

	}
	?>

	<hr/>
	<div align="center">
		
		<button id='back_to_vote' class='btn btn-md btn-primary' type='button'><i class="icon-pencil"></i> Adjust </button> &nbsp; &nbsp; 
				
		<button id='submit_my_vote' class='btn btn-md btn-success' type='button'> <i class="icon-check"></i> Submit</button>
	</div>  <br/> <br/>

	<?php
}

else if(isset($_GET['AddPost']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$post = $_POST['post'];
	$post_exist = post_exists($post);
	
	if(empty($post))
	{
		echo errors("Please enter the post name");
	}
	else if($post_exist)
	{
		echo errors("<b>$post</b> has been added before. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("INSERT INTO `posts` (post) VALUES(?)");
			$query->bindparam(1,$post);
			$query->execute();
			$count = $query->rowCount();
			
			if($count == 1){
				$count_posts = count_posts();
			
				echo successes("<b>$post</b> was successfully added.");
				?>
					<script>
						$("#post").val("");
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_posts").html("<?php echo $count_posts;?>");

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch_posts").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch_posts").html("");
							}
						});

						$.post('display?DisplayAllPosts', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_posts").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to add post. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to add post. Please try again.");
		}
	}
}

else if(isset($_GET['AddDepartment']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$dept = $_POST['dept'];
	$dept_exist = dept_exists($dept);
	$unique_id =  Generate_Pin(4);

	if(empty($dept))
	{
		echo errors("Please enter the department name");
	}
	else if($dept_exist)
	{
		echo errors("<b>$dept</b> has been added before. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("INSERT INTO `depts` (dept,unique_id) VALUES(?,?)");
			$query->bindparam(1,$dept);
			$query->bindparam(2,$unique_id);
			$query->execute();
			$count = $query->rowCount();
			
			if($count == 1)
			{
				$count_depts = count_depts();
			
				echo successes("<b>$dept</b> was successfully added.");
				?>
					<script>
						$("#dept").val("");
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_depts").html("<?php echo $count_depts;?>");

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch_depts").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch_depts").html("");
							}
						});

						$.post('display?DisplayAllDepartments', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_depts").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to add department. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to add department. Please try again.");
		}
	}
}

else if(isset($_GET['AddAspirant']))
{
	$fullname = $_POST['fullname'];
	$nickname = $_POST['nickname'];
	$post = $_POST['post'];
	$aspirant_tmp = $_FILES['aspirant_photo']['tmp_name'];
	$aspirant_name = $_FILES['aspirant_photo']['name'];
	$aspirant_size = $_FILES['aspirant_photo']['size'];
	$aspirant_type = $_FILES['aspirant_photo']['type'];
	
	if(empty($fullname) || empty($post))
	{
		echo errors("Please fill all details");
	}
	else
	{
		$timestamp = time();
		$path_file = $timestamp.".jpg";
		$folder = "aspirants/";
		
		if($aspirant_type == "image/png" || $aspirant_type == "image/PNG" || $aspirant_type == "image/jpg" || $aspirant_type == "image/JPG" || $aspirant_type == "image/jpeg" || $aspirant_type == "image/JPEG")
		{
			$full_path = $folder.$path_file;
			move_uploaded_file($aspirant_tmp,$full_path);
			$image = new SimpleImage();
			$image->load($full_path); 
			$image->resize(640,640); 
			$image->save($full_path); 

			try{
				$query = $db_handle->prepare("INSERT INTO `aspirants` (fullname,unique_id,post_id,nickname,path) VALUES(?,?,?,?,?)");
				$query->bindparam(1,$fullname);
				$query->bindparam(2,$timestamp);
				$query->bindparam(3,$post);
				$query->bindparam(4,$nickname);
				$query->bindparam(5,$path_file);
				$query->execute();
				$count = $query->rowCount();
				
				if($count == 1)
				{
					echo successes("Aspirant's details was successfully added.");
					$count_aspirants = count_aspirants();

					?>
						<script type="text/javascript">
							window.location="aspirants";
						</script>
					<?php
				}
				else{
					echo errors("An error occured. Unable to add aspirant. Please try again.");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to add aspirant. Please try again.");
			}
		}
		else
		{
			echo errors("Please select an image.");
		}
	}
}

else if(isset($_GET['UpdateAspirant']))
{
	$aspirant_id = $_POST['aspirant_id'];
	$unique_id = get_aspirant_unique_id($aspirant_id);
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$fullname = $_POST['fullname'];
	$nickname = $_POST['nickname'];
	$post = $_POST['post'];
	$aspirant_tmp = $_FILES['aspirant_photo']['tmp_name'];
	$aspirant_name = $_FILES['aspirant_photo']['name'];
	$aspirant_size = $_FILES['aspirant_photo']['size'];
	$aspirant_type = $_FILES['aspirant_photo']['type'];
	
	if(empty($aspirant_id) || empty($fullname) || empty($post))
	{
		echo errors("Please fill all details");
	}
	else
	{
		$path_file = $unique_id.".jpg";
		$folder = "aspirants/";
		
		if($aspirant_name !== "")
		{

			if($aspirant_type == "image/png" || $aspirant_type == "image/PNG" || $aspirant_type == "image/jpg" || $aspirant_type == "image/JPG" || $aspirant_type == "image/jpeg" || $aspirant_type == "image/JPEG")
			{
				$full_path = $folder.$path_file;
				move_uploaded_file($aspirant_tmp,$full_path);
				$image = new SimpleImage();
				$image->load($full_path); 
				$image->resize(640,640); 
				$image->save($full_path);

					try
					{
						$query = $db_handle->prepare("UPDATE `aspirants` SET `fullname` = ?, `post_id` = ?, `nickname` = ? WHERE `aspirant_id` = ?");
						$query->bindparam(1,$fullname);
						$query->bindparam(2,$post);
						$query->bindparam(3,$nickname);
						$query->bindparam(4,$aspirant_id);
						$query->execute();
						$count = $query->rowCount();
						
						if($query->execute())
						{
							echo successes("Aspirant's details was successfully updated.");
							?>
								<script>
									window.location="aspirants";
								</script>
							<?php
						}
						else{
							echo errors("An error occured. Unable to update aspirant. Please try again.");
						}
					}
					catch(PDOException $error){
						echo errors("An error occured. Unable to update aspirant. Please try again.");
					} 
			}
			else
			{
				echo errors("Please select an image.");
			}
		}
		else 
		{
			try
			{
				$query = $db_handle->prepare("UPDATE `aspirants` SET `fullname` = ?, `post_id` = ?, `nickname` = ? WHERE `aspirant_id` = ?");
				$query->bindparam(1,$fullname);
				$query->bindparam(2,$post);
				$query->bindparam(3,$nickname);
				$query->bindparam(4,$aspirant_id);
				$query->execute();
				$count = $query->rowCount();

				if($query->execute())
				{
					echo successes("Aspirant's details was successfully updated.");
					?>
						<script>
							var per_page = "<?php echo $per_page;?>";
							var current_page = "<?php echo $current_page;?>";
							var dataString = "current_page="+current_page+"&per_page="+per_page;
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#fetch").html("Please wait &nbsp; <img src='images/loading_bar.gif'/><br/>");
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
									$("#display_modify_aspirants").fadeOut();
									$("#display_aspirants").html(msg).fadeIn();
								}
							});
						</script>
					<?php
				}
				else{
					echo errors("An error occured. Unable to update aspirant. Please try again.");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to update aspirant. Please try again.");
			}
		}
	}
}

else if(isset($_GET['UpdateFloorRep']))
{
	$rep_id = $_POST['rep_id'];
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$unique_id = get_rep_unique_id($rep_id);
	$fullname = $_POST['fullname'];
	$nickname = $_POST['nickname'];
	$constituency = $_POST['constituency'];
	$rep_tmp = $_FILES['rep_photo']['tmp_name'];
	$rep_name = $_FILES['rep_photo']['name'];
	$rep_size = $_FILES['rep_photo']['size'];
	$rep_type = $_FILES['rep_photo']['type'];
	
	if(empty($fullname) || empty($constituency))
	{
		echo errors("Please fill all details");
	} 
	else
	{
		$path_file = $unique_id.".jpg";
		$folder = "floor-reps/";
		
		if($rep_name !== "")
		{

			if($rep_type == "image/png" || $rep_type == "image/PNG" || $rep_type == "image/jpg" || $rep_type == "image/JPG" || $rep_type == "image/jpeg" || $rep_type == "image/JPEG")
			{
				$full_path = $folder.$path_file;
				move_uploaded_file($rep_tmp,$full_path);
				$image = new SimpleImage();
				$image->load($full_path); 
				$image->resize(640,640); 
				$image->save($full_path); 

				try
				{
					$query = $db_handle->prepare("UPDATE `floor_reps` SET `fullname` = ?, `constituency` = ?, `nickname` = ? WHERE `rep_id` = ?");
					$query->bindparam(1,$fullname);
					$query->bindparam(2,$constituency);
					$query->bindparam(3,$nickname);
					$query->bindparam(4,$rep_id);
					$query->execute();
					$count = $query->rowCount();
					
					if($query->execute())
					{
						echo successes("Floor rep's details was successfully updated.");
						?>
							<script>
								window.location="floor-reps";
							</script>
						<?php
					}
					else{
						echo errors("An error occured. Unable to update floor rep details. Please try again.");
					}
				}
				catch(PDOException $error){
					echo errors("An error occured. Unable to update floor rep details. Please try again.");
				} 
			}
			else
			{
				echo errors("Please select an image.");
			}
		}
		else 
		{
			try
			{
				$query = $db_handle->prepare("UPDATE `floor_reps` SET `fullname` = ?, `constituency` = ?, `nickname` = ? WHERE `rep_id` = ?");
				$query->bindparam(1,$fullname);
				$query->bindparam(2,$constituency);
				$query->bindparam(3,$nickname);
				$query->bindparam(4,$rep_id);
				$query->execute();
				$count = $query->rowCount();

				if($query->execute())
				{
					echo successes("Floor rep's details was successfully updated.");
					?>
						<script>
							var per_page = "<?php echo $per_page;?>";
							var current_page = "<?php echo $current_page;?>";
							var dataString = "current_page="+current_page+"&per_page="+per_page;
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#fetch").html("Please wait &nbsp; <img src='images/loading_bar.gif'/><br/>");
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
								url:"display?DisplayAllFloorReps",
								
								success:function(msg)
								{
									$("#display_modify_reps").fadeOut();
									$("#display_reps").html(msg).fadeIn();
								}
							});
						</script>
					<?php
				}
				else{
					echo errors("An error occured. Unable to update floor rep details. Please try again.");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to update floor rep details. Please try again.");
			}
		}
	}
}


else if(isset($_GET['AddFloorRep']))
{
	$fullname = $_POST['fullname'];
	$nickname = $_POST['nickname'];
	$constituency = $_POST['constituency'];
	$rep_tmp = $_FILES['rep_photo']['tmp_name'];
	$rep_name = $_FILES['rep_photo']['name'];
	$rep_size = $_FILES['rep_photo']['size'];
	$rep_type = $_FILES['rep_photo']['type'];
	
	if(empty($fullname) || empty($constituency))
	{
		echo errors("Please fill all details");
	} 
	else
	{
		$timestamp = time();
		$path_file = $timestamp.".jpg";
		$folder = "floor-reps/";
		
		if($rep_type == "image/png" || $rep_type == "image/PNG" || $rep_type == "image/jpg" || $rep_type == "image/JPG" || $rep_type == "image/jpeg" || $rep_type == "image/JPEG")
		{
			$full_path = $folder.$path_file;
			move_uploaded_file($rep_tmp,$full_path);
			$image = new SimpleImage();
			$image->load($full_path); 
			$image->resize(640,640); 
			$image->save($full_path); 

			try{
				$query = $db_handle->prepare("INSERT INTO `floor_reps` (fullname,unique_id,constituency,nickname,path) VALUES(?,?,?,?,?)");
				$query->bindparam(1,$fullname);
				$query->bindparam(2,$timestamp);
				$query->bindparam(3,$constituency);
				$query->bindparam(4,$nickname);
				$query->bindparam(5,$path_file);
				$query->execute();
				$count = $query->rowCount();
				
				if($count == 1)
				{
					echo successes("Floor rep's details was successfully added.");
					$count_reps = count_floor_reps();

					?>
						<script type="text/javascript">
							window.location="floor-reps";
						</script>
					<?php
				}
				else{
					echo errors("An error occured. Unable to add floor rep. Please try again.");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to add floor rep. Please try again.");
			}
		}
		else
		{
			echo errors("Please select an image.");
		}
	}
}

else if(isset($_GET['UpdateElectionSettings']))
{
	$start_date = $_POST['start_date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$settings_exist = is_settings_exist();
	$converted_start_time = strtotime($start_time);
	$converted_end_time = strtotime($end_time);
	$start_time_greater =  ($converted_start_time > $converted_end_time) ? true: false;
	$the_same =  ($converted_start_time == $converted_end_time) ? true: false;
	
	if(empty($start_date) || empty($start_time) || empty($end_time) )
	{
		echo errors("Please fill all fields.");
	}
	else if($start_time_greater)
	{
		echo errors("Sorry, the election cannot start time cannot be greater than the end time. Try again.");
	}
	else if($the_same)
	{
		echo errors("Sorry, the election cannot start and end at the same time. Try again.");
	}
	else
	{
		if(!$settings_exist)
		{	
			try
			{
				
				$query = $db_handle->prepare("INSERT INTO `settings` (election_date,start_time,end_time) VALUES(?,?,?)");
				$query->bindparam(1,$start_date);
				$query->bindparam(2,$start_time);
				$query->bindparam(3,$end_time);
				$query->execute();
				$count = $query->rowCount();
							
				if($count == 1)
				{
					echo successes("Election settings was successfully updated.");
					?>
						<script>
							window.location = "settings";
						</script>
					<?php
				}
				else
				{
					echo errors("An error occured. Unable to update electiox settings. Try again");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to update electiox settings. Try again");
			}
		}
		else if($settings_exist)
		{	
			try
			{
				
				$query = $db_handle->prepare("UPDATE `settings` SET `election_date` = ?, `start_time` = ?, `end_time` = ?");
				$query->bindparam(1,$start_date);
				$query->bindparam(2,$start_time);
				$query->bindparam(3,$end_time);
				$query->execute();
				$count = $query->rowCount();
						
				if($query->execute())
				{
					echo successes("Election settings was successfully updated.");
					?>
						<script>
							window.location = "settings";
						</script>
					<?php
				}
				else
				{
					echo errors("An error occured. Unable to update election settings. Try again");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to update election settings. Try again");
			}
		}
	}
}
else if(isset($_GET['SearchUpdateAspirant']))
{
	$aspirant_id = $_POST['aspirant_id'];
	$search_aspirant = $_POST['search_aspirant'];
	$unique_id = get_aspirant_unique_id($aspirant_id);
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$fullname = $_POST['fullname'];
	$nickname = $_POST['nickname'];
	$post = $_POST['post'];
	$aspirant_tmp = $_FILES['aspirant_photo']['tmp_name'];
	$aspirant_name = $_FILES['aspirant_photo']['name'];
	$aspirant_size = $_FILES['aspirant_photo']['size'];
	$aspirant_type = $_FILES['aspirant_photo']['type'];
	
	if(empty($aspirant_id) || empty($fullname) || empty($post) || empty($nickname))
	{
		echo errors("Please fill all details");
	}
	else
	{
		$path_file = $unique_id.".jpg";
		$folder = "aspirants/";
		
		if($aspirant_name !== "")
		{

			if($aspirant_type == "image/png" || $aspirant_type == "image/PNG" || $aspirant_type == "image/jpg" || $aspirant_type == "image/JPG" || $aspirant_type == "image/jpeg" || $aspirant_type == "image/JPEG")
			{
				$full_path = $folder.$path_file;
				move_uploaded_file($aspirant_tmp,$full_path);
				$image = new SimpleImage();
				$image->load($full_path); 
				$image->resize(640,640); 
				$image->save($full_path);

					try
					{
						$query = $db_handle->prepare("UPDATE `aspirants` SET `fullname` = ?, `post_id` = ?, `nickname` = ? WHERE `aspirant_id` = ?");
						$query->bindparam(1,$fullname);
						$query->bindparam(2,$post);
						$query->bindparam(3,$nickname);
						$query->bindparam(4,$aspirant_id);
						$query->execute();
						$count = $query->rowCount();
						
						if($query->execute())
						{
							echo successes("Aspirant's details was successfully updated.");
							?>
								<script>
									window.location="aspirants";
								</script>
							<?php
						}
						else{
							echo errors("An error occured. Unable to update aspirant. Please try again.");
						}
					}
					catch(PDOException $error){
						echo errors("An error occured. Unable to update aspirant. Please try again.");
					} 
			}
			else
			{
				echo errors("Please select an image.");
			}
		}
		else 
		{
			try
			{
				$query = $db_handle->prepare("UPDATE `aspirants` SET `fullname` = ?, `post_id` = ?, `nickname` = ? WHERE `aspirant_id` = ?");
				$query->bindparam(1,$fullname);
				$query->bindparam(2,$post);
				$query->bindparam(3,$nickname);
				$query->bindparam(4,$aspirant_id);
				$query->execute();
				$count = $query->rowCount();
				
				if($query->execute())
				{
					echo successes("Aspirant's details was successfully updated.");
					?>
						<script>
							var per_page = "<?php echo $per_page;?>";
							var current_page = "<?php echo $current_page;?>";
							var search_aspirant = "<?php echo $search_aspirant;?>";
							var dataString = "current_page="+current_page+"&per_page="+per_page+"&aspirant="+search_aspirant;
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#fetch").html("Please wait &nbsp; <img src='images/loading_bar.gif'/><br/>");
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
								url:"display?DisplayAllSearchedAspirants",
								
								success:function(msg)
								{
									$("#display_search_modify_aspirants").hide("fast");
									$("#display_search_aspirants").show("fast").html(msg);
								}
							});
						</script>
					<?php
				}
				else{
					echo errors("An error occured. Unable to update aspirant. Please try again.");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to update aspirant. Please try again.");
			}
		}
	}
}

else if(isset($_GET['OldAddAspirant']))
{
	$aspirant = $_POST['aspirant'];
	$post = $_POST['post'];
	$nickname = $_POST['nickname'];
	$aspirant_exist = aspirant_exists($aspirant);
	$aspirant_tmp = $_FILES['aspirant_photo']['tmp_name'];
	$aspirant_name = $_FILES['aspirant_photo']['name'];
	$aspirant_size = $_FILES['aspirant_photo']['size'];
	$aspirant_type = $_FILES['aspirant_photo']['type'];
	
	if(empty($aspirant) || empty($post))
	{
		echo errors("Please fill all details");
	}
	else if($aspirant_exist)
	{
		$aspirant_post = get_aspirant_post($aspirant);
		$aspirant_post_name = get_post_name($aspirant_post);
		$aspirant_fullname = get_student_fullname($aspirant);
		
		echo errors("<b>$aspirant_fullname</b> is already aspiring for the post of <b>$aspirant_post_name</b>. Try again.");
	}
	else
	{
		$timestamp = time();
		$path_file = $timestamp.".jpg";
		$folder = "aspirants/";
		
		if($aspirant_type == "image/png" || $aspirant_type == "image/PNG" || $aspirant_type == "image/jpg" || $aspirant_type == "image/JPG" || $aspirant_type == "image/jpeg" || $aspirant_type == "image/JPEG")
		{
			$full_path = $folder.$path_file;
			move_uploaded_file($aspirant_tmp,$full_path);
			$image = new SimpleImage();
			$image->load($full_path); 
			$image->resize(200,200); 
			$image->save($full_path); 

			try{
				$query = $db_handle->prepare("INSERT INTO `aspirants` (aspirant_student_id,unique_id,post_id,nickname,path) VALUES(?,?,?,?,?)");
				$query->bindparam(1,$aspirant);
				$query->bindparam(2,$timestamp);
				$query->bindparam(3,$post);
				$query->bindparam(4,$nickname);
				$query->bindparam(5,$path_file);
				$query->execute();
				$count = $query->rowCount();
				
				if($count == 1)
				{
					echo successes("Aspirant's details was successfully added.");
					?>
						<script>
							window.location="aspirants";
						</script>
					<?php
				}
				else{
					echo errors("An error occured. Unable to add aspirant. Please try again.");
				}
			}
			catch(PDOException $error){
				echo errors("An error occured. Unable to add aspirant. Please try again.");
			}
		}
		else
		{
			echo errors("Please select an image.");
		}
	}
}

else if(isset($_GET['AccreditVoter']))
{
	$matric = $_POST['matric'];
	$pin = $_POST['pin'];
	$accredit_voter_exist = accredited_voter_exists($matric);
	$accredit_pin_exist = accredited_voter_pin_exists($pin);
	$voter_exist = voter_exists($matric);
	$voter_voted = is_voter_voted($matric);
	$pin_exist = is_key_exists($pin);
	$pin_used = is_key_used($pin);
		
	if(empty($matric) || empty($pin))
	{
		echo errors("Please fill both fields.");
	}
	else if(!$voter_exist)
	{
		echo errors("Voter does not exist.");
	}
	else if(!$pin_exist)
	{
		echo errors("Pin does not exist.");
	}
	else if($voter_voted)
	{
		echo errors("Voter has already voted.");
	}
	else if($pin_used)
	{
		echo errors("Pin has already been used for voting.");
	}
	else if($accredit_voter_exist)
	{
		echo errors("Voter has already been accredited.");
	}
	else if($accredit_pin_exist)
	{
		echo errors("Pin has already been used for accrediting another voter.");
	}
	else
	{
		try{
			$accredited_on = date("Y-m-d H:i:s");

			$query = $db_handle->prepare("INSERT INTO `accredited` (matric,pin,accredited_on) VALUES(?,?,?)");
			$query->bindparam(1,$matric);
			$query->bindparam(2,$pin);
			$query->bindparam(3,$accredited_on);
			$query->execute();
			$count = $query->rowCount();
			
			if($count == 1)
			{
				echo successes("Voter was successfully accredited.");
				$count_voters = count_accredited();

				?>
					<script type="text/javascript">
						
						$("#count_voters").html("<?php echo $count_voters;?>");
						$("#count_vote_voters").html("<?php echo $count_voters;?>");
						$("#matric").val("");
						$("#pin").val("");
						
						var per_page = 50;
						var current_page = 1;
						var dataString = "current_page="+current_page+"&per_page="+per_page;
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Retrieving all accredited voters &nbsp; <img src='../images/loading_bar.gif'/><br/>");
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
							url:"display?DisplayAllAccreditedVoters",
							
							success:function(msg)
							{
								$("#display_voters").html(msg);
							}
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to accredit voter. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to accredit voter. Please try again.");
		}
	}
}

else if(isset($_GET['AddVoterSingle']))
{
	$matric = $_POST['matric'];
	$constituency = $_POST['constituency'];
	$voter_exist = voter_exists($matric);
	
	if(empty($matric) || empty($constituency))
	{
		echo errors("Please fill both fields.");
	}
	else if($voter_exist)
	{
		echo errors("Matric number <b>$matric</b> has been added before. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("INSERT INTO `voters` (matric,constituency) VALUES(?,?)");
			$query->bindparam(1,$matric);
			$query->bindparam(2,$constituency);
			$query->execute();
			$count = $query->rowCount();
			
			if($count == 1)
			{
				echo successes("Voter's details was successfully added.");
				$count_voters = count_voters();

				?>
					<script type="text/javascript">
						
						$("#count_voters").html("<?php echo $count_voters;?>");
						$("#count_vote_voters").html("<?php echo $count_voters;?>");
						$("#matric").val("");
						
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
							url:"display?DisplayAllVoters",
							
							success:function(msg)
							{
								$("#display_voters").html(msg);
							}
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to add voters. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to add voters. Please try again.");
		}
	}
}

else if(isset($_GET['OldAddVoterSingle']))
{
	$surname = $_POST['surname'];
	$firstname = $_POST['firstname'];
	$othername = $_POST['othername'];
	$matric = $_POST['matric'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$dept = $_POST['dept'];
	$level = $_POST['level'];
	$voter_exist = voter_exists($matric);
	$voter_phone_exist = voter_phone_exists($phone);
	
	if(empty($surname) || empty($firstname) || empty($matric) || empty($dept) || empty($level) )
	{
		echo errors("Please fill all details");
	}
	else if($voter_exist)
	{
		echo errors("Matric number <b>$matric</b> has been added before. Try again.");
	}
	else if($voter_phone_exist)
	{
		echo errors("Voter with this phone number (<b>$phone</b>) has been added before. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("INSERT INTO `voters` (surname,firstname,othername,matric,phone,email,dept_id,level) VALUES(?,?,?,?,?,?,?,?)");
			$query->bindparam(1,$surname);
			$query->bindparam(2,$firstname);
			$query->bindparam(3,$othername);
			$query->bindparam(4,$matric);
			$query->bindparam(5,$phone);
			$query->bindparam(6,$email);
			$query->bindparam(7,$dept);
			$query->bindparam(8,$level);
			$query->execute();
			$count = $query->rowCount();
			
			if($count == 1)
			{
				echo successes("Voter's details was successfully added.");
				?>
					<script>
						window.location="voters";
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to add voters. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to add voters. Please try again.");
		}
	}
}

else if(isset($_GET['GenerateVotingKeys']))
{
	$key_num = $_POST['key_num'];
	$done = false;

	if(empty($key_num))
	{
		echo error_admin_msg("Enter the number of voting keys you want to generate.");
	}
	else if($key_num > 500)
	{
		echo error_admin_msg("Sorry, you can't generate more than 500 voting keys at a go.");
	}
	else
	{
		$keys_array = array();

		for($i=1;$i<=$key_num;$i++)
		{
			$counter = $i-1;
			//$keys = mt_rand(100000,999999);
			$keys = Generate_Voting_Keys(6);
			$key_exists = is_key_exists($keys);

			if(!$key_exists)
			{
				$keys_array[$counter] = $keys;
			}

			try
			{
				if(!$key_exists)
				{	
					$query = $db_handle->prepare("INSERT INTO `voting_keys` SET `keys` = ?");
					$query->bindparam(1,$keys);
					$query->execute();
					$count = $query->rowCount();
					
					if($count > 0)
					{
						$done = true;
					}
					else{
						$done = false;
					}
				} 
				else{
					echo error_admin_msg("<b>$keys</b> has been generated before.");
				}
			}
			catch(PDOException $error){
				$done = false;
			}
		}

		echo "<div style='clear:both'></div>";
		
		if($done == true) 
		{
				
			if($key_num < 2)
			{
				echo success_admin_msg("$key_num voting key was successfully generated.");
				echo "<h2 align='center'>$key_num generated voting key </h2>";
			}
			else
			{
				echo success_admin_msg("$key_num voting keys were successfully generated.");
				echo "<h2 align='center'>$key_num generated voting keys </h2>";
			}
			$count_keys = count_keys();

				?>
				
				<script type="text/javascript">
                		
            		var per_page = 200;
                    var current_page = 1;
                    var dataString = "current_page="+current_page+"&per_page="+per_page;
                   	$("#count_keys").html("<?php echo $count_keys;?>"); 
                    $("#count_vote_keys").html("<?php echo $count_keys;?>"); 
                    
                    $.ajaxSetup(
                    {
                        beforeSend: function()
                        {
                            $("#fetch").html("Retrieving voting keys &nbsp; <img src='images/loading_bar.gif'/><br/>");
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
                        url:"display?DisplayAllVotingKeys",
                        
                        success:function(msg)
                        {
                            $("#display_keys").html(msg);
                        }
                    });
                        
                </script>
                
               	<button onClick="Print('generated_keys_div');"class="btn btn-info pull-left"><i class="icon-print"></i> Print keys </button> <div style="clear:both"></div>
				<br/>
				
				<div id='generated_keys_div'>

				<?php

				foreach($keys_array as $each_key)
				{
					?>
					<div class='keys'>
						
						<?php echo $each_key;?>
					</div>
					<?php
				}
				echo "<br/></div>";
		}
		else 
		{
			echo error_admin_msg("An error occured. Unable to generate voting keys. Please try again.");
		}
	}
}

else if(isset($_GET['UpdateVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter_id = $_POST['voter_id'];
	$matric = $_POST['matric'];
	$constituency = $_POST['constituency'];
	$voter_exist = voter_matric_exists_in_db($matric,$voter_id);
	
	if(empty($matric) || empty($constituency))
	{
		echo errors("Please fill both fields.");
	}
	else if($voter_exist)
	{
		echo errors("Matric number <b>$matric</b> has used by another voter. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `matric`= ?, `constituency` = ? WHERE `voters_id` = ?");
			$query->bindparam(1,$matric);
			$query->bindparam(2,$constituency);
			$query->bindparam(3,$voter_id);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute())
			{
				echo successes("Voter's details was successfully updated.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});

						$.post('display?DisplayAllVoters', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_modify_voters").fadeOut();
							$("#display_voters").html(msg).fadeIn();
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to update voter's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to update voter's details. Please try again.");
		}
	}
}

else if(isset($_GET['AnotherUpdateVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter_id = $_POST['voter_id'];
	$search_voter = $_POST['search_voter'];
	$matric = $_POST['matric'];
	$constituency = $_POST['constituency'];
	$voter_exist = voter_matric_exists_in_db($matric,$voter_id);
	
	if(empty($matric) || empty($constituency))
	{
		echo errors("Please fill both fields.");
	}
	
	if(empty($matric))
	{
		echo errors("Please enter the matric number.");
	}
	else if($voter_exist)
	{
		echo errors("Matric number <b>$matric</b> has used by another voter. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `matric`= ?, `constituency` = ? WHERE `voters_id` = ?");
			$query->bindparam(1,$matric);
			$query->bindparam(2,$constituency);
			$query->bindparam(3,$voter_id);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute())
			{
				echo successes("Voter's details was successfully updated.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_voter = "<?php echo $search_voter;?>";
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});

						$.post('display?DisplayAllSearchedVoters', {current_page:current_page,per_page:per_page,voter:search_voter}, function(msg)
						{
							$("#display_search_modify_voters").fadeOut();
							$("#display_search_voters").html(msg).fadeIn();
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to update voter's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to update voter's details. Please try again.");
		}
	}
}

else if(isset($_GET['SearchVoter']))
{
	$voter = $_POST['voter'];
	
	if($voter !== "") 
	{
		$search_query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? ORDER BY `matric`");
		
		$search_query->bindvalue(1,'%'.$voter.'%');
		$search_query->bindvalue(2,$voter.'%');
		$search_query->bindvalue(3,'%'.$voter);
		$search_query->bindvalue(4,'%'.$voter.'%');
		$search_query->bindvalue(5,$voter.'%');
		$search_query->bindvalue(6,'%'.$voter);
		$search_query->execute();
		$count = $search_query->rowCount();
	
		if($count == 0) 
		{
			echo errors("No match found. Try again.");
		}
		else
		{
			if($count < 2) {
				echo successes("$count match found.");
			}
			else {
				echo successes("$count matches found.");
			}
			?>

			<script type="text/javascript">
						
				$(document).ready(function()
				{
					var per_page = 100;
					var current_page = 1;
					var voter = "<?php echo $voter;?>";
					var dataString = "current_page="+current_page+"&per_page="+per_page+"&voter="+voter;
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							$("#support_ajax_status").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
						},
						complete: function()
						{
							$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
						}
					});
					
					$.ajax(
					{
						type:"POST",
						data: dataString,
						cache:false,
						url:"display?DisplayAllSearchedVoters",
						
						success:function(msg)
						{
							$("#display_voters").hide("fast");
							$("#display_search_voters").show("fast");
							$("#display_search_voters").html(msg);
						}
					});
				});
			</script>
			
			<?php
		}
	}
	else {
		echo errors("No match found!");
	}
}

else if(isset($_GET['SearchVoted']))
{
	$voter = $_POST['voter'];
	
	if($voter !== "") 
	{
		$search_query = $db_handle->prepare("SELECT *FROM `voters` WHERE (`matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ?) AND (`voted` = '1') ORDER BY `matric`");
		
		$search_query->bindvalue(1,'%'.$voter.'%');
		$search_query->bindvalue(2,$voter.'%');
		$search_query->bindvalue(3,'%'.$voter);
		$search_query->bindvalue(4,'%'.$voter.'%');
		$search_query->bindvalue(5,$voter.'%');
		$search_query->bindvalue(6,'%'.$voter);
		$search_query->execute();
		$count = $search_query->rowCount();
	
		if($count == 0) 
		{
			echo errors("No match found. Try again.");
		}
		else
		{
			if($count < 2) {
				echo successes("$count match found.");
			}
			else {
				echo successes("$count matches found.");
			}
			?>

			<script type="text/javascript">
						
				$(document).ready(function()
				{
					var per_page = 10;
					var current_page = 1;
					var voter = "<?php echo $voter;?>";
					var dataString = "current_page="+current_page+"&per_page="+per_page+"&voter="+voter;
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							$("#support_ajax_status").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
						},
						complete: function()
						{
							$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
						}
					});
					
					$.ajax(
					{
						type:"POST",
						data: dataString,
						cache:false,
						url:"display?DisplayAllSearchedVoted",
						
						success:function(msg)
						{
							$("#display_voted").hide("fast");
							$("#display_search_voted").show("fast");
							$("#display_search_voted").html(msg);
						}
					});
				});
			</script>
			
			<?php
		}
	}
	else {
		echo errors("No match found!");
	}
}

else if(isset($_GET['AnotherSearchVoted']))
{
	$voter = $_POST['another_voter'];
	
	if($voter !== "") 
	{
		$search_query = $db_handle->prepare("SELECT *FROM `voters` WHERE (`matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ?) AND (`voted` = '1') ORDER BY `matric`");
		
		$search_query->bindvalue(1,'%'.$voter.'%');
		$search_query->bindvalue(2,$voter.'%');
		$search_query->bindvalue(3,'%'.$voter);
		$search_query->bindvalue(4,'%'.$voter.'%');
		$search_query->bindvalue(5,$voter.'%');
		$search_query->bindvalue(6,'%'.$voter);
		$search_query->execute();
		$count = $search_query->rowCount();
	
		if($count == 0) 
		{
			echo errors("No match found. Try again.");
		}
		else
		{
			if($count < 2) {
				echo successes("$count match found.");
			}
			else {
				echo successes("$count matches found.");
			}
			?>

			<script type="text/javascript">
						
				$(document).ready(function()
				{
					var per_page = 10;
					var current_page = 1;
					var voter = "<?php echo $voter;?>";
					var dataString = "current_page="+current_page+"&per_page="+per_page+"&voter="+voter;
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							$("#support_ajax_status").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
						},
						complete: function()
						{
							$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
						}
					});
					
					$.ajax(
					{
						type:"POST",
						data: dataString,
						cache:false,
						url:"display?DisplayAllSearchedVoted",
						
						success:function(msg)
						{
							$("#display_voted").hide("fast");
							$("#display_search_voted").show("fast");
							$("#display_search_voted").html(msg);
						}
					});
				});
			</script>
			
			<?php
		}
	}
	else {
		echo errors("No match found!");
	}
}

else if(isset($_GET['AnotherSearchVoter']))
{
	$voter = $_POST['another_voter'];
	
	if($voter !== "") 
	{
		$search_query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? ORDER BY `matric`");
		
		$search_query->bindvalue(1,'%'.$voter.'%');
		$search_query->bindvalue(2,$voter.'%');
		$search_query->bindvalue(3,'%'.$voter);
		$search_query->bindvalue(4,'%'.$voter.'%');
		$search_query->bindvalue(5,$voter.'%');
		$search_query->bindvalue(6,'%'.$voter);
		$search_query->execute();
		$count = $search_query->rowCount();
	
		if($count == 0) 
		{
			echo errors("No match found. Try again.");
		}
		else
		{
			if($count < 2) {
				echo successes("$count match found.");
			}
			else {
				echo successes("$count matches found.");
			}
			?>

			<script type="text/javascript">
						
				$(document).ready(function()
				{
					var per_page = 100;
					var current_page = 1;
					var voter = "<?php echo $voter;?>";
					var dataString = "current_page="+current_page+"&per_page="+per_page+"&voter="+voter;
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							$("#support_ajax_status").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
						},
						complete: function()
						{
							$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
						}
					});
					
					$.ajax(
					{
						type:"POST",
						data: dataString,
						cache:false,
						url:"display?DisplayAllSearchedVoters",
						
						success:function(msg)
						{
							$("#display_voters").hide("fast");
							$("#display_search_voters").show("fast");
							$("#display_search_voters").html(msg);
						}
					});
				});
			</script>
			
			<?php
		}
	}
	else {
		echo errors("No match found!");
	}
}


else if(isset($_GET['SearchAspirant']))
{
	$aspirant = $_POST['aspirant'];
	
	if($aspirant !== "") 
	{
		$search_query = $db_handle->prepare("SELECT `aspirant_id` FROM `aspirants` WHERE `fullname` = ? OR `fullname` LIKE ? OR `fullname` LIKE ? OR `nickname` = ? OR `nickname` LIKE ? OR `nickname` LIKE ? OR `matric` = ? OR `matric` LIKE ? OR `matric` LIKE ? ORDER BY `fullname`");
		
		$search_query->bindvalue(1,'%'.$aspirant.'%');
		$search_query->bindvalue(2,$aspirant.'%');
		$search_query->bindvalue(3,'%'.$aspirant);
		$search_query->bindvalue(4,'%'.$aspirant.'%');
		$search_query->bindvalue(5,$aspirant.'%');
		$search_query->bindvalue(6,'%'.$aspirant);
		$search_query->bindvalue(7,'%'.$aspirant.'%');
		$search_query->bindvalue(8,$aspirant.'%');
		$search_query->bindvalue(9,'%'.$aspirant);
		$search_query->execute();
		$count = $search_query->rowCount();
	
		if($count == 0) 
		{
			echo errors("No match found. Try again.");
		}
		else
		{
			if($count < 2) {
				echo successes("$count match found.");
			}
			else {
				echo successes("$count matches found.");
			}
			?>

			<script type="text/javascript">
						
				$(document).ready(function()
				{
					var per_page = 10;
					var current_page = 1;
					var aspirant = "<?php echo $aspirant;?>";
					var dataString = "current_page="+current_page+"&per_page="+per_page+"&aspirant="+aspirant;
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							$("#support_ajax_status").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
						},
						complete: function()
						{
							$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
						}
					});
					
					$.ajax(
					{
						type:"POST",
						data: dataString,
						cache:false,
						url:"display?DisplayAllSearchedAspirants",
						
						success:function(msg)
						{
							$("#display_aspirants").hide("fast");
							$("#display_search_aspirants").show("fast");
							$("#display_search_aspirants").html(msg);
						}
					});
				});
			</script>
			
			<?php
		}
	}
	else {
		echo errors("No match found!");
	}
}

else if(isset($_GET['SearchAnotherAspirant']))
{
	$aspirant = $_POST['another_aspirant'];
	
	if($aspirant !== "") 
	{
		$search_query = $db_handle->prepare("SELECT `aspirant_id` FROM `aspirants` WHERE `fullname` = ? OR `fullname` LIKE ? OR `fullname` LIKE ? OR `nickname` = ? OR `nickname` LIKE ? OR `nickname` LIKE ? OR `matric` = ? OR `matric` LIKE ? OR `matric` LIKE ? ORDER BY `fullname`");
		
		$search_query->bindvalue(1,'%'.$aspirant.'%');
		$search_query->bindvalue(2,$aspirant.'%');
		$search_query->bindvalue(3,'%'.$aspirant);
		$search_query->bindvalue(4,'%'.$aspirant.'%');
		$search_query->bindvalue(5,$aspirant.'%');
		$search_query->bindvalue(6,'%'.$aspirant);
		$search_query->bindvalue(7,'%'.$aspirant.'%');
		$search_query->bindvalue(8,$aspirant.'%');
		$search_query->bindvalue(9,'%'.$aspirant);
		$search_query->execute();
		$count = $search_query->rowCount();
	
		if($count == 0) 
		{
			echo errors("No match found. Try again.");
		}
		else
		{
			if($count < 2) {
				echo successes("$count match found.");
			}
			else {
				echo successes("$count matches found.");
			}
			?>

			<script type="text/javascript">
						
				$(document).ready(function()
				{
					var per_page = 10;
					var current_page = 1;
					var aspirant = "<?php echo $aspirant;?>";
					var dataString = "current_page="+current_page+"&per_page="+per_page+"&aspirant="+aspirant;
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							$("#support_ajax_status").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
						},
						complete: function()
						{
							$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
						}
					});
					
					$.ajax(
					{
						type:"POST",
						data: dataString,
						cache:false,
						url:"display?DisplayAllSearchedAspirants",
						
						success:function(msg)
						{
							$("#display_aspirants").hide("fast");
							$("#display_search_aspirants").show("fast");
							$("#display_search_aspirants").html(msg);
						}
					});
				});
			</script>
			
			<?php
		}
	}
	else {
		echo errors("No match found!");
	}
}

else if(isset($_GET['OldUpdateVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter_id = $_POST['voter_id'];
	$surname = $_POST['surname'];
	$firstname = $_POST['firstname'];
	$othername = $_POST['othername'];
	$matric = $_POST['matric'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$dept = $_POST['dept'];
	$level = $_POST['level'];
	$voter_exist = voter_matric_exists_in_db($matric,$voter_id);
	$voter_phone_exist = voter_phone_exists_in_db($phone,$voter_id);
	
	if(empty($surname) || empty($firstname) || empty($matric) || empty($dept) || empty($level) )
	{
		echo errors("Please fill all compulsory details");
	}
	else if($voter_exist)
	{
		echo errors("Matric number <b>$matric</b> has used by another voter. Try again.");
	}
	else if($voter_phone_exist)
	{
		echo errors("Phone number (<b>$phone</b>) has used by another voter. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `surname`= ?,`firstname`= ?,`othername`= ?,`matric`= ?,`phone`= ?,`email`= ?,`dept_id`= ?,`level`= ? WHERE `voters_id` = ?");
			$query->bindparam(1,$surname);
			$query->bindparam(2,$firstname);
			$query->bindparam(3,$othername);
			$query->bindparam(4,$matric);
			$query->bindparam(5,$phone);
			$query->bindparam(6,$email);
			$query->bindparam(7,$dept);
			$query->bindparam(8,$level);
			$query->bindparam(9,$voter_id);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute())
			{
				echo successes("Voter's details was successfully updated.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.post('display?DisplayAllVoters', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_modify_voters").fadeOut();
							$("#display_voters").html(msg).fadeIn();
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to update voter's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to update voter's details. Please try again.");
		}
	}
}

else if(isset($_GET['AddVotersBulk']))
{
	$csv_file = $_FILES['voters_file']['tmp_name'];
	$file_name = $_FILES['voters_file']['name'];
	$type = $_FILES['voters_file']['type'];
	$error = $_FILES['voters_file']['error'];
	$allowed = array('.csv');
	$extension = substr($file_name,strrpos($file_name,'.'));
	$done = false;				
	
	if($file_name == "")
	{
		echo errors("Please select a file");
	}
	else if(!in_array($extension,$allowed))
	{
		echo errors("Invalid file type.");
	}
	else
	{
		if(is_file($csv_file)) 
		{
			$file = fopen($csv_file, "r");
			$counter = 0;
			$exists_counter = 0;

			while(($all_data = fgetcsv($file, 100000, ",")) !== FALSE)
			{
				$matric = $all_data[0];
				$constituency = $all_data[1];
				$voter_exist = voter_exists($matric);
				
				if($voter_exist)
				{
					$exists_counter++;
					$done = true;
				}
				else
				{
					try
					{
						$query = $db_handle->prepare("INSERT INTO `voters` (matric,constituency) VALUES(?,?)");
						$query->bindparam(1,$matric);
						$query->bindparam(2,$constituency);
						$query->execute();
						$count = $query->rowCount();
						
						if($count > 0)
						{
							$counter++;
							$done = true;
						}
						else{
							$done = false;
						}
					}
					catch(PDOException $error){
						$done = false;
					}
				}
			}
		}

		if($done == true)
		{
			if($counter < 2)
			{
				echo successes("<b>$counter</b> voter's details was successfully added.");
			}
			else if($counter > 1)
			{
				echo successes("<b>$counter</b> voters' details were successfully added. <br/>
					$exists_counter voters exist.");
			}

			$count_voters = count_voters();

			?>
				<script type="text/javascript">
						
					$("#count_voters").html("<?php echo $count_voters;?>");
					$("#count_vote_voters").html("<?php echo $count_voters;?>");

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
						url:"display?DisplayAllVoters",
						
						success:function(msg)
						{
							$("#display_voters").html(msg);
						}
					});
				</script>
			<?php
		}
		else
		{
			echo errors("An error occured. Unable to add voters' details. Please try again.");
		}		
	}
}

else if(isset($_GET['OldAddVotersBulk']))
{
	$csv_file = $_FILES['voters_file']['tmp_name'];
	$file_name = $_FILES['voters_file']['name'];
	$type = $_FILES['voters_file']['type'];
	$error = $_FILES['voters_file']['error'];
	$allowed = array('.csv');
	$extension = substr($file_name,strrpos($file_name,'.'));
	$done = false;				
	
	if($file_name == "")
	{
		echo errors("Please select a file");
	}
	else if(!in_array($extension,$allowed))
	{
		echo errors("Invalid file type.");
	}
	else
	{
		if(is_file($csv_file)) 
		{
			$file = fopen($csv_file, "r");
			$counter = 0;
			
			while(($all_data = fgetcsv($file, 100000, ",")) !== FALSE)
			{
				$surname = $all_data[0];
				$firstname = $all_data[1];
				$othername = $all_data[2];
				$matric = $all_data[3];
				$phone = $all_data[4];
				$email = $all_data[5];
				$dept = $all_data[6];
				$level = $all_data[7];
				
				$dept_id = get_dept_id($dept);
				$voter_exist = voter_exists($matric);
				$voter_phone_exist = voter_phone_exists($phone);
	
				if($voter_exist)
				{
					echo errors("Matric number <b>$matric</b> has been added before. Try again.");
				}
				else if($voter_phone_exist)
				{
					echo errors("Voter with this phone number (<b>$phone</b>) has been added before. Try again.");
				}
				else
				{
					try
					{
						$query = $db_handle->prepare("INSERT INTO `voters` (surname,firstname,othername,matric,phone,email,dept_id,level) VALUES(?,?,?,?,?,?,?,?)");
						$query->bindparam(1,$surname);
						$query->bindparam(2,$firstname);
						$query->bindparam(3,$othername);
						$query->bindparam(4,$matric);
						$query->bindparam(5,$phone);
						$query->bindparam(6,$email);
						$query->bindparam(7,$dept_id);
						$query->bindparam(8,$level);
						$query->execute();
						$count = $query->rowCount();
						
						if($count > 0)
						{
							$counter++;
							$done = true;
						}
						else{
							$done = false;
						}
					}
					catch(PDOException $error){
						$done = false;
					}
				}
			}
		}

		if($done == true)
		{
			if($counter < 2)
			{
				echo successes("<b>$counter</b> voter's details was successfully added.");
			}
			else if($counter > 1)
			{
				echo successes("<b>$counter</b> voters' details were successfully added.");
			}
			?>
				<script>
					window.location="voters";
				</script>
			<?php
		}
		else
		{
			echo errors("An error occured. Unable to add voters' details. Please try again.");
		}		
	}
}

else if(isset($_GET['UpdateDepartment']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$dept_name = $_POST['dept_name'];
	$dept_id = $_POST['dept_id'];
	$dept_exist = dept_exist_in_db($dept_id,$dept_name);
	
	if(empty($dept_id) || empty($dept_name))
	{
		echo errors("Please enter the department");
	}
	else if($dept_exist)
	{
		echo errors("<b>$dept_name</b> has been added before. Try again.");
	}
	else
	{
		try{
			$dept_query = $db_handle->prepare("UPDATE `depts` SET `dept` = ? WHERE `dept_id` = ?");
			$dept_query->bindparam(1,$dept_name);
			$dept_query->bindparam(2,$dept_id);
			$dept_query->execute();
			$count = $dept_query->rowCount();
			
			if($dept_query->execute()){
				echo successes("Department was successfully updated.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch_depts").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch_depts").html("");
							}
						});

						$.post('display?DisplayAllDepartments', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_depts").html(msg).fadeIn(200);
							$("#edit_depts").fadeOut(200);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to update department. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to update department. Please try again.");
		}
	}
}

else if(isset($_GET['DeletePost']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$post = $_POST['post'];
	
	if(empty($post))
	{
		echo errors("Please select the post");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `posts` WHERE `post_id` = ?");
			$query->bindparam(1,$post);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_posts = count_posts();
				echo successes("Post was successfully deleted.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_posts").html("<?php echo $count_posts;?>");

						$.post('display?DisplayAllPosts', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_posts").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete post. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete post. Please try again.");
		}
	}
}

else if(isset($_GET['ResetVotingKeys']))
{
	try
	{
		$query = $db_handle->prepare("TRUNCATE TABLE `voting_keys`");
		$query->execute();
		$count = $query->rowCount();
		
		if($query->execute())
		{
			echo successes("All voting keys were successfully deleted.");
			?>
				<script>
					window.location = "keys";
				</script>
			<?php
		}
		else{
			echo errors("An error occured. Unable to delete all voting keys. Please try again.");
		}
	}
	catch(PDOException $error){
		echo errors("An error occured. Unable to delete all voting keys. Please try again.");
	}
}

else if(isset($_GET['ResetVoters']))
{
	try
	{
		$query = $db_handle->prepare("TRUNCATE TABLE `voters`");
		$query->execute();
		$count = $query->rowCount();
		
		if($query->execute())
		{
			echo successes("All voters were successfully deleted.");
			?>
				<script>
					window.location = "voters";
				</script>
			<?php
		}
		else{
			echo errors("An error occured. Unable to delete all voters. Please try again.");
		}
	}
	catch(PDOException $error){
		echo errors("An error occured. Unable to delete all voters. Please try again.");
	}
}

else if(isset($_GET['ResetAspirants']))
{
	try
	{
		$full_dir = "aspirants/";
	
		foreach(glob($full_dir.'*.jpg*') as $file)
		{
			unlink($file);
		}
		
		$query = $db_handle->prepare("TRUNCATE TABLE `aspirants`");
		$query->execute();
		$count = $query->rowCount();
		
		if($query->execute())
		{
			echo successes("All aspirants were successfully deleted.");
			?>
				<script>
					window.location = "aspirants";
				</script>
			<?php
		}
		else{
			echo errors("An error occured. Unable to delete all aspirants. Please try again.");
		}
	}
	catch(PDOException $error){
		echo errors("An error occured. Unable to delete all aspirants. Please try again.");
	}
}



else if(isset($_GET['DisableVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `qualify` = '0' WHERE `voters_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Voter's account was successfully disabled from voting.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});

						$.post('display?DisplayAllVoters', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to disable voter from voting. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to disable voter from voting. Please try again.");
		}
	}
}

else if(isset($_GET['AnotherDisableVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	$search_voter = $_POST['search_voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `qualify` = '0' WHERE `voters_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Voter's account was successfully disabled from voting.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_voter = "<?php echo $search_voter;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.post('display?DisplayAllSearchedVoters', {current_page:current_page,per_page:per_page,voter:search_voter}, function(msg)
						{
							$("#display_search_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to disable voter from voting. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to disable voter from voting. Please try again.");
		}
	}
}

else if(isset($_GET['AnotherEnableVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	$search_voter = $_POST['search_voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `qualify` = '1' WHERE `voters_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Voter's account was successfully enabled to vote.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_voter = "<?php echo $search_voter;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.post('display?DisplayAllSearchedVoters', {current_page:current_page,per_page:per_page,voter:search_voter}, function(msg)
						{
							$("#display_search_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to enable to vote. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to disable enable to vote. Please try again.");
		}
	}
}

else if(isset($_GET['DisqualifyAspirant']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$aspirant = $_POST['aspirant'];
	
	if(empty($aspirant))
	{
		echo errors("Please select the aspirant");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `aspirants` SET `qualify` = '0' WHERE `aspirant_id` = ?");
			$query->bindparam(1,$aspirant);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Aspirant was successfully disqualify from contesting.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});
							
						
						$.post('display?DisplayAllAspirants', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_aspirants").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to disqualify aspirant from contesting. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to disqualify aspirant from contesting. Please try again.");
		}
	}
}

else if(isset($_GET['DisqualifyFloorRep']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$floor_rep = $_POST['rep'];
	
	if(empty($floor_rep))
	{
		echo errors("Please select the floor rep");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `floor_reps` SET `qualify` = '0' WHERE `rep_id` = ?");
			$query->bindparam(1,$floor_rep);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Floor rep was successfully disqualified from contesting.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});
							
						
						$.post('display?DisplayAllFloorReps', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_reps").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to disqualify floor rep from contesting. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to disqualify floor rep from contesting. Please try again.");
		}
	}
}

else if(isset($_GET['QualifyFloorRep']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$floor_rep = $_POST['rep'];
	
	if(empty($floor_rep))
	{
		echo errors("Please select the floor rep");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `floor_reps` SET `qualify` = '1' WHERE `rep_id` = ?");
			$query->bindparam(1,$floor_rep);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Floor rep was successfully qualified to contest.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});
							
						
						$.post('display?DisplayAllFloorReps', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_reps").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to qualify floor rep to contest. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to qualify floor rep to contest. Please try again.");
		}
	}
}

else if(isset($_GET['SearchDisqualifyAspirant']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$aspirant = $_POST['aspirant'];
	$search_aspirant = $_POST['search_aspirant'];
	
	if(empty($aspirant))
	{
		echo errors("Please select the aspirant");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `aspirants` SET `qualify` = '0' WHERE `aspirant_id` = ?");
			$query->bindparam(1,$aspirant);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Aspirant was successfully disqualify from contesting.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_aspirant = "<?php echo $search_aspirant;?>";

						$.post('display?DisplayAllSearchedAspirants', {current_page:current_page,per_page:per_page,aspirant:search_aspirant}, function(msg)
						{
							$("#display_search_aspirants").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to disqualify aspirant from contesting. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to disqualify aspirant from contesting. Please try again.");
		}
	}
}

else if(isset($_GET['SearchQualifyAspirant']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$aspirant = $_POST['aspirant'];
	$search_aspirant = $_POST['search_aspirant'];
	
	if(empty($aspirant))
	{
		echo errors("Please select the aspirant");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `aspirants` SET `qualify` = '1' WHERE `aspirant_id` = ?");
			$query->bindparam(1,$aspirant);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Aspirant was successfully re-qualified to contest.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_aspirant = "<?php echo $search_aspirant;?>";

						$.post('display?DisplayAllSearchedAspirants', {current_page:current_page,per_page:per_page,aspirant:search_aspirant}, function(msg)
						{
							$("#display_search_aspirants").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to re-qualify aspirant to contest. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to re-qualify aspirant to contest. Please try again.");
		}
	}
}

else if(isset($_GET['QualifyAspirant']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$aspirant = $_POST['aspirant'];
	
	if(empty($aspirant))
	{
		echo errors("Please select the aspirant");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `aspirants` SET `qualify` = '1' WHERE `aspirant_id` = ?");
			$query->bindparam(1,$aspirant);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Aspirant was successfully re-qualified to contest.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});

						$.post('display?DisplayAllAspirants', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_aspirants").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to re-qualify aspirant to contest. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to re-qualify aspirant to contest. Please try again.");
		}
	}
}

else if(isset($_GET['SearchDeleteAspirant']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$aspirant = $_POST['aspirant'];
	$search_aspirant = $_POST['search_aspirant'];
	
	if(empty($aspirant))
	{
		echo errors("Please select the aspirant");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `aspirants` WHERE `aspirant_id` = ?");
			$query->bindparam(1,$aspirant);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute())
			{
				echo successes("Aspirant's details was successfully deleted.");
				$count_aspirants = count_aspirants();?>
					
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_aspirant = "<?php echo $search_aspirant;?>";

						$.post('display?DisplayAllSearchedAspirants', {current_page:current_page,per_page:per_page,aspirant:search_aspirant}, function(msg)
						{
							$("#display_search_aspirants").html(msg);
						});
					</script>

				<?php
			}
			else
			{
				echo errors("An error occured. Unable to delete aspirant's details. Please try again.");
			}
		}
		catch(PDOException $error)
		{
			echo errors("An error occured. Unable to delete aspirant's details. Please try again.");
		}
	}
}

else if(isset($_GET['DeleteAspirant']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$aspirant = $_POST['aspirant'];
	
	if(empty($aspirant))
	{
		echo errors("Please select the aspirant");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `aspirants` WHERE `aspirant_id` = ?");
			$query->bindparam(1,$aspirant);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Aspirant's details was successfully deleted.");
				$count_aspirants = count_aspirants();?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_aspirants").html("<?php echo $count_aspirants;?>");

						$.post('display?DisplayAllAspirants', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_aspirants").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete aspirant's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete aspirant's details. Please try again.");
		}
	}
}

else if(isset($_GET['DeleteFloorRep']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$rep = $_POST['rep'];
	
	if(empty($rep))
	{
		echo errors("Please select the floor rep");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `floor_reps` WHERE `rep_id` = ?");
			$query->bindparam(1,$rep);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Floor rep's details was successfully deleted.");
				$count_floor_reps = count_floor_reps();?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_floor_reps").html("<?php echo $count_floor_reps;?>");

						$.post('display?DisplayAllFloorReps', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_reps").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete floor rep's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete floor rep's details. Please try again.");
		}
	}
}

else if(isset($_GET['EnableVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `voters` SET `qualify` = '1' WHERE `voters_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Voter's account was successfully enabled to vote.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});

						$.post('display?DisplayAllVoters', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to enable voter to vote. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to enable voter to vote. Please try again.");
		}
	}
}

else if(isset($_GET['DeleteVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `voters` WHERE `voters_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Voter's details was successfully deleted.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.post('display?DisplayAllVoters', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete voter's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete voter's details. Please try again.");
		}
	}
}

else if(isset($_GET['DeleteAccreditedVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `accredited` WHERE `accredit_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Accredited voter was successfully deleted.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.post('display?DisplayAllAccreditedVoters', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete voter's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete voter's details. Please try again.");
		}
	}
}

else if(isset($_GET['AnotherDeleteVoter']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$voter = $_POST['voter'];
	$search_voter = $_POST['search_voter'];
	
	if(empty($voter))
	{
		echo errors("Please select the voter");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `voters` WHERE `voters_id` = ?");
			$query->bindparam(1,$voter);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_voters = count_voters();
				echo successes("Voter's details was successfully deleted.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var search_voter = "<?php echo $search_voter;?>";
						$("#count_voters").html("<?php echo $count_voters;?>");

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch").html("");
							}
						});

						$.post('display?DisplayAllSearchedVoters', {current_page:current_page,per_page:per_page,voter:search_voter}, function(msg)
						{
							$("#display_search_voters").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete voter's details. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete voter's details. Please try again.");
		}
	}
}

else if(isset($_GET['DeleteDepartment']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$dept = $_POST['dept'];
	
	if(empty($dept))
	{
		echo errors("Please select the dept");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `depts` WHERE `dept_id` = ?");
			$query->bindparam(1,$dept);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				$count_depts = count_depts();
				echo successes("Department was successfully deleted.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						$("#count_depts").html("<?php echo $count_depts;?>");

						$.ajaxSetup(
						{
							beforeSend: function()
							{
								$("#fetch_depts").html("Please wait &nbsp; <img src='../images/loading_bar.gif'/><br/>");
							},
							complete: function()
							{
								$("#fetch_depts").html("");
							}
						});

						$.post('display?DisplayAllDepartments', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_depts").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete department. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete department. Please try again.");
		}
	}
}

else if(isset($_GET['UpdatePost']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$post_name = $_POST['post_name'];
	$post_id = $_POST['post_id'];
	$post_exist = post_exist_in_db($post_id,$post_name);
	
	if(empty($post_id) || empty($post_name))
	{
		echo errors("Please enter the post name");
	}
	else if($post_exist)
	{
		echo errors("<b>$post_name</b> has been added before. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `posts` SET `post` = ? WHERE `post_id` = ?");
			$query->bindparam(1,$post_name);
			$query->bindparam(2,$post_id);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Post was successfully updated.");
				?>
					<script>
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.post('display?DisplayAllPosts', {current_page:current_page,per_page:per_page}, function(msg)
						{
							$("#display_posts").html(msg).fadeIn(200);
							$("#edit_posts").fadeOut(200);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to update post. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to update post. Please try again.");
		}
	}
}


else if(isset($_GET['AddAdmin']))
{
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$rank = $_POST['rank'];
	$admin_exist_username = admin_exist_username($username);
	
	if(empty($username) || empty($password) || empty($rank))
	{
		echo errors("Please fill/select all details");
	}
	else if($admin_exist_username)
	{
		echo errors("Admin details exists. Try again.");
	}
	else
	{
		try{
			$query = $db_handle->prepare("INSERT INTO `omo_ogun` (username,password,rank) VALUES(?,?,?)");
			$query->bindparam(1,$username);
			$query->bindparam(2,$password);
			$query->bindparam(3,$rank);
			$query->execute();
			$count = $query->rowCount();
			
			if($count == 1){
				echo successes("Admin details was successfully added.");
				?>
					<script>
						$("#username").val("");
						$("#password").val("");
						$("#rank").val("");
						//window.location="admins?AddAdmin";
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to add administrator.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to add administrator.");
		}
	}
}
else if(isset($_GET['DeleteAdmin']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$logged_admin = $_POST['logged_admin'];
	$admin = $_POST['admin'];
	
	if(empty($admin))
	{
		echo errors("Please select the admin");
	}
	else
	{
		try{
			$query = $db_handle->prepare("DELETE FROM `omo_ogun` WHERE `admin_id` = ?");
			$query->bindparam(1,$admin);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Admin was successfully deleted.");
				?>
					<script>
						//window.location="admins";
						var logged_admin = "<?php echo $logged_admin;?>";
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.post('display?DisplayAllAdmins', {current_page:current_page,per_page:per_page, admin:logged_admin}, function(msg)
						{
							$("#display_admins").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to delete admin. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to delete admin. Please try again.");
		}
	}
}

else if(isset($_GET['ResetAdminPassword']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$admin = $_POST['admin'];
	list($username) = get_admin_details($admin);
	$password = md5("12345");

	if(empty($admin))
	{
		echo errors("Please select the admin");
	}
	else
	{
		try
		{
			$query = $db_handle->prepare("UPDATE `omo_ogun` SET `password` = ? WHERE `admin_id` = ?");
			$query->bindparam(1,$password);
			$query->bindparam(2,$admin);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute())
			{
				echo successes(ucfirst($username)."'s password was successfully reset to <b>12345</b>.");
			}
			else
			{
				echo errors("An error occured. Unable to reset admin password. Please try again.");
			}
		}
		catch(PDOException $error)
		{
			echo errors("An error occured. Unable to reset admin password. Please try again.");
		}
	}
}

else if(isset($_GET['UpdateAdmin']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$logged_admin = $_POST['logged_admin'];
	$admin = $_POST['admin'];
	$username = $_POST['username'];
	$rank = $_POST['rank'];
	
	if(empty($admin) || empty($logged_admin) || empty($username) || empty($rank))
	{
		echo errors("Please fill all details");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `omo_ogun` SET `username` = ?, `rank` = ? WHERE `admin_id` = ?");
			$query->bindparam(1,$username);
			$query->bindparam(2,$rank);
			$query->bindparam(3,$admin);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Admin details was successfully updated.");
				?>
					<script>
						var logged_admin = "<?php echo $logged_admin;?>";
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.post('display?DisplayAllAdmins', {current_page:current_page,per_page:per_page, admin:logged_admin}, function(msg)
						{
							$("#edit_admins").fadeOut();
							$("#display_admins").html(msg).fadeIn();
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to ban admin. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to ban admin. Please try again.");
		}
	}
}

else if(isset($_GET['BanAdmin']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$logged_admin = $_POST['logged_admin'];
	$admin = $_POST['admin'];
	
	if(empty($admin))
	{
		echo errors("Please select the admin");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `omo_ogun` SET `ban` = '1' WHERE `admin_id` = ?");
			$query->bindparam(1,$admin);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Admin was successfully banned.");
				?>
					<script>
						//window.location="admins";
						var logged_admin = "<?php echo $logged_admin;?>";
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.post('display?DisplayAllAdmins', {current_page:current_page,per_page:per_page, admin:logged_admin}, function(msg)
						{
							$("#display_admins").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to ban admin. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to ban admin. Please try again.");
		}
	}
}

else if(isset($_GET['UnBanAdmin']))
{
	$current_page = $_POST['current_page'];
	$per_page = $_POST['per_page'];
	$logged_admin = $_POST['logged_admin'];
	$admin = $_POST['admin'];
	
	if(empty($admin))
	{
		echo errors("Please select the admin");
	}
	else
	{
		try{
			$query = $db_handle->prepare("UPDATE `omo_ogun` SET `ban` = '0' WHERE `admin_id` = ?");
			$query->bindparam(1,$admin);
			$query->execute();
			$count = $query->rowCount();
			
			if($query->execute()){
				echo successes("Admin was successfully unbanned.");
				?>
					<script>
						//window.location="admins";
						var logged_admin = "<?php echo $logged_admin;?>";
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						
						$.post('display?DisplayAllAdmins', {current_page:current_page,per_page:per_page, admin:logged_admin}, function(msg)
						{
							$("#display_admins").html(msg);
						});
					</script>
				<?php
			}
			else{
				echo errors("An error occured. Unable to unban admin. Please try again.");
			}
		}
		catch(PDOException $error){
			echo errors("An error occured. Unable to unban admin. Please try again.");
		}
	}
}

?>
