<?php

require_once("idibo.php");

if(isset($_GET['PreviewVote']))
{
	$total = $_POST['total'];
	$student = $_POST['student'];
	$student_id = get_student_id($student);
    $key = $_POST['key'];
	$done =  false;
				
	?>

	<hr/><h4 align='center'>DEAR <b><?php echo $student;?></b>, THE PREVIEW OF THE ASPIRANTS YOU VOTED FOR ARE AS FOLLOW</h4>
	<p align='center'><i> Should you make any mistake, you can click on the <b>adjust button</b> below, else, click on the <b>submit button</b> to finalise your vote.</i></p>
	

	<script type='text/javascript'>

		$('#back').click(function()
		{
			$("#vote_area").show("fast");
			$("#preview_vote").hide("fast");
		});
		
		$('#back_to_vote').click(function()
		{
			$("#vote_area").show("fast");
			$("#preview_vote").hide("fast");
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
					url: "confirm?SubmitVote",
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
	</div>  <br/> <br/>

	<?php

	for($i=1;$i<=$total;$i++) 
	{
		$post = "post_id$i";
		$aspirant = "aspirant$i";
		$post_id = $_POST[$post];
		
		if(isset($_POST[$aspirant]))
		{
			$aspirant_id = $_POST[$aspirant];
			
			if($aspirant_id !== "none")
			{
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

else if(isset($_GET['SubmitVote']))
{
	$total = $_POST['total'];
	$student = $_POST['student'];
	$student_id = get_student_id($student);
    $key = $_POST['key'];
	$done =  false;
	$voted_on = date("Y-m-d H:i:s");

	for($i=1;$i<=$total;$i++) 
	{
		$post = "post_id$i";
		$aspirant = "aspirant$i";
		$post_id = $_POST[$post];
		
		if(isset($_POST[$aspirant]))
		{
			$aspirant_id = $_POST[$aspirant];
			$count_votes = count_aspirant_votes($aspirant_id);	
			$new_vote = $count_votes+1;
			
			try{
				
				$query = $db_handle->prepare("UPDATE `aspirants` SET `votes`= ? WHERE `aspirant_id` = ?");
				$query->bindparam(1,$new_vote);
				$query->bindparam(2,$aspirant_id);
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
?>