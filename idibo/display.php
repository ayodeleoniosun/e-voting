<?php
	
	require_once("../idibo.php");
	require_once("../image.php");

	if(isset($_GET["StudentProfile"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$student_id = $_POST['student'];
		$coming = $_POST['coming'];

		if(empty($student_id))
		{
			if($coming == "voter")
			{
				echo error_admin_msg("Please select the voter");
			}
			else if($coming == "aspirant")
			{
				echo error_admin_msg("Please select the aspirant");
			}
		}
		else
		{
			if($coming == "aspirant")
			{
				list($fullname,$matric,$unique_id,$post_id,$nickname,$dept_id,$level,$votes,$path) = get_aspirant_details($student_id);
					
				$qualified = is_aspirant_qualified($student_id);
				$dept_name = get_dept_name($dept_id);
				$post_name = get_post_name($post_id);
		
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to contest </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to contest </i>";
				}
				
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

				<script type="text/javascript">
				
					$("#back_to_all_aspirants").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllAspirants', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_aspirants").fadeOut(200);
							$("#display_aspirants").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_aspirants" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>

				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Aspiring for </td>
										<td class="center"></td>
										<td class="center"><b><?php echo $post_name;?></b></td>
									</tr>
									
									<tr>
										<td>Nick name</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $nickname;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>

			<?php
			}
			else if($coming == "voter")
			{
				list($surname,$firstname,$othername,$matric,$phone,$email,$dept_id,$level) = get_voter_details($student_id);
				$fullname = get_student_fullname($student_id);
				$qualified = is_voter_qualified($student_id);
				$dept_name = get_dept_name($dept_id);
		
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </i>";
				}
				
				$folder = "../images/";
				$full_path = $folder."default.png"; 

				?>
				
				<script type="text/javascript">
				
					$("#back_to_all_voters").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllVoters', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_voters").fadeOut(200);
							$("#display_voters").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_voters" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>
					
				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Matric number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $matric;?></b></td>
									</tr>
									
									<tr>
										<td>Phone number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $phone;?></b></td>
									</tr>
									
									<tr>
										<td>Email address</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $email;?></b></td>
									</tr>
									
									<tr>
										<td>Course</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $level;?>L/<?php echo $dept_name;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>
				<?php
			}
		}
	}

	else if(isset($_GET["RepProfile"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$rep_id = $_POST['rep'];
		$coming = $_POST['coming'];

		if(empty($rep_id))
		{
			echo error_admin_msg("Please select the floor rep");
		}
		else
		{
			if($coming == "rep")
			{
				list($fullname,$unique_id,$nickname,$constituency,$votes,$path) = get_floor_rep_details($rep_id);
					
				$qualified = is_rep_qualified($rep_id);
				
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to contest </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to contest </i>";
				}
				
				if($path == "")
				{
					$folder = "../images/";
					$full_path = $folder."default.png"; 
				}
				else
				{
					$full_path = "../floor-reps/".$path;
				}
				?>

				<script type="text/javascript">
				
					$("#back_to_all_reps").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllFloorReps', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_reps").fadeOut(200);
							$("#display_reps").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_reps" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>

				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Constituency</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $constituency;?></b></td>
									</tr>
									
									<tr>
										<td>Nick name</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $nickname;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>

			<?php
			}
		}
	}

	if(isset($_GET["SearchStudentProfile"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$student_id = $_POST['student'];
		$coming = $_POST['coming'];

		if(empty($student_id))
		{
			if($coming == "voter")
			{
				echo error_admin_msg("Please select the voter");
			}
			else if($coming == "aspirant")
			{
				echo error_admin_msg("Please select the aspirant");
			}
		}
		else
		{
			if($coming == "aspirant")
			{
				$search_aspirant = $_POST['search_aspirant'];

				list($fullname,$matric,$unique_id,$post_id,$nickname,$dept_id,$level,$votes,$path) = get_aspirant_details($student_id);
					
				$qualified = is_aspirant_qualified($student_id);
				$dept_name = get_dept_name($dept_id);
				$post_name = get_post_name($post_id);
		
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to contest </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to contest </i>";
				}
				
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

				<script type="text/javascript">
				
					$("#back_to_all_search_aspirants").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						var search_aspirant = "<?php echo $search_aspirant;?>";
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllSearchedAspirants', {per_page: per_page, current_page: current_page,aspirant:search_aspirant}, function(msg)
						{
							$("#display_modify_search_aspirants").fadeOut(200);
							$("#display_search_aspirants").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_search_aspirants" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>

				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Aspiring for </td>
										<td class="center"></td>
										<td class="center"><b><?php echo $post_name;?></b></td>
									</tr>
									
									<tr>
										<td>Nick name</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $nickname;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>

			<?php
			}
			else if($coming == "voter")
			{
				list($surname,$firstname,$othername,$matric,$phone,$email,$dept_id,$level) = get_voter_details($student_id);
				$fullname = get_student_fullname($student_id);
				$qualified = is_voter_qualified($student_id);
				$dept_name = get_dept_name($dept_id);
		
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </i>";
				}
				
				$folder = "../images/";
				$full_path = $folder."default.png"; 

				?>
				
				<script type="text/javascript">
				
					$("#back_to_all_voters").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllVoters', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_voters").fadeOut(200);
							$("#display_voters").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_voters" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>
					
				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Matric number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $matric;?></b></td>
									</tr>
									
									<tr>
										<td>Phone number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $phone;?></b></td>
									</tr>
									
									<tr>
										<td>Email address</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $email;?></b></td>
									</tr>
									
									<tr>
										<td>Course</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $level;?>L/<?php echo $dept_name;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>
				<?php
			}
		}
	}

	else if(isset($_GET["OldStudentProfile"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$student_id = $_POST['student'];
		$coming = $_POST['coming'];

		if(empty($student_id))
		{
			if($coming == "voter")
			{
				echo error_admin_msg("Please select the voter");
			}
			else if($coming == "aspirant")
			{
				echo error_admin_msg("Please select the aspirant");
			}
		}
		else
		{
			if($coming == "aspirant")
			{
				$get_student_id = get_student_id_from_aspirant($student_id);
				list($unique_id,$post_id,$nickname,$matric,$phone,$email,$dept_id,$level,$path) = get_aspirant_details($student_id);
					
				$fullname = get_student_fullname($get_student_id);
				$qualified = is_aspirant_qualified($student_id);
				$dept_name = get_dept_name($dept_id);
				$post_name = get_post_name($post_id);
		
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to contest </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to contest </i>";
				}
				
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

				<script type="text/javascript">
				
					$("#back_to_all_aspirants").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllAspirants', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_aspirants").fadeOut(200);
							$("#display_aspirants").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_aspirants" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>

				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Aspiring for </td>
										<td class="center"></td>
										<td class="center"><b><?php echo $post_name;?></b></td>
									</tr>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Nick name</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $nickname;?></b></td>
									</tr>
									
									<tr>
										<td>Matric number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $matric;?></b></td>
									</tr>
									
									<tr>
										<td>Phone number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $phone;?></b></td>
									</tr>
									
									<tr>
										<td>Email address</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $email;?></b></td>
									</tr>
									
									<tr>
										<td>Course</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $level;?>L/<?php echo $dept_name;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>

			<?php
			}
			else if($coming == "voter")
			{
				list($surname,$firstname,$othername,$matric,$phone,$email,$dept_id,$level) = get_voter_details($student_id);
				$fullname = get_student_fullname($student_id);
				$qualified = is_voter_qualified($student_id);
				$dept_name = get_dept_name($dept_id);
		
				if($qualified) {
					$qualified_status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </i>";
				}
				else {
					$qualified_status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </i>";
				}
				
				$folder = "../images/";
				$full_path = $folder."default.png"; 

				?>
				
				<script type="text/javascript">
				
					$("#back_to_all_voters").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						var ajax_status = $("#ajax_status");
						ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post('display?DisplayAllVoters', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_voters").fadeOut(200);
							$("#display_voters").html(msg).fadeIn(200);
						});
					});
				</script>

				<h2 align="center"> 
					<button id="back_to_all_voters" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<h3 align="center"> <span class="fa fa-user"></span> <?php echo strtoupper($fullname);?>'S PROFILE </h3> <hr/>
				</h2>
					
				<div class="col-md-12 col-sm-12">
							
						<div class="col-md-4 col-sm-4">
									
							<div class="text-center">
							
							<div class="fileupload fileupload-new" data-provides="fileupload">
                                <div class="fileupload-new thumbnail"><img src="<?php echo $full_path;?>" alt="<?php echo $fullname;?>" style="max-width: 500px; max-height: 150px; line-height: 20px;"/></div>
                                </div>
                            
							</div>

							
						</div>
						
						<div class="col-md-1 col-sm-1"></div>
						
						<div class="col-md-7 col-sm-7">
							
							<table class="table">
											
								<tbody>
									
									<tr>
										<td>Fullname</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $fullname;?></b></td>
									</tr>
									
									<tr>
										<td>Matric number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $matric;?></b></td>
									</tr>
									
									<tr>
										<td>Phone number</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $phone;?></b></td>
									</tr>
									
									<tr>
										<td>Email address</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $email;?></b></td>
									</tr>
									
									<tr>
										<td>Course</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $level;?>L/<?php echo $dept_name;?></b></td>
									</tr>
									
									<tr>
										<td>Eligibility status</td>
										<td class="center"></td>
										<td class="center"><b><?php echo $qualified_status;?></b></td>
									</tr>
									
								</tbody>
								
							 </table>  
							
						</div>
								
					<hr/>

				</div>
				<?php
			}
		}
	}

	else if(isset($_GET["EditPost"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$post = $_POST['post'];
			
		if(empty($post))
		{
			echo error_admin_msg("Please select the post");
		}
		else
		{
			$post_name = get_post_name($post);
			
			?>
				
				<script type="text/javascript">
				
					$("form#edit_post_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var post = "<?php echo $post;?>";
						var check_post = chk_text($("#post_name"));
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = $(this).serialize();
						
						if(check_post == 0)
						{
							support_ajax_status.html("<i class='icon-remove'></i> Please enter the post name").delay(2000).fadeOut("slow");
							$("#post_name").focus();
							return false;
						}
						else
						{
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									support_ajax_status.html("Updating post details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									support_ajax_status.html("").delay(2000).fadeOut("slow");
								}
							});
							
							$.ajax(
							{
								type:"POST",
								data:data,
								url:"../confirm?UpdatePost",
								cache:false,
								
								success:function(msg)
								{
									ajax_status.show();
									ajax_status.html(msg).delay(2000).fadeOut("slow");
								}
							});	
						}
					});
					
					$("#back_to_all_posts").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						$.post('display?DisplayAllPosts', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#edit_posts").fadeOut(200);
							$("#display_posts").html(msg).fadeIn(200);
						});
					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_posts" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="fa fa-pencil"></span> Edit <?php echo $post_name;?>'s details 
				</h2>
				
				<form id="edit_post_form" action="" method="post">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="post_id" value="<?php echo $post;?>"/>
					<input type="text" id="post_name" name="post_name" class="span12 form-control" value="<?php echo $post_name;?>"/>
					<br/>
					<div class="col-sm-12" align="center">
						<button type="submit" class="btn btn-success">
						<i class="icon-ok"></i> Save changes </button>
					</div>

				</form>
			<?php
		}
	}
	
	else if(isset($_GET["EditConstituency"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$const = $_POST['const_id'];
			
		if(empty($const))
		{
			echo error_admin_msg("Please select the constituency");
		}
		else
		{
			try{
				
				$query  = $db_handle->prepare("SELECT *FROM `constituencies` WHERE `const_id` = ?");
				$query->bindparam(1,$const);
				$query->execute();
				$count = $query->rowCount();
				
				if($count > 0)
				{
					$fetch_consts = $query->fetchAll();
					
					foreach($fetch_consts as $row)
					{
						$name = $row['name'];
					?>
				
					<script type="text/javascript">
					
						$("form#edit_const_form").submit(function(e)
						{
							e.preventDefault();
							alert("data");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var const = "<?php echo $const;?>";
							var check_const = chk_text($("#const_name"));
							var support_ajax_status = $("#support_ajax_status");
							var ajax_status = $("#ajax_status");
							support_ajax_status.show();
							var data = $(this).serialize();
							if(check_const == 0)
							{
								support_ajax_status.html("<i class='icon-remove'></i> Please enter the constituency").delay(2000).fadeOut("slow");
								$("#const_name").focus();
								return false;
							}
							else
							{
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										support_ajax_status.html("Updating constituency details <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										support_ajax_status.html("").delay(2000).fadeOut("slow");
									}
								});
								
								$.ajax(
								{
									type:"POST",
									data:data,
									url:"../confirm?UpdateConstituency",
									cache:false,
									
									success:function(msg)
									{
										ajax_status.show();
										ajax_status.html(msg).delay(2000).fadeOut("slow");
									}
								});	
							}
						});
						
						$("#back_to_all_consts").click(function()
						{
							var per_page =  "<?php echo $per_page;?>";
							var current_page = "<?php echo $current_page;?>";
							alert(per_page);

							$.post('display?DisplayAllConstituencies', {per_page: per_page, current_page: current_page}, function(msg)
							{
								$("#edit_constituencies").fadeOut(200);
								$("#display_constituencies").html(msg).fadeIn(200);
							});
						});
						
						
					</script>

					<h2 align="center"> 
						<button id="back_to_all_consts" class="btn btn-sm btn-info">&laquo; Back </button><br/>
						<br/><span class="fa fa-pencil"></span> Edit <?php echo $name;?>'s details 
					</h2>
					
					<form id="edit_const_form" action="" method="post">
						<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
						<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
						<input type="hidden" name="const_id" value="<?php echo $const;?>"/>
						<input type="text" id="const_name" name="const_name" class="span12 form-control" value="<?php echo $name;?>"/>
						<br/>
						<div class="col-sm-12" align="center">
							<button type="submit" class="btn btn-success">
							<i class="icon-ok"></i> Save changes </button>
						</div>

					</form>
				<?php
					}
				}
			}
			catch(PDOException $error){
				echo errors("An error occured.");
			}
		}
	}

	else if(isset($_GET["EditVoter"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$voter_id = $_POST['voter'];
			
		if(empty($voter_id))
		{
			echo error_admin_msg("Please select the voter");
		}
		else
		{
			$matric = get_voter_matric($voter_id);
			$constituency = get_voter_constituency($voter_id);

			?>

				<script type="text/javascript">
				
					$("form#edit_voter_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = $(this).serialize();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Updating voter's details <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(2000).fadeOut("slow");
							}
						});
						
						$.ajax(
						{
							type:"POST",
							data:data,
							url:"../confirm?UpdateVoter",
							cache:false,
							
							success:function(msg)
							{
								ajax_status.show();
								ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});	
					});
					
					$("#back_to_all_another_voters").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						var data = "per_page="+per_page+"&current_page="+current_page;
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(2000).fadeOut("slow");
							}
						});

						$.ajax(
						{
							type: "POST",
							url: "display?DisplayAllVoters",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								$("#display_modify_voters").fadeOut(200);
								$("#display_voters").html(msg).fadeIn(200);
							}
						});

					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_another_voters" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="icon-pencil"></span> Edit matric number
				</h2> <hr/><br/>
				
				<form id="edit_voter_form" method="post">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="voter_id" value="<?php echo $voter_id;?>"/>

					<div class="col-md-6 col-sm-6">
						<label>Matric Number</label>
						<input type="text" id="matric" name="matric" class="form-control" value="<?php echo $matric;?>"  maxlength="6" onkeypress="return isNumberKey(event)"/>
						<br/>

						<div class="form-group">
							<label>Select constituency</label>
							<?php echo fetch_selected_constituencies($constituency);?>
						</div>

					<div style="clear:both"></div>
									
					<button type="submit" class="btn btn-success pull-left">
						<i class="icon-ok"></i> Save changes </button><br/><br/>
					
				</form>
			<?php
		}
	}
	
	else if(isset($_GET["AnotherEditVoter"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$voter_id = $_POST['voter'];
		$search_voter = $_POST['search_voter'];
			
		if(empty($voter_id))
		{
			echo error_admin_msg("Please select the voter");
		}
		else
		{
			$matric = get_voter_matric($voter_id);
			$constituency = get_voter_constituency($voter_id);

			?>

				<script type="text/javascript">
				
					$("form#another_edit_voter_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = $(this).serialize();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Updating voter's details <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(2000).fadeOut("slow");
							}
						});
						
						$.ajax(
						{
							type:"POST",
							data:data,
							url:"../confirm?AnotherUpdateVoter",
							cache:false,
							
							success:function(msg)
							{
								ajax_status.show();
								ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});	
					});
					
					$("#back_to_all_another_voterx").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						var search_voter = "<?php echo $search_voter;?>";
						var data = "per_page="+per_page+"&current_page="+current_page+"&voter="+search_voter;
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(2000).fadeOut("slow");
							}
						});

						$.ajax(
						{
							type: "POST",
							url: "display?DisplayAllSearchedVoters",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								$("#display_search_modify_voters").fadeOut(200);
								$("#display_search_voters").html(msg).fadeIn(200);
							}
						});

					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_another_voterx" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="icon-pencil"></span> Edit matric number
				</h2> <hr/><br/>
				
				<form id="another_edit_voter_form" method="post">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="voter_id" value="<?php echo $voter_id;?>"/>
					<input type="hidden" name="search_voter" value="<?php echo $search_voter;?>"/>

					<div class="col-md-6 col-sm-6">
						<label>Matric Number</label>
						<input type="text" id="matric" name="matric" class="form-control" value="<?php echo $matric;?>"/>
					
						<br/>

						<div class="form-group">
							<label>Select constituency</label>
							<?php echo fetch_selected_constituencies($constituency);?>
						</div>
					<div style="clear:both"></div>
									
					<button type="submit" class="btn btn-success pull-left">
						<i class="icon-ok"></i> Save changes </button><br/><br/>
					
				</form>
			<?php
		}
	}
	
	else if(isset($_GET["OldEditVoter"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$voter_id = $_POST['voter'];
			
		if(empty($voter_id))
		{
			echo error_admin_msg("Please select the voter");
		}
		else
		{
			list($surname,$firstname,$othername,$matric,$phone,$email,$dept_id,$level) = get_voter_details($voter_id);
			
			$fullname = get_student_fullname($voter_id);
	
			?>

				<script type="text/javascript">
				
					$("form#edit_voter_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = $(this).serialize();
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Updating voter's details <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(2000).fadeOut("slow");
							}
						});
						
						$.ajax(
						{
							type:"POST",
							data:data,
							url:"../confirm?UpdateVoter",
							cache:false,
							
							success:function(msg)
							{
								ajax_status.show();
								ajax_status.html(msg).delay(2000).fadeOut("slow");
							}
						});	
					});
					
					$("#back_to_all_voters").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						$.post('display?DisplayAllVoters', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_voters").fadeOut(200);
							$("#display_voters").html(msg).fadeIn(200);
						});
					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_voters" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="fa fa-pencil"></span> Edit <?php echo $fullname;?>'s details 
				</h2> <hr/><br/>
				
				<form id="edit_voter_form" method="post">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="voter_id" value="<?php echo $voter_id;?>"/>

					<div class="col-md-6 col-sm-6">
						<label>Surname</label>
						<input type="text" id="surname" name="surname" class="form-control" value="<?php echo $surname;?>"/>
					
						<br/>
					</div>	
						
					<div class="col-md-6 col-sm-6">
					
						<label>First name</label>
						<input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $firstname;?>"/>
					
						<br/>
					</div>


					<div class="col-md-6 col-sm-6">
						<label>Other name <i>(Optional)</i></label>
						<input type="text" id="othername" name="othername" class="form-control" value="<?php echo $othername;?>"/>
					
						<br/>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Matric Number</label>
						<input type="text" id="matric" name="matric" class="form-control" value="<?php echo $matric;?>"/>
					
						<br/>
					</div>
					
					<div class="col-md-6 col-sm-6">
						<label>Phone number  <i>(Optional)</i></label>
						<input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone;?>"/>
					
						<br/>
					</div>
					
					<div class="col-md-6 col-sm-6">
						<label>Email address  <i>(Optional)</i></label>
						<input type="email" id="email" name="email" class="form-control" value="<?php echo $email;?>"/>
				
						<br/>
					</div>
					
					<div class="col-md-6 col-sm-6">
						<label>Select deparment</label>
						<?php echo fetch_selected_depts($dept_id);?>
					</div>
					<div class="col-md-6 col-sm-6">
						<label>Select level</label>
						<select class="form-control" id="level" name="level">
							<option value="<?php echo $level;?>"> <?php echo $level;?>L </option>
								<?php
								for($k=100;$k<=1000;$k+=100)
								{
									if($k == $level) {}
									else
									{
										echo "<option value='$k'>".$k."L</option>";
									}
								}
								?>
						</select>	
					<br/><br/>
					
						<button type="submit" class="btn btn-success pull-right">
						<i class="icon-ok"></i> Save changes </button><br/><br/>
					
					</div>

				</form>
			<?php
		}
	}
	
	else if(isset($_GET["EditAspirant"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$aspirant_id = $_POST['aspirant'];
		$student_id = get_student_id_from_aspirant($aspirant_id);

		if(empty($aspirant_id))
		{
			echo error_admin_msg("Please select the aspirant");
		}
		else
		{
			list($fullname,$matric,$unique_id,$post_id,$nickname,$dept_id,$level,$votes,$path) = get_aspirant_details($aspirant_id);

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

				<script type="text/javascript">
				
					$("form#edit_aspirant_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = new FormData($(this)[0]);;
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Updating aspirant's details <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").hide("fast");
							}
						});
						
						$.ajax(
						{
							type:"POST",
							data:data,
							url:"../confirm?UpdateAspirant",
							cache:false,
							contentType: false,
           					processData: false,
				
							success:function(msg)
							{
								ajax_status.show();
								ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});	
					});
					
					$("#back_to_all_aspirants").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						$.post('display?DisplayAllAspirants', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_aspirants").fadeOut(200);
							$("#display_aspirants").html(msg).fadeIn(200);
						});
					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_aspirants" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="fa fa-pencil"></span> Edit <?php echo $fullname;?>'s details 
				</h2> <hr/><br/>
				
				<form id="edit_aspirant_form" method="post" enctype="multipart/form-data">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="aspirant_id" value="<?php echo $aspirant_id;?>"/>

					<div class="col-md-12 col-sm-12">
						<p><i><b> Ensure that a photo of 640px by 640px is uploaded, else the photo will be distorted. </b></i></p><br/>
                                
                            <div class="col-md-4 col-sm-4">
							    <label>Change aspirant picture</label>
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo $full_path;?>" alt=""/></div>
									<div>
										<br/><span class="btn btn-file btn-info"><span class="fileupload-new"><i class="icon-camera"></i>  Select aspirant's photo</span>
										<span class="fileupload-exists"><i class="icon-mail-forward"></i> Change</span>
										<input type="file" id="aspirant_photo" name="aspirant_photo" value="<?php echo $path;?>"/>
											</span>
										<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-remove"></i> Remove</a>
									</div>
								</div>
						</div>

						<div class="col-md-1 col-sm-1"></div>
	
						<div class="col-md-6 col-sm-6">
							
							<div class="form-group">
								<label>Fullname </label>
								<input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $fullname;?>"/>
							</div>
							
							<div class="form-group">
								<label>Nickname </label>
								<input type="text" id="nickname" name="nickname" class="form-control" value="<?php echo $nickname;?>"/>
							</div>
							
							<div class="form-group">
								<label>Select post</label>
								<?php echo fetch_selected_posts($post_id);?>
							</div>
							
						<br/>
						
						<div align="center">
							<button type="submit" class="btn btn-block btn-success"> <i class="icon-ok"></i> Save changes </button><br/><br/>
						</div>
					</div>
				</div>

			</form>
			<?php
		}
	}
	
	else if(isset($_GET["EditFloorRep"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$rep_id = $_POST['rep'];
		
		if(empty($rep_id))
		{
			echo error_admin_msg("Please select the aspirant");
		}
		else
		{
			list($fullname,$unique_id,$nickname,$constituency,$votes,$path) = get_floor_rep_details($rep_id);

			if($path == "")
			{
				$folder = "../images/";
				$full_path = $folder."default.png"; 
			}
			else
			{
				$full_path = "../floor-reps/".$path;
			}
			?>

				<script type="text/javascript">
				
					$("form#edit_rep_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = new FormData($(this)[0]);;
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Updating floor rep's details <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").hide("fast");
							}
						});
						
						$.ajax(
						{
							type:"POST",
							data:data,
							url:"../confirm?UpdateFloorRep",
							cache:false,
							contentType: false,
           					processData: false,
				
							success:function(msg)
							{
								ajax_status.show();
								ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});	
					});
					
					$("#back_to_all_reps").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						
						$.post('display?DisplayAllFloorReps', {per_page: per_page, current_page: current_page}, function(msg)
						{
							$("#display_modify_reps").fadeOut(200);
							$("#display_reps").html(msg).fadeIn(200);
						});
					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_reps" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="fa fa-pencil"></span> Edit <?php echo $fullname;?>'s details 
				</h2> <hr/><br/>
				
				<form id="edit_rep_form" method="post" enctype="multipart/form-data">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="rep_id" value="<?php echo $rep_id;?>"/>

					<div class="col-md-12 col-sm-12">
						<p><i><b> Ensure that a photo of 640px by 640px is uploaded, else the photo will be distorted. </b></i></p><br/>
                                
                            <div class="col-md-4 col-sm-4">
							    <label>Change floor rep picture</label>
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo $full_path;?>" alt=""/></div>
									<div>
										<br/><span class="btn btn-file btn-info"><span class="fileupload-new"><i class="icon-camera"></i>  Select floor rep's photo</span>
										<span class="fileupload-exists"><i class="icon-mail-forward"></i> Change</span>
										<input type="file" id="rep_photo" name="rep_photo" value="<?php echo $path;?>"/>
											</span>
										<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-remove"></i> Remove</a>
									</div>
								</div>
						</div>

						<div class="col-md-1 col-sm-1"></div>
	
						<div class="col-md-6 col-sm-6">
							
							<div class="form-group">
								<label>Select constituency</label>
								<?php echo fetch_selected_constituencies($constituency);?>
							</div>

							<div class="form-group">
								<label>Fullname </label>
								<input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $fullname;?>"/>
							</div>
							
							<div class="form-group">
								<label>Nickname </label>
								<input type="text" id="nickname" name="nickname" class="form-control" value="<?php echo $nickname;?>"/>
							</div>
							
						<br/>
						
						<div align="center">
							<button type="submit" class="btn btn-block btn-success"> <i class="icon-ok"></i> Save changes </button><br/><br/>
						</div>
					</div>
				</div>

			</form>
			<?php
		}
	}
	
	else if(isset($_GET["SearchEditAspirant"]))
	{
		$current_page = $_POST['current_page'];
		$per_page = $_POST['per_page'];
		$aspirant_id = $_POST['aspirant'];
		$student_id = get_student_id_from_aspirant($aspirant_id);
		$search_aspirant = $_POST['search_aspirant'];
		
		if(empty($aspirant_id))
		{
			echo error_admin_msg("Please select the aspirant");
		}
		else
		{
			list($fullname,$matric,$unique_id,$post_id,$nickname,$dept_id,$level,$votes,$path) = get_aspirant_details($aspirant_id);

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

				<script type="text/javascript">
				
					$("form#search_edit_aspirant_form").submit(function(e)
					{
						e.preventDefault();
						var current_page = "<?php echo $current_page;?>";
						var per_page = "<?php echo $per_page;?>";
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						support_ajax_status.show();
						var data = new FormData($(this)[0]);;
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Updating aspirant's details <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").hide("fast");
							}
						});
						
						$.ajax(
						{
							type:"POST",
							data:data,
							url:"../confirm?SearchUpdateAspirant",
							cache:false,
							contentType: false,
           					processData: false,
				
							success:function(msg)
							{
								ajax_status.show();
								ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});	
					});
					
					$("#back_to_all_search_aspirants").click(function()
					{
						var per_page =  "<?php echo $per_page;?>";
						var current_page = "<?php echo $current_page;?>";
						var search_aspirant = "<?php echo $search_aspirant;?>";

						$.post('display?DisplayAllSearchedAspirants', {per_page: per_page, current_page: current_page,aspirant:search_aspirant}, function(msg)
						{
							$("#display_modify_search_aspirants").fadeOut(200);
							$("#display_search_aspirants").html(msg).fadeIn(200);
						});
					});
					
					
				</script>

				<h2 align="center"> 
					<button id="back_to_all_search_aspirants" class="btn btn-sm btn-info">&laquo; Back </button><br/>
					<br/><span class="fa fa-pencil"></span> Edit <?php echo $fullname;?>'s details 
				</h2> <hr/><br/>
				
				<form id="search_edit_aspirant_form" method="post" enctype="multipart/form-data">
					<input type="hidden" name="current_page" value="<?php echo $current_page;?>"/>
					<input type="hidden" name="per_page" value="<?php echo $per_page;?>"/>
					<input type="hidden" name="aspirant_id" value="<?php echo $aspirant_id;?>"/>
					<input type="hidden" name="search_aspirant" value="<?php echo $search_aspirant;?>"/>

					<div class="col-md-12 col-sm-12">
						<p><i><b> Ensure that a photo of 200px by 200px is uploaded, else the photo will be distorted. </b></i></p><br/>
                                
                            <div class="col-md-4 col-sm-4">
							    <label>Change aspirant picture</label>
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"><img src="<?php echo $full_path;?>" alt=""/></div>
									<div>
										<br/><span class="btn btn-file btn-info"><span class="fileupload-new"><i class="icon-camera"></i>  Select aspirant's photo</span>
										<span class="fileupload-exists"><i class="icon-mail-forward"></i> Change</span>
										<input type="file" id="aspirant_photo" name="aspirant_photo" value="<?php echo $path;?>"/>
											</span>
										<a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="icon-remove"></i> Remove</a>
									</div>
								</div>
						</div>

						<div class="col-md-1 col-sm-1"></div>
	
						<div class="col-md-6 col-sm-6">
							
							<div class="form-group">
								<label>Fullname </label>
								<input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo $fullname;?>"/>
							</div>
							
							<div class="form-group">
								<label>Nickname  </label>
								<input type="text" id="nickname" name="nickname" class="form-control" value="<?php echo $nickname;?>"/>
							</div>
							
							<div class="form-group">
								<label>Select post</label>
								<?php echo fetch_selected_posts($post_id);?>
							</div>
							
						<br/>
						
						<div align="center">
							<button type="submit" class="btn btn-block btn-success"> <i class="icon-ok"></i> Save changes </button><br/><br/>
						</div>
					</div>
				</div>

			</form>
			<?php
		}
	}
	
	else if(isset($_GET["DisplayAllPosts"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
					var support_ajax_status = $("#support_ajax_status");
					
					$('.first_posts').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var first_page_num = Number($(this).attr('id'));
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post("display?DisplayAllPosts",{current_page:first_page_num, per_page:per_page},function(msg)
						{
							$("#display_posts").html(msg).fadeIn(1000);
						});
					});
					
					$('.last_posts').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var last_page_num = Number($(this).attr('id'));
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post("display?DisplayAllPosts",{current_page:last_page_num, per_page:per_page},function(msg)
						{
							$("#display_posts").html(msg).fadeIn(1000);
						});
					});
					
					$('.next_posts').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var current_page_num = Number($(this).attr('id'));
						var next_page_num = current_page_num+1;
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post("display?DisplayAllPosts",{current_page:next_page_num, per_page:per_page},function(msg)
						{
							$("#display_posts").html(msg).fadeIn(1000);
						});
					});
					
					$('.prev_posts').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var prev_page_num = Number($(this).attr('id'));
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.post("display?DisplayAllPosts",{current_page:prev_page_num, per_page:per_page},function(msg)
						{
							$("#display_posts").html(msg).fadeIn(1000);
						});
					});
				
			</script>
		
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `posts` ORDER BY `post_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$post_query  = $db_handle->prepare("SELECT *FROM `posts` ORDER BY `post_id` DESC LIMIT $offset,$per_page");
		$post_query->execute();
		$count_posts = $post_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_posts == 0)
		{
			echo error_admin_msg("No posts yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_posts'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_posts'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_posts'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_posts'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_posts'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_posts'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_posts'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_posts'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<div class="col-md-12 col-sm-12">
					<h3 align="center"><i class="icon-user"></i> All Posts <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div><br/>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
							<th>S/N</th>
							<th>Post</th>
							<th>Aspirants</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_posts = $post_query->fetchAll();
				$i = 0;
				
				foreach($fetch_posts as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$post_id = $row['post_id'];
					$name = $row['post'];
					$count_aspirants = count_post_aspirants($post_id);
				?>
					
					<script type='text/javascript'>
						
						$("#delete_post<?php echo $post_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this post?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var post_id ="<?php echo $post_id;?>";
								var data = "post="+post_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting post <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeletePost",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_post<?php echo $post_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_posts").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var post_id ="<?php echo $post_id;?>";
							var data = "post="+post_id+"&current_page="+current_page+"&per_page="+per_page;
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving post details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditPost",
								cache:false,
								
								success: function(msg)
								{
									$("#display_posts").fadeOut(200);
									$("#edit_posts").html(msg);
									$("#edit_posts").fadeIn(500);
								}
							});
						});

						$("#view_post_aspirants<?php echo $post_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_posts").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var post_id ="<?php echo $post_id;?>";
							var post_name ="<?php echo $name;?>";
							var data = "post="+post_id+"&current_page="+current_page+"&per_page="+per_page;
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving aspirants for the post of "+post_name+" <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?DisplayPostAspirants",
								cache:false,
								
								success: function(msg)
								{
									$("#display_posts").fadeOut(200);
									$("#display_posts_aspirants").fadeIn(200).html(msg);
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $name;?></td>
						<?php

						if($count_aspirants > 0)
						{
							/*?>
							<!--<td><a href='#' id='view_post_aspirants<?php echo $post_id;?>' class='text-info'><b><?php echo $count_aspirants;?></b></a></td>
							<?php
							*/
							?>
							<td><?php echo $count_aspirants;?></td> 
							<?php
						}
						else 
						{
							?>
							<td><?php echo $count_aspirants;?></td>
							<?php
						}
						?>
						
						<td>
							<a href='#' id='edit_post<?php echo $post_id;?>' class='text-success'><i class='icon-pencil'></i> Edit </a> &nbsp; &nbsp;
							<a href='#' id='delete_post<?php echo $post_id;?>' class='text-danger'><i class='icon-remove'></i> Delete </button>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	else if(isset($_GET["DisplayAllVoters"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.prev_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
			
		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `voters_id` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$voters_query  = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `voters_id` ASC LIMIT $offset,$per_page");
		$voters_query->execute();
		$count_voters = $voters_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_voters == 0)
		{
			echo error_admin_msg("No voters yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$("form#search_voters").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?SearchVoter",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});

					$("#delete_all_voters").click(function()
					{
						var confirm = window.confirm("Are you sure you want to delete all voters?");
						
						if(confirm == false){
							return false;
						}								
						else {
							
							$("#support_ajax_status").show();
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Deleting all voters <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
								}
							});
							
							$.ajax(
							{
								type: "GET",
								url: "../confirm?ResetVoters",
								cache:false,
								
								success: function(msg)
								{
									$("#ajax_status").show();
									$("#ajax_status").html(msg).delay(2000).fadeOut("slow");
								}
							});
						}
					});
			
				</script>

				<div class="col-md-12 col-sm-12">
					
					<br/>
					<form id="search_voters" action="" method="post">
						<div class="input-group">
								
							<span class="input-group-addon"><span class="icon-user"></span></span>
									
							<input type="text" name="voter" id="voter" class="form-control" placeholder="Enter voter's matric number or constituency"/>

							<span class="input-group-btn">
								<button type="submit" class="btn btn-success pull-right"><i class="icon-search"></i> Search </button>
							</span>

						</div>
					</form>
				</div>
				<br/>

			<div align="right">
				<button onclick="Print('print_details')" class="btn btn-primary"><i class="fa fa-print"></i> Print Voters </button> 
			</div> <br/><br/>

			<div class="table-responsive" id="print_details">


				<table class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
                        
                        <tr>
							<th>S/N</th>
							<th>Matric</th>
							<th>Constituency</th>
							<th>Date voted</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voters = $voters_query->fetchAll();
				$i = 0;
				
				foreach($fetch_voters as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['voters_id'];
					$matric = $row['matric'];
					$constituency = $row['constituency'];
					$qualify = $row['qualify'];
					$voted = $row['voted'];
					$key_used = get_key_used($voter_id);
					$voted_date = $row['voted_on'];
					
					if($voted_date != "" || $voted_date != null) {
						$voted_on = format_date_time($voted_date);
					} else {
						$voted_on = "";
					}

					if( ($qualify == "1") && ($voted == "0") ) {
						$status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </span>";
						$do_acc = "<a href='#' id='disable_voter$voter_id' class='text-danger'> Disable </a> &nbsp; &nbsp;";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </span>";
						$do_acc = "<a href='#' id='enable_voter$voter_id' class='text-info'> Enable </a> &nbsp; &nbsp;";
					}
					else {
						$status = "<span class='text-text'><i class='icon-check'></i> Voted </span>";
						$do_acc = "";
					}

					if($voted == "0")
					{
						$vote_status = "<span class='text-danger'><i class='icon-remove'></i> Not yet voted.</span>";
					} else {
						$vote_status = "<span class='text-success'><b> $voted_on </b> <br/> PIN used - <b> $key_used</b></span>";
					}


				?>
					
					<script type='text/javascript'>
						
						$("#delete_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this voter's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disable this voter from voting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#enable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this voter to vote?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Enabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?EnableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving voter's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditVoter",
								cache:false,
								
								success: function(msg)
								{
									$("#display_voters").fadeOut(200);
									$("#display_modify_voters").html(msg);
									$("#display_modify_voters").fadeIn(500);
								}
							});
						});

						$("#view_voter_profile<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "student="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=voter";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?StudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_voters").fadeOut();
									$("#display_modify_voters").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $constituency;?></td>
						<td><?php echo $vote_status;?></td>
						<td><?php echo $status;?></td>
						<td>
							<?php echo $do_acc;

							if($voted == "0") {
							?>
								<a href='#' id='edit_voter<?php echo $voter_id;?>' class='text-success'> Edit </a> &nbsp; &nbsp;
								<a href='#' id='delete_voter<?php echo $voter_id;?>' class='text-danger'> Delete </a>
							<?php
							}
							?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}

	else if(isset($_GET["DisplayAllVotersxxx"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.prev_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoters",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
			
		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `voters_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$voters_query  = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `voters_id` DESC LIMIT $offset,$per_page");
		$voters_query->execute();
		$count_voters = $voters_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_voters == 0)
		{
			echo error_admin_msg("No voters yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$("form#search_voters").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?SearchVoter",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});

					$("#delete_all_voters").click(function()
					{
						var confirm = window.confirm("Are you sure you want to delete all voters?");
						
						if(confirm == false){
							return false;
						}								
						else {
							
							$("#support_ajax_status").show();
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Deleting all voters <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
								}
							});
							
							$.ajax(
							{
								type: "GET",
								url: "../confirm?ResetVoters",
								cache:false,
								
								success: function(msg)
								{
									$("#ajax_status").show();
									$("#ajax_status").html(msg).delay(2000).fadeOut("slow");
								}
							});
						}
					});
			
				</script>

				<div class="col-md-12 col-sm-12">
					
					<br/>
					<form id="search_voters" action="" method="post">
						<div class="input-group">
								
							<span class="input-group-addon"><span class="icon-user"></span></span>
									
							<input type="text" name="voter" id="voter" class="form-control" placeholder="Enter voter's matric number or constituency"/>

							<span class="input-group-btn">
								<button type="submit" class="btn btn-success pull-right"><i class="icon-search"></i> Search </button>
							</span>

						</div>
					</form>
				</div>
				<br/>

			<div align="right">
				<button onclick="Print('print_details')" class="btn btn-primary"><i class="fa fa-print"></i> Print Voters </button> 
			</div> <br/><br/>

			<div class="table-responsive" id="print_details">

				<table class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
                        
                        <tr>
							<th>S/N</th>
							<th>Matric</th>
							<th>Constituency</th>
							<th>Date voted</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voters = $voters_query->fetchAll();
				$i = 0;
				
				foreach($fetch_voters as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['voters_id'];
					$matric = $row['matric'];
					$constituency = $row['constituency'];
					$qualify = $row['qualify'];
					$voted = $row['voted'];
					$key_used = get_key_used($voter_id);
					$voted_date = $row['voted_on'];
					
					if($voted_date != "" || $voted_date != null) {
						$voted_on = format_date_time($voted_date);
					} else {
						$voted_on = "";
					}

					if( ($qualify == "1") && ($voted == "0") ) {
						$status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </span>";
						$do_acc = "<a href='#' id='disable_voter$voter_id' class='text-danger'> Disable </a> &nbsp; &nbsp;";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </span>";
						$do_acc = "<a href='#' id='enable_voter$voter_id' class='text-info'> Enable </a> &nbsp; &nbsp;";
					}
					else {
						$status = "<span class='text-text'><i class='icon-check'></i> Voted </span>";
						$do_acc = "";
					}

					if($voted == "0")
					{
						$vote_status = "<span class='text-danger'><i class='icon-remove'></i> Not yet voted.</span>";
					} else {
						$vote_status = "<span class='text-success'><b> $voted_on </b> <br/> Key used - <b> $key_used</b></span>";
					}


				?>
					
					<script type='text/javascript'>
						
						$("#delete_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this voter's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disable this voter from voting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#enable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this voter to vote?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Enabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?EnableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving voter's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditVoter",
								cache:false,
								
								success: function(msg)
								{
									$("#display_voters").fadeOut(200);
									$("#display_modify_voters").html(msg);
									$("#display_modify_voters").fadeIn(500);
								}
							});
						});

						$("#view_voter_profile<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "student="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=voter";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?StudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_voters").fadeOut();
									$("#display_modify_voters").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $constituency;?></td>
						<td><?php echo $vote_status;?></td>
						<td><?php echo $status;?></td>
						<td>
							<?php echo $do_acc;

							if($voted == "0") {
							?>
								<a href='#' id='edit_voter<?php echo $voter_id;?>' class='text-success'> Edit </a> &nbsp; &nbsp;
								<a href='#' id='delete_voter<?php echo $voter_id;?>' class='text-danger'> Delete </a>
							<?php
							}
							?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	else if(isset($_GET["DisplayAllAccreditedVoters"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
				$(document).ready(function(){
			    	$('#table_id').DataTable({
						dom: 'Bfrtip',
						'iDisplayLength': 100,
						// buttons: [
						// 	'copy', 'csv', 'excel', 'pdf', 'print'
						// ]
						buttons: {
							buttons: [
								{
									extend:'excel',
									text: 'Export to excel',
									className: 'btn btn-info'
								},

								{
									extend:'print',
									text: 'Print',
									className: 'btn btn-info'
								}
							]
						}
					});
			    });

		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `accredited` ORDER BY `accredit_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_rows == 0)
		{
			echo error_admin_msg("No accredited voters yet.");
		}
		else
		{
			?>
						
				<div class="col-md-12 col-sm-12">
					
					<!-- <br/>
					<button id="delete_all_voters" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all voters </button> 
					<br/> -->
				</div>
					
				<div class="table-responsive">
								
				<table id="table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
                        
                        <tr>
							<th>S/N</th>
							<th>Matric</th>
							<th>PIN</th>
							<th>Accredited on</th>
							<th>Voted on</th>
							<th>Eligibility</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voters = $query->fetchAll();
				$i = 0;
				
				foreach($fetch_voters as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['accredit_id'];
					$matric = $row['matric'];
					$pin = $row['pin'];
					$accredited_on = $row['accredited_on'];
					$qualify = is_voter_qualified($matric);
					$voted = is_voter_voted($matric);

					if($accredited_on != "" || $accredited_on != null) {
						$accredited_on = format_date_time($accredited_on);
					} else {
						$accredited_on = "";
					}

					if( ($qualify == "1") && ($voted == "0") ) {
						$status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </span>";
						$do_acc = "<a href='#' id='disable_voter$voter_id' class='text-danger'> Disable </a> &nbsp; &nbsp;";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </span>";
						$do_acc = "<a href='#' id='enable_voter$voter_id' class='text-info'> Enable </a> &nbsp; &nbsp;";
					}
					else {
						$status = "<span class='text-text'><i class='icon-check'></i> Voted </span>";
						$do_acc = "";
					}

					if($voted == "0")
					{
						$vote_status = "<span class='text-danger'><i class='icon-remove'></i> Not yet voted.</span>";
					} else {
						$voted_on = voter_voted_on($matric);
						$voted_on = format_date_time($voted_on);
						$key_used = voter_key_used($matric);
						$vote_status = "<span class='text-success'><b> $voted_on </b> <br/> Key used - <b> $key_used</b></span>";
					}


				?>
					
					<script type='text/javascript'>
						
						$("#delete_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this accredited voter?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteAccreditedVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $pin;?></td>
						<td><?php echo $accredited_on;?></td>
						<td><?php echo $vote_status;?></td>
						<td><?php echo $status;?></td>
						<td>
							<?php

							if($voted == "0") {
							?>
								<a href='#' id='delete_voter<?php echo $voter_id;?>' class='text-danger'> Delete </a>
							<?php
							}
							?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<!-- <div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/> -->
			<?php
		}
	}
	
	
	else if(isset($_GET["DisplayAllVoted"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
				$(document).ready(function(){
			    	$('#the_table_id').DataTable({
						dom: 'Bfrtip',
						'iDisplayLength': 100,
						// buttons: [
						// 	'copy', 'csv', 'excel', 'pdf', 'print'
						// ]
						buttons: {
							buttons: [
								{
									extend:'excel',
									text: 'Export to excel',
									className: 'btn btn-info'
								},

								{
									extend:'print',
									text: 'Print',
									className: 'btn btn-info'
								}
							]
						}
					});
			    });

				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_voted').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoted",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_voted").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_voted').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoted",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_voted").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_voted').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoted",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_voted").html(msg).fadeIn(1000);
					});
				});
				
				$('.prev_voted').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVoted",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_voted").html(msg).fadeIn(1000);
					});
				});
			
		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `voters` WHERE `voted` = '1' ORDER BY `voters_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$voters_query  = $db_handle->prepare("SELECT *FROM `voters` WHERE `voted` = '1' ORDER BY `voters_id` DESC LIMIT $offset,$per_page");
		$voters_query->execute();
		$count_voters = $voters_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_voters == 0)
		{
			echo error_admin_msg("No voted yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voted'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voted'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voted'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voted'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voted'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voted'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voted'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voted'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$("form#search_voted").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?SearchVoted",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});
				</script>

				<div class="col-md-12 col-sm-12">
					<h3 align="center"><i class="icon-user"></i> All Voted <span class="badge"> <?php echo $count_rows;?> </span> </h3><hr/>
				</div>
				<br/>
					
				<div class="table-responsive">
								
				<table id="the_table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
                        
                        <tr>
							<th>S/N</th>
							<th>Matric</th>
							<th>Date voted</th>
							<th>Voting key</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voted = $voters_query->fetchAll();
				$i = 0;
				
				foreach($fetch_voted as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['voters_id'];
					$matric = $row['matric'];
					$qualify = $row['qualify'];
					$voted = $row['voted'];
					$key_used = get_key_used($voter_id);
					$voted_date = $row['voted_on'];
					
					if($voted_date !== "") 
					{
						$voted_on = format_date_time($voted_date);
					}
					else
					{
						$voted_on = "";
					}

					if($voted == "0") 
					{
						$key_status = "";
					} else {
						$key_status = "<span class='text-success'> $key_used</b></span>";
					}


				?>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $voted_on;?></td>
						<td><?php echo $key_status;?></td>
						
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	
	else if(isset($_GET["DisplayAllSearchedVoters"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		$voter = $_POST['voter'];

		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				var ajax_status = $("#ajax_status");
				var voter = "<?php echo $voter;?>";

				$('.first_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoters",{current_page:first_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoters",{current_page:last_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voters").html(msg).fadeIn(1000);
					});
	
				});
				
				$('.next_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoters",{current_page:next_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voters").html(msg).fadeIn(1000);
					});
	
				});
				
				$('.prev_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoters",{current_page:prev_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voters").html(msg).fadeIn(1000);
					});
				});
			
				$("#back_to_all_voters").click(function()
				{
					var per_page = "<?php echo $per_page;?>";
					var current_page = "<?php echo $current_page;?>";
					
					ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post('display?DisplayAllVoters', {per_page: per_page, current_page: current_page}, function(msg)
					{
						$("#display_search_voters").hide("fast");
						$("#display_voters").show("fast");
						$("#display_voters").html(msg);
					});
				});
			
			</script>
	
			<br/>
			<div align="center">
				<button id="back_to_all_voters" class="btn btn-sm btn-info">&laquo; Back to all voters </button>
			</div>

			<br/>

		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query = $db_handle->prepare("SELECT *FROM `voters` WHERE `matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? ORDER BY `matric`");
		
		$query->bindvalue(1,'%'.$voter.'%');
		$query->bindvalue(2,$voter.'%');
		$query->bindvalue(3,'%'.$voter);
		$query->bindvalue(4,'%'.$voter.'%');
		$query->bindvalue(5,$voter.'%');
		$query->bindvalue(6,'%'.$voter);
		$query->execute();
		$count_rows = $query->rowCount();

		$voters_query = $db_handle->prepare("SELECT *FROM `voters` WHERE `matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? OR `constituency` LIKE ? ORDER BY `matric` LIMIT $offset,$per_page");
		
		$voters_query->bindvalue(1,'%'.$voter.'%');
		$voters_query->bindvalue(2,$voter.'%');
		$voters_query->bindvalue(3,'%'.$voter);
		$voters_query->bindvalue(4,'%'.$voter.'%');
		$voters_query->bindvalue(5,$voter.'%');
		$voters_query->bindvalue(6,'%'.$voter);
		$voters_query->execute();
		$count_voters = $voters_query->rowCount();

		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_voters == 0)
		{
			echo error_admin_msg("No voters yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$("form#another_search_voters").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?AnotherSearchVoter",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});
				</script>

				<div class="col-md-12 col-sm-12">
					
					<br/>
					<form id="another_search_voters" action="" method="post">
						<div class="input-group">
								
							<span class="input-group-addon"><span class="icon-user"></span></span>
									
							<input type="text" name="another_voter" id="another_voter" class="form-control" placeholder="Enter voter's matric number or constituency"/>

							<span class="input-group-btn">
								<button type="submit" class="btn btn-success pull-right"><i class="icon-search"></i> Search </button>
							</span>

						</div>
					</form>
				</div>

				<div class="col-md-12 col-sm-12">
					<br/><h3 align="center"><i class="icon-user"></i> Search result for <?php echo $voter;?> <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered" style="width:100%;">
        
			        <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
			            
			            <tr>
							<th>S/N</th>
							<th>Matric</th>
							<th>Constituency</th>
							<th>Date voted</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voters = $voters_query->fetchAll();
				$i = 0;
				
				foreach($fetch_voters as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['voters_id'];
					$matric = $row['matric'];
					$constituency = $row['constituency'];
					$qualify = $row['qualify'];
					$voted = $row['voted'];
					$key_used = get_key_used($voter_id);
					$voted_date = $row['voted_on'];
					
					if($voted_date != "" || $voted_date != null) {
						$voted_on = format_date_time($voted_date);
					} else {
						$voted_on = "";
					}

					if( ($qualify == "1") && ($voted == "0") ) {
						$status = "<span class='text-success'><i class='icon-check'></i> Eligible to vote </span>";
						$do_acc = "<a href='#' id='disable_voter$voter_id' class='text-danger'> Disable </a> &nbsp; &nbsp;";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible to vote </span>";
						$do_acc = "<a href='#' id='enable_voter$voter_id' class='text-info'> Enable </a> &nbsp; &nbsp;";
					}
					else {
						$status = "<span class='text-text'><i class='icon-check'></i> Voted </span>";
						$do_acc = "";
					}

					if($voted == "0")
					{
						$vote_status = "<span class='text-danger'><i class='icon-remove'></i> Not yet voted.</span>";
					} else {
						$vote_status = "<span class='text-success'><b> $voted_on </b> <br/> Key used - <b> $key_used</b></span>";
					}


				?>
					
					<script type='text/javascript'>
						
						var search_voter = "<?php echo $voter;?>";

						$("#another_delete_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this voter's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&search_voter="+search_voter;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?AnotherDeleteVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#another_disable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disable this voter from voting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&search_voter="+search_voter;

								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?AnotherDisableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#another_enable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this voter to vote?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&search_voter="+search_voter;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Enabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?AnotherEnableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#another_edit_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&search_voter="+search_voter;
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving voter's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?AnotherEditVoter",
								cache:false,
								
								success: function(msg)
								{
									$("#display_search_voters").fadeOut(200);
									$("#display_search_modify_voters").html(msg);
									$("#display_search_modify_voters").fadeIn(500);
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $constituency;?></td>
						<td><?php echo $vote_status;?></td>
						<td><?php echo $status;?></td>
						<td>
							<?php echo $do_acc;

							if($voted == "0") {
							?>
								<a href='#' id='another_edit_voter<?php echo $voter_id;?>' class='text-success'> Edit </a> &nbsp; &nbsp;
								<a href='#' id='another_delete_voter<?php echo $voter_id;?>' class='text-danger'> Delete </a>
							<?php
							}
							?>
						</td>
					</tr>

				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	
	else if(isset($_GET["DisplayAllSearchedVoted"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		$voter = $_POST['voter'];

		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				var ajax_status = $("#ajax_status");
				var voter = "<?php echo $voter;?>";

				$('.first_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoted",{current_page:first_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voted").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoted",{current_page:last_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voted").html(msg).fadeIn(1000);
					});
	
				});
				
				$('.next_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoted",{current_page:next_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voted").html(msg).fadeIn(1000);
					});
	
				});
				
				$('.prev_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedVoted",{current_page:prev_page_num, per_page:per_page,voter:voter},function(msg)
					{
						$("#display_search_voted").html(msg).fadeIn(1000);
					});
				});
			
				$("#back_to_all_voted").click(function()
				{
					var per_page = "<?php echo $per_page;?>";
					var current_page = "<?php echo $current_page;?>";
					
					ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post('display?DisplayAllVoted', {per_page: per_page, current_page: current_page}, function(msg)
					{
						$("#display_search_voted").hide("fast");
						$("#display_voted").show("fast");
						$("#display_voted").html(msg);
					});
				});
			
			</script>
	
			<br/>
			<div align="center">
				<button id="back_to_all_voted" class="btn btn-sm btn-info">&laquo; Back to all voted </button>
			</div>

			<br/>

		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `voters` WHERE (`matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ?) AND (`voted` = '1') ORDER BY `matric`");
		$query->bindvalue(1,'%'.$voter.'%');
		$query->bindvalue(2,$voter.'%');
		$query->bindvalue(3,'%'.$voter);
		$query->bindvalue(4,'%'.$voter.'%');
		$query->bindvalue(5,$voter.'%');
		$query->bindvalue(6,'%'.$voter);
		$query->execute();
		$count_rows = $query->rowCount();

		$voters_query  = $db_handle->prepare("SELECT *FROM `voters` WHERE (`matric` LIKE ? OR `matric` LIKE ? OR `matric` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ? OR `key_used` LIKE ?) AND (`voted` = '1') ORDER BY `matric` LIMIT $offset,$per_page");
		$voters_query->bindvalue(1,'%'.$voter.'%');
		$voters_query->bindvalue(2,$voter.'%');
		$voters_query->bindvalue(3,'%'.$voter);
		$voters_query->bindvalue(4,'%'.$voter.'%');
		$voters_query->bindvalue(5,$voter.'%');
		$voters_query->bindvalue(6,'%'.$voter);
		$voters_query->execute();
		$count_voters = $voters_query->rowCount();

		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_voters == 0)
		{
			echo error_admin_msg("No voted yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$("form#another_search_voted").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?AnotherSearchVoted",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});
				</script>

				<div class="col-md-12 col-sm-12">
					
					<br/>
					<form id="another_search_voted" action="" method="post">
						<div class="input-group">
								
							<span class="input-group-addon"><span class="icon-user"></span></span>
									
							<input type="text" name="another_voter" id="another_voter" class="form-control" placeholder="Enter voter's matric number"/>

							<span class="input-group-btn">
								<button type="submit" class="btn btn-success pull-right"><i class="icon-search"></i> Search </button>
							</span>

						</div>
					</form>
				</div>

				<div class="col-md-12 col-sm-12">
					<br/><h3 align="center"><i class="icon-user"></i> Search result for <?php echo $voter;?> <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
							<th>S/N</th>
							<th>Matric</th>
							<th>Date voted</th>
							<th>Voting key</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voted = $voters_query->fetchAll();
				$i = 0;
				
				foreach($fetch_voted as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['voters_id'];
					$matric = $row['matric'];
					$qualify = $row['qualify'];
					$voted = $row['voted'];
					$key_used = get_key_used($voter_id);
					$voted_date = $row['voted_on'];
					
					if($voted_date !== "") 
					{
						$voted_on = format_date_time($voted_date);
					}
					else
					{
						$voted_on = "";
					}

					if($voted == "0") 
					{
						$key_status = "";
					} else {
						$key_status = "<span class='text-success'> $key_used</b></span>";
					}


				?>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $voted_on;?></td>
						<td><?php echo $key_status;?></td>
						
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			
			<?php
		}
	}
	
	
	else if(isset($_GET["OldDisplayAllVoters"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.voter("display?DisplayAllVoters",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.voter("display?DisplayAllVoters",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.voter("display?DisplayAllVoters",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
				
				$('.prev_voters').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.voter("display?DisplayAllVoters",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_voters").html(msg).fadeIn(1000);
					});
				});
			
		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `voters_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$voters_query  = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `voters_id` DESC LIMIT $offset,$per_page");
		$voters_query->execute();
		$count_voters = $voters_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_voters == 0)
		{
			echo error_admin_msg("No voters yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_voters'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_voters'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_voters'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_voters'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<div class="col-md-12 col-sm-12">
					<h3 align="center"><i class="icon-user"></i> All voters <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div><br/>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Matric</th>
							<th>Dept/Level</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_voters = $voters_query->fetchAll();
				$i = 0;
				
				foreach($fetch_voters as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$voter_id = $row['voters_id'];
					$surname = ucfirst($row['surname']);
					$firstname = ucfirst($row['firstname']);
					$othername = ucfirst($row['othername']);
					$fullname = $surname." ".$firstname." ".$othername;
					$matric = $row['matric'];
					$phone = $row['phone'];
					$email = $row['email'];
					$dept_id = $row['dept_id'];
					$dept_name = get_dept_name($dept_id);
					$level = $row['level'];
					$qualify = $row['qualify'];

					if($qualify == "1") {
						$status = "<span class='text-success'><i class='icon-check'></i> Eligible</span>";
						$do_acc = "<a href='#' id='disable_voter$voter_id' class='text-danger'> Disable </a>";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Not eligible</span>";
						$do_acc = "<a href='#' id='enable_voter$voter_id' class='text-info'> Enable </a>";
					}

				?>
					
					<script type='text/javascript'>
						
						$("#delete_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this voter's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disable this voter from voting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#enable_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this voter to vote?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var voter_id ="<?php echo $voter_id;?>";
								var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Enabling voter <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?EnableVoter",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_voter<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "voter="+voter_id+"&current_page="+current_page+"&per_page="+per_page;
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving voter's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditVoter",
								cache:false,
								
								success: function(msg)
								{
									$("#display_voters").fadeOut(200);
									$("#display_modify_voters").html(msg);
									$("#display_modify_voters").fadeIn(500);
								}
							});
						});

						$("#view_voter_profile<?php echo $voter_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_voters").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var voter_id ="<?php echo $voter_id;?>";
							var data = "student="+voter_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=voter";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?StudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_voters").fadeOut();
									$("#display_modify_voters").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><a href='#' id='view_voter_profile<?php echo $voter_id;?>'><?php echo $fullname;?></a></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $dept_name;?>/<?php echo $level;?>L</td>
						<td><?php echo $status;?></td>
						<td>
							<a href='#' id='edit_voter<?php echo $voter_id;?>' class='text-success'> Edit </a> &nbsp; &nbsp;
							<?php echo $do_acc;?> &nbsp; &nbsp;
							<a href='#' id='delete_voter<?php echo $voter_id;?>' class='text-danger'> Delete </a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	
	else if(isset($_GET["DisplayAllAspirants"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];

		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllAspirants",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllAspirants",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();

					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllAspirants",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_aspirants").html(msg);
					});
				});
				
				$('.prev_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllAspirants",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_aspirants").html(msg).fadeIn(1000);
					});
				});
			
		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `aspirants` ORDER BY `aspirant_id` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$aspirants_query  = $db_handle->prepare("SELECT *FROM `aspirants` ORDER BY `aspirant_id` ASC LIMIT $offset,$per_page");
		$aspirants_query->execute();
		$count_aspirants = $aspirants_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_aspirants == 0)
		{
			echo error_admin_msg("No aspirants yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$(document).ready(function(){
				    	$('#table_id').DataTable({
							dom: 'Bfrtip',
							'iDisplayLength': 100,
							// buttons: [
							// 	'copy', 'csv', 'excel', 'pdf', 'print'
							// ]
							buttons: {
								buttons: [
									{
										extend:'excel',
										text: 'Export to excel',
										className: 'btn btn-info'
									},

									{
										extend:'print',
										text: 'Print',
										className: 'btn btn-info'
									}
								]
							}
						});
				    });

					$("#delete_al_aspirants").click(function()
					{
						var confirm = window.confirm("Are you sure you want to delete all aspirants?");
						
						if(confirm == false){
							return false;
						}								
						else {
							
							$("#support_ajax_status").show();
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Deleting all aspirants <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
								}
							});
							
							$.ajax(
							{
								type: "GET",
								url: "../confirm?ResetAspirants",
								cache:false,
								
								success: function(msg)
								{
									$("#ajax_status").show();
									$("#ajax_status").html(msg).delay(2000).fadeOut("slow");
								}
							});
						}
					});
			
					
				</script>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<!-- <button id="delete_all_aspirants" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all aspirants </button> 
					<br/> -->
					
				</div><br/>
					
				<div class="table-responsive">
								
				<table id="table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
                        <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Nickname</th>
							<th>Vying for</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					
					<tbody>
			
				<?php
				
				$fetch_aspirants = $aspirants_query->fetchAll();
				$i = 0;
				
				foreach($fetch_aspirants as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$aspirant_id = $row['aspirant_id'];
					$fullname = $row['fullname'];
					$nickname = $row['nickname'];
					$post_id = $row['post_id'];
					$post_name = get_post_name($post_id);
					$qualify = $row['qualify'];
					$votes = $row['votes'];

					if($qualify == "1") {
						$status = "<a href='#' id='qualified_aspirants' class='text-success'><i class='icon-check'></i> Qualified</a>";
						$do_acc = "<a href='#' id='disqualify_aspirant$aspirant_id' class='text-danger'> Disqualify </a>";
					}
					else if($qualify == "0") {
						$status = "<a href='#' id='disqualified_aspirants' class='text-danger'><i class='icon-remove'></i> Disqualified</a>";
						$do_acc = "<a href='#' id='qualify_aspirant$aspirant_id' class='text-info'> Qualify </a>";
					}

				?>
					
					<script type='text/javascript'>
						
						$("#delete_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this aspirant's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disqualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disqualify this aspirant from contesting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisqualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#qualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this aspirant to contest?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Qualifying aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?QualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
							
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving aspirant's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditAspirant",
								cache:false,
								
								success: function(msg)
								{
									$("#display_aspirants").fadeOut(200);
									$("#display_modify_aspirants").html(msg);
									$("#display_modify_aspirants").fadeIn(500);
								}
							});
						});

						$("#view_aspirant_profile<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var data = "student="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=aspirant";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?StudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_aspirants").fadeOut();
									$("#display_modify_aspirants").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><a href='#' id='view_aspirant_profile<?php echo $aspirant_id;?>'><?php echo $fullname;?></a></td>
						<td><?php echo $nickname;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $status;?></td>
						<td>
							<a href='#' id='edit_aspirant<?php echo $aspirant_id;?>' class='text-success'> Edit </a> &nbsp;
							<?php echo $do_acc;?> &nbsp; 
							<a href='#' id='delete_aspirant<?php echo $aspirant_id;?>' class='text-danger'> Delete </a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}

	else if(isset($_GET["DisplayAllAspirantsResult"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT DISTINCT `post_id` FROM `aspirants` ORDER BY `aspirant_id` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		if($count_rows == 0)
		{
			echo error_admin_msg("No aspirants yet.");
		}
		else
		{
				?>
												
				<script type="text/javascript">

					$(document).ready(function(){
				    	$('#table_id').DataTable({
							dom: 'Bfrtip',
							'iDisplayLength': 100,
							// buttons: [
							// 	'copy', 'csv', 'excel', 'pdf', 'print'
							// ]
							buttons: {
								buttons: [
									{
										extend:'excel',
										text: 'Export to excel',
										className: 'btn btn-info'
									},

									{
										extend:'print',
										text: 'Print',
										className: 'btn btn-info'
									}
								]
							}
						});
				    });

					
				</script>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<!-- <button id="delete_all_aspirants" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all aspirants </button> 
					<br/> -->
					
				</div><br/>
			
			<div align="center">
				<button onclick="Print('print_details')" class="btn btn-primary"><i class="fa fa-print"></i> Print Result </button> 
			</div>

			<div class="table-responsive" id="print_details">

				<h2 align="center"><i class="icon-signal"></i> Executives Election Result </h2>
	            
				<table class="table table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;text-align: center;">
                        <tr style="text-align:center">
							<th style="text-align:center">S/N</th>
							<th style="text-align:center">Fullname</th>
							<th style="text-align:center">Nickname</th>
							<th style="text-align:center">Votes for </th>
							<th style="text-align:center">Votes against</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_aspirants = $query->fetchAll();
				$i = 0;
				
				foreach($fetch_aspirants as $rows)
				{
					$post_id = $rows['post_id'];
					$post_array[] = $post_id;
				}

				foreach($post_array as $post) {
					$post_name = get_post_name($post);
					$post_void_votes = count_aspirant_void_votes($post);
					?>
						<tr style="background-color:#eee">
							<td colspan="2"></td> 
							<td><p style="font-weight:bold;text-align:center;font-size:18px;text-transform: uppercase;"> <?php echo $post_name;?> </p>
								<p style="text-align: center;">VOID VOTES - <b><?php echo $post_void_votes;?> </b> <p></p></td>
							<td colspan="2"></td> 
						</tr>
					<?php

					$post_query  = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `post_id` = ? ORDER BY `aspirant_id` ASC");
					$post_query->bindparam(1,$post);
					$post_query->execute();
					$count_post_rows = $query->rowCount();
					
					$fetch_aspirant_posts = $post_query->fetchAll();
					$i = 0;
						
					foreach($fetch_aspirant_posts as $row)
					{
						$i++;
						$aspirant_id = $row['aspirant_id'];
						$fullname = $row['fullname'];
						$nickname = $row['nickname'];
						$qualify = $row['qualify'];
						$votes = $row['votes'];
						$votes_against = $row['against'];
						$all_votes = count_post_votes($post);
						$all_votes_against = count_post_against_votes($post);
						$total_post_votes = $all_votes+$all_votes_against+$post_void_votes;

						?>
							
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $fullname;?></td>
							<td><?php echo $nickname;?></td>
							<td><?php echo $votes;?></td>
							<td><?php echo $votes_against;?></td>
							<!-- <td><?php echo $status;?></td> -->
						</tr>
					<?php
					}

					?>
						<tr>
							<td colspan="2"></td> 
							<td align="right"><b> SUM TOTAL </b></td> 
							<td><b><?php echo $all_votes;?></b></td>
							<td><b><?php echo $all_votes_against;?></b></td>
						</tr>

						<tr>
							<td colspan="2"></td> 
							<td align="right"><b> OVERALL TOTAL (EACH SUM TOTAL + VOID VOTES) </b></td> 
							<td><b><?php echo $total_post_votes;?></b></td> 
							<td colspan="1"></td>
						</tr>
						<tr>
							<td colspan="5"></td> 
						</tr>


					<?php
				}
				?>
				</tbody></table></div>			
			
			<?php
		}
	}

	else if(isset($_GET["DisplayAllAspirantsResultxx"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `aspirants` ORDER BY `aspirant_id` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$aspirants_query  = $db_handle->prepare("SELECT *FROM `aspirants` ORDER BY `aspirant_id` ASC LIMIT $offset,$per_page");
		$aspirants_query->execute();
		$count_aspirants = $aspirants_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_aspirants == 0)
		{
			echo error_admin_msg("No aspirants yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$(document).ready(function(){
				    	$('#table_id').DataTable({
							dom: 'Bfrtip',
							'iDisplayLength': 100,
							// buttons: [
							// 	'copy', 'csv', 'excel', 'pdf', 'print'
							// ]
							buttons: {
								buttons: [
									{
										extend:'excel',
										text: 'Export to excel',
										className: 'btn btn-info'
									},

									{
										extend:'print',
										text: 'Print',
										className: 'btn btn-info'
									}
								]
							}
						});
				    });

					
				</script>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<!-- <button id="delete_all_aspirants" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all aspirants </button> 
					<br/> -->
					
				</div><br/>
					
				<div class="table-responsive">
								
				<table id="table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase">
                        <tr style="text-align:center">
							<th>S/N</th>
							<th>Fullname</th>
							<th>Nickname</th>
							<th>Vyed for</th>
							<th>Votes for </th>
							<th>Votes against</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_aspirants = $aspirants_query->fetchAll();
				$i = 0;
				$votes_array = array();
				$votes_against_array = array();
				$post_array = array();
				$aspirant_array = array();

				foreach($fetch_aspirants as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$aspirant_id = $row['aspirant_id'];
					$fullname = $row['fullname'];
					$nickname = $row['nickname'];
					$post_id = $row['post_id'];
					$post_name = get_post_name($post_id);
					$qualify = $row['qualify'];
					$votes = $row['votes'];
					$votes_against = $row['against'];
					$post_array[] = $post_id;

					// $status = "Winner";
				?>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $fullname;?></td>
						<td><?php echo $nickname;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $votes;?></td>
						<td><?php echo $votes_against;?></td>
						<!-- <td><?php echo $status;?></td> -->
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
			
			<?php
		}
	}

	else if(isset($_GET["DisplayAllFloorReps"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];

		?>
			
			<script type='text/javascript'>
				

				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_floor_reps').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllFloorReps",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_floor_reps").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_floor_reps').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllFloorReps",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_floor_reps").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_floor_reps').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();

					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllFloorReps",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_floor_reps").html(msg);
					});
				});
				
				$('.prev_floor_reps').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllFloorReps",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_floor_reps").html(msg).fadeIn(1000);
					});
				});
			
		</script>

		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `floor_reps` ORDER BY `constituency` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$floor_reps_query  = $db_handle->prepare("SELECT *FROM `floor_reps` ORDER BY `constituency` ASC LIMIT $offset,$per_page");
		$floor_reps_query->execute();
		$count_floor_reps = $floor_reps_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_floor_reps == 0)
		{
			echo error_admin_msg("No floor_reps yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_floor_reps'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_floor_reps'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_floor_reps'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_floor_reps'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_floor_reps'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_floor_reps'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_floor_reps'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_floor_reps'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$(document).ready(function(){
				    	$('#table_id').DataTable({
							dom: 'Bfrtip',
							'iDisplayLength': 100,
							
							// buttons: [
							// 	'copy', 'csv', 'excel', 'pdf', 'print'
							// ]
							buttons: {
								buttons: [
									{
										extend:'excel',
										text: 'Export to excel',
										className: 'btn btn-info'
									},

									{
										extend:'print',
										text: 'Print',
										className: 'btn btn-info'
									}
								]
							}
						});
				    });

					$("form#search_floor_reps").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Pleas wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?SearchAspirant",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});

					$("#delete_all_floor_reps").click(function()
					{
						var confirm = window.confirm("Are you sure you want to delete all floor_reps?");
						
						if(confirm == false){
							return false;
						}								
						else {
							
							$("#support_ajax_status").show();
							
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Deleting all floor_reps <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
								}
							});
							
							$.ajax(
							{
								type: "GET",
								url: "../confirm?ResetFloorReps",
								cache:false,
								
								success: function(msg)
								{
									$("#ajax_status").show();
									$("#ajax_status").html(msg).delay(2000).fadeOut("slow");
								}
							});
						}
					});
			
					
				</script>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<!-- <button id="delete_all_floor_reps" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all floor_reps </button> 
					<br/> -->
					
				</div><br/>
					
				<div class="table-responsive">
								
				<table id="table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
	                    <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Nickname</th>
							<th>Constituency</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_floor_reps = $floor_reps_query->fetchAll();
				$i = 0;
				
				foreach($fetch_floor_reps as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$rep_id = $row['rep_id'];
					$fullname = $row['fullname'];
					$nickname = $row['nickname'];
					$constituency = $row['constituency'];
					$post_name = $constituency;
					$qualify = $row['qualify'];
					$votes = $row['votes'];

					if($qualify == "1") {
						$status = "<a href='#' id='qualified_floor_reps' class='text-success'><i class='icon-check'></i> Qualified</a>";
						$do_acc = "<a href='#' id='disqualify_rep$rep_id' class='text-danger'> Disqualify </a>";
					}
					else if($qualify == "0") {
						$status = "<a href='#' id='disqualified_floor_reps' class='text-danger'><i class='icon-remove'></i> Disqualified</a>";
						$do_acc = "<a href='#' id='qualify_rep$rep_id' class='text-info'> Qualify </a>";
					}

				?>
					
					<script type='text/javascript'>
						
						$("#delete_rep<?php echo $rep_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this floor rep's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var rep_id ="<?php echo $rep_id;?>";
								var data = "rep="+rep_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting floor rep <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteFloorRep",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disqualify_rep<?php echo $rep_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disqualify this floor rep from contesting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var rep_id ="<?php echo $rep_id;?>";
								var data = "rep="+rep_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling floor rep <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisqualifyFloorRep",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#qualify_rep<?php echo $rep_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this floor rep to contest?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var rep_id ="<?php echo $rep_id;?>";
								var data = "rep="+rep_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Qualifying floor rep <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?QualifyFloorRep",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_rep<?php echo $rep_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_floor_reps").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var rep_id ="<?php echo $rep_id;?>";
							var data = "rep="+rep_id+"&current_page="+current_page+"&per_page="+per_page;
							
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving floor rep's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditFloorRep",
								cache:false,
								
								success: function(msg)
								{
									$("#display_reps").fadeOut(200);
									$("#display_modify_reps").html(msg);
									$("#display_modify_reps").fadeIn(500);
								}
							});
						});

						$("#view_rep_profile<?php echo $rep_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_floor_reps").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var rep_id ="<?php echo $rep_id;?>";
							var data = "rep="+rep_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=rep";

							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?RepProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_reps").fadeOut();
									$("#display_modify_reps").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><a href='#' id='view_rep_profile<?php echo $rep_id;?>'><?php echo $fullname;?></a></td>
						<td><?php echo $nickname;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $status;?></td>
						<td>
							<a href='#' id='edit_rep<?php echo $rep_id;?>' class='text-success'> Edit </a> &nbsp;
							<?php echo $do_acc;?> &nbsp; 
							<a href='#' id='delete_rep<?php echo $rep_id;?>' class='text-danger'> Delete </a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}

	
	else if(isset($_GET["DisplayAllFloorRepsResult"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];

		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT DISTINCT `constituency` FROM `floor_reps` ORDER BY `constituency` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		if($count_rows == 0)
		{
			echo error_admin_msg("No floor reps yet.");
		}
		else
		{
			?>
												
				<script type="text/javascript">
					
					$(document).ready(function(){
				    	$('#table_id').DataTable({
							dom: 'Bfrtip',
							'iDisplayLength': 100,
							// buttons: [
							// 	'copy', 'csv', 'excel', 'pdf', 'print'
							// ]
							buttons: {
								buttons: [
									{
										extend:'excel',
										text: 'Export to excel',
										className: 'btn btn-info'
									},

									{
										extend:'print',
										text: 'Print',
										className: 'btn btn-info'
									}
								]
							}
						});
				    });

					
				</script>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<!-- <button id="delete_all_floor_reps" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all floor_reps </button> 
					<br/> -->
					
				</div><br/>
					
			<div align="center">
				<button onclick="Print('print_details')" class="btn btn-primary"><i class="fa fa-print"></i> Print Result </button> 
			</div>


			<div class="table-responsive" id="print_details">
				
				<h2 align="center"><i class="icon-signal"></i> Floor Reps Election Result </h2>
	            
				<table class="table table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
	                    <tr>
							<th style="text-align: center;">S/N</th>
							<th style="text-align: center;">Fullname</th>
							<th style="text-align: center;">Nickname</th>
							<th style="text-align: center;">Votes for</th>
							<th style="text-align: center;">Votes against</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_floor_reps = $query->fetchAll();
				$i = 0;
				
				$constituency_array = array();
				
				foreach($fetch_floor_reps as $rows)
				{
					$i++;
					$constituency = $rows['constituency'];
					$constituency_array[] = $constituency;
				}

				foreach($constituency_array as $the_constituency) {
					$constituency_void_votes = count_floor_rep_void_votes($the_constituency);

					?>
						<tr  style="background-color:#eee">
							<td colspan="2"></td> 
							<td><p style="font-weight:bold;text-align:center;font-size:18px;text-transform: uppercase;"> <?php echo $the_constituency;?> </p>
								<p style="text-align: center;">VOID VOTES - <b><?php echo $constituency_void_votes;?> </b> <p></p></td>
							<td colspan="2"></td> 
						</tr>
					<?php

					$const_query  = $db_handle->prepare("SELECT *FROM `floor_reps` WHERE `constituency` = ? ORDER BY `rep_id` ASC");
					$const_query->bindparam(1,$the_constituency);
					$const_query->execute();
					$count_const_rows = $const_query->rowCount();
					
					$fetch_floor_reps = $const_query->fetchAll();
					$i = 0;
						
					foreach($fetch_floor_reps as $row)
					{
						$i++;
						$rep_id = $row['rep_id'];
						$fullname = $row['fullname'];
						$nickname = $row['nickname'];
						$qualify = $row['qualify'];
						$votes = $row['votes'];
						$votes_against = $row['against'];	
						$all_votes = count_constituency_votes($the_constituency);
						$all_votes_against = count_constituency_against_votes($the_constituency);
						$total_constituency_votes = $all_votes+$all_votes_against+$constituency_void_votes;

					?>
					
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $fullname;?></td>
						<td><?php echo $nickname;?></td>
						<td><?php echo $votes;?></td>
						<td><?php echo $votes_against;?></td>
						<!-- <td><?php echo $status;?></td>
						 -->
					</tr>
				<?php
				}

				?>
					<tr>
						<td colspan="2"></td> 
						<td align="right"><b> SUM TOTAL </b></td> 
						<td><b><?php echo $all_votes;?></b></td>
						<td><b><?php echo $all_votes_against;?></b></td>
					</tr>

					<tr>
						<td colspan="2"></td> 
						<td align="right"><b> OVERALL TOTAL (EACH SUM TOTAL + VOID VOTES) </b></td> 
						<td><b><?php echo $total_constituency_votes;?></b></td> 
						<td colspan="1"></td>
					</tr>
					<tr>
						<td colspan="5"></td> 
					</tr>
					
				<?php
				
			}
			?>
			</tbody></table></div>			
			
			<?php
		}
	}

	
	else if(isset($_GET["DisplayAllFloorRepsResultxx"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];

		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `floor_reps` ORDER BY `constituency` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$floor_reps_query  = $db_handle->prepare("SELECT *FROM `floor_reps` ORDER BY `constituency` ASC LIMIT $offset,$per_page");
		$floor_reps_query->execute();
		$count_floor_reps = $floor_reps_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_floor_reps == 0)
		{
			echo error_admin_msg("No floor_reps yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_floor_reps'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_floor_reps'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_floor_reps'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_floor_reps'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_floor_reps'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_floor_reps'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_floor_reps'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_floor_reps'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">
					
					$(document).ready(function(){
				    	$('#table_id').DataTable({
							dom: 'Bfrtip',
							'iDisplayLength': 100,
							// buttons: [
							// 	'copy', 'csv', 'excel', 'pdf', 'print'
							// ]
							buttons: {
								buttons: [
									{
										extend:'excel',
										text: 'Export to excel',
										className: 'btn btn-info'
									},

									{
										extend:'print',
										text: 'Print',
										className: 'btn btn-info'
									}
								]
							}
						});
				    });

					
				</script>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<!-- <button id="delete_all_floor_reps" class="btn btn-danger pull-left"><i class="icon-remove"></i> Delete all floor_reps </button> 
					<br/> -->
					
				</div><br/>
					
				<div class="table-responsive">
								
				<table id="table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
	                    <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Nickname</th>
							<th>Constituency</th>
							<th>Votes for</th>
							<th>Votes against</th>
							<!-- <th>Status</th> -->
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_floor_reps = $floor_reps_query->fetchAll();
				$i = 0;
				
				foreach($fetch_floor_reps as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$rep_id = $row['rep_id'];
					$fullname = $row['fullname'];
					$nickname = $row['nickname'];
					$constituency = $row['constituency'];
					$post_name = $constituency;
					$qualify = $row['qualify'];
					$votes = $row['votes'];
					$votes_against = $row['against'];	
					$status = "Won";
					?>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><?php echo $fullname;?></td>
						<td><?php echo $nickname;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $votes;?></td>
						<td><?php echo $votes_against;?></td>
						<!-- <td><?php echo $status;?></td>
						 -->
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
			
			<?php
		}
	}

	
	else if(isset($_GET["DisplayPostAspirants"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		$post_id = $_POST['post'];
		$post_name = get_post_name($post_id);

		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				var post_id = "<?php echo $post_id;?>";
				
				$('.first_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayPostAspirants",{current_page:first_page_num, per_page:per_page,post_id:post_id},function(msg)
					{
						$("#display_post_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayPostAspirants",{current_page:last_page_num, per_page:per_page,post_id:post_id},function(msg)
					{
						$("#display_post_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();

					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayPostAspirants",{current_page:next_page_num, per_page:per_page,post_id:post_id},function(msg)
					{
						$("#display_post_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.prev_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayPostAspirants",{current_page:prev_page_num, per_page:per_page,post_id:post_id},function(msg)
					{
						$("#display_post_aspirants").html(msg).fadeIn(1000);
					});
				});
			
		</script>
	
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `post_id` = ? ORDER BY `aspirant_id` DESC");
		$query->bindparam(1,$post_id);
		$query->execute();
		$count_rows = $query->rowCount();
			
		$aspirants_query  = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `post_id` = ? ORDER BY `aspirant_id` DESC LIMIT $offset,$per_page");
		$aspirants_query->bindparam(1,$post_id);
		$aspirants_query->execute();
		$count_aspirants = $aspirants_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_aspirants == 0)
		{
			echo error_admin_msg("No aspirants yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<div style="clear:both" class="col-md-12 col-sm-12">
					<br/>
					<h3 align="center"><i class="icon-user"></i> All aspirants <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div><br/>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Matric</th>
							<th>Course</th>
							<th>Aspiring for</th>
							<th>Eligiblity</th>
							<th>Votes</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_aspirants = $aspirants_query->fetchAll();
				$i = 0;
				
				foreach($fetch_aspirants as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$aspirant_id = $row['aspirant_id'];
					$fullname = $row['fullname'];
					$matric = $row['matric'];
					$dept_id = $row['dept_id'];
					$dept_name = get_dept_name($dept_id);
					$level = $row['level'];
					$course = $dept_name."/".$level."L";
					$post_id = $row['post_id'];
					$post_name = get_post_name($post_id);
					$qualify = $row['qualify'];
					$votes = $row['votes'];

					if($qualify == "1") {
						$status = "<a href='#' id='qualified_aspirants' class='text-success'><i class='icon-check'></i> Qualified</a>";
						$do_acc = "<a href='#' id='disqualify_aspirant$aspirant_id' class='text-danger'> Disqualify </a>";
					}
					else if($qualify == "0") {
						$status = "<a href='#' id='disqualified_aspirants' class='text-danger'><i class='icon-remove'></i> Disqualified</a>";
						$do_acc = "<a href='#' id='qualify_aspirant$aspirant_id' class='text-info'> Qualify </a>";
					}

				?>
					
					<script type='text/javascript'>
						
						$("#post_delete_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this aspirant's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeletePostAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disqualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disqualify this aspirant from contesting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisqualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#qualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this aspirant to contest?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Qualifying aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?QualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
							
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving aspirant's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditAspirant",
								cache:false,
								
								success: function(msg)
								{
									$("#display_aspirants").fadeOut(200);
									$("#display_modify_aspirants").html(msg);
									$("#display_modify_aspirants").fadeIn(500);
								}
							});
						});

						$("#view_aspirant_profile<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var data = "student="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=aspirant";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?StudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_aspirants").fadeOut();
									$("#display_modify_aspirants").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><a href='#' id='view_aspirant_profile<?php echo $aspirant_id;?>'><?php echo $fullname;?></a></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $course;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $status;?></td>
						<td><?php echo $votes;?></td>
						<td>
							<a href='#' id='edit_aspirant<?php echo $aspirant_id;?>' class='text-success'> Edit </a> &nbsp;
							<?php echo $do_acc;?> &nbsp; 
							<a href='#' id='delete_aspirant<?php echo $aspirant_id;?>' class='text-danger'> Delete </a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	
	else if(isset($_GET["DisplayAllSearchedAspirants"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		$aspirant = $_POST['aspirant'];

		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				var aspirant = "<?php echo $aspirant;?>";
				var per_page =  "<?php echo $per_page;?>";
				var current_page = "<?php echo $current_page;?>";
				var ajax_status = $("#ajax_status");
					
				$('.first_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedAspirants",{current_page:first_page_num, per_page:per_page, aspirant:aspirant},function(msg)
					{
						$("#display_search_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedAspirants",{current_page:last_page_num, per_page:per_page, aspirant:aspirant},function(msg)
					{
						$("#display_search_aspirants").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedAspirants",{current_page:next_page_num, per_page:per_page, aspirant:aspirant},function(msg)
					{
						$("#display_search_aspirants").html(msg);
					});
				});
				
				$('.prev_aspirants').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllSearchedAspirants",{current_page:prev_page_num, per_page:per_page, aspirant:aspirant},function(msg)
					{
						$("#display_search_aspirants").html(msg).fadeIn(1000);
					});
				});

				$("#back_to_all_aspirants").click(function()
				{
					ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post('display?DisplayAllAspirants', {per_page: per_page, current_page: current_page}, function(msg)
					{
						$("#display_search_aspirants").hide("fast");
						$("#display_aspirants").show("fast");
						$("#display_aspirants").html(msg);
					});
				});
			
			</script>
	
		<div align="center">
			<button id="back_to_all_aspirants" class="btn btn-sm btn-info">&laquo; Back to all aspirants </button>
		</div>
		<br/>

		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `fullname` = ? OR `fullname` LIKE ? OR `fullname` LIKE ? OR `nickname` = ? OR `nickname` LIKE ? OR `nickname` LIKE ? OR `matric` = ? OR `matric` LIKE ? OR `matric` LIKE ? ORDER BY `fullname`");
		$query->bindvalue(1,'%'.$aspirant.'%');
		$query->bindvalue(2,$aspirant.'%');
		$query->bindvalue(3,'%'.$aspirant);
		$query->bindvalue(4,'%'.$aspirant.'%');
		$query->bindvalue(5,$aspirant.'%');
		$query->bindvalue(6,'%'.$aspirant);
		$query->bindvalue(7,'%'.$aspirant.'%');
		$query->bindvalue(8,$aspirant.'%');
		$query->bindvalue(9,'%'.$aspirant);
		$query->execute();
		$count_rows = $query->rowCount();
			
		$search_query  = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `fullname` = ? OR `fullname` LIKE ? OR `fullname` LIKE ? OR `nickname` = ? OR `nickname` LIKE ? OR `nickname` LIKE ? OR `matric` = ? OR `matric` LIKE ? OR `matric` LIKE ? ORDER BY `fullname` LIMIT $offset,$per_page");
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
		$count_aspirants = $search_query->rowCount();
		
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_aspirants == 0)
		{
			echo error_admin_msg("No aspirants yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<script type="text/javascript">

					$("form#another_search_aspirants").submit(function(e)
					{
						e.preventDefault();
						var support_ajax_status = $("#support_ajax_status");
						var ajax_status = $("#ajax_status");
						var data = $(this).serialize();
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
			                complete: function()
			                {
			                    support_ajax_status.html("").hide("");
			                }
						});
						
						$.ajax(
						{
							type: "POST",
							url: "../confirm?SearchAnotherAspirant",
							data: data,
							cache: false,
							
							success:function(msg)
							{
								ajax_status.show();
			                    ajax_status.html(msg).delay(4000).fadeOut("slow");
							}
						});
					});
				</script>

				<div class="col-md-12 col-sm-12">
					
					<br/>
					<form id="another_search_aspirants" action="" method="post">
						<div class="input-group">
								
							<span class="input-group-addon"><span class="icon-user"></span></span>
									
							<input type="text" name="another_aspirant" id="another_aspirant" class="form-control" placeholder="Enter aspirant's fullname or nickname or matric number"/>

							<span class="input-group-btn">
								<button type="submit" class="btn btn-success pull-right"><i class="icon-search"></i> Search </button>
							</span>

						</div>
					</form>
				</div>

				<div style="clear:both" class="col-md-12 col-sm-12">
					<br/>
					<h3 align="center"><i class="icon-search"></i> Search result for <?php echo $aspirant;?> <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div><br/>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Nickname</th>
							<th>Aspiring for</th>
							<th>Eligiblity</th>
							<th>Votes</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_aspirants = $search_query->fetchAll();
				$i = 0;
				
				foreach($fetch_aspirants as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$aspirant_id = $row['aspirant_id'];
					$fullname = $row['fullname'];
					$nickname = $row['nickname'];
					$post_id = $row['post_id'];
					$post_name = get_post_name($post_id);
					$qualify = $row['qualify'];
					$votes = $row['votes'];

					if($qualify == "1") {
						$status = "<span class='text-success'><i class='icon-check'></i> Qualified</span>";
						$do_acc = "<a href='#' id='another_disqualify_aspirant$aspirant_id' class='text-danger'> Disqualify </a>";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Disqualified</span>";
						$do_acc = "<a href='#' id='another_qualify_aspirant$aspirant_id' class='text-info'> Qualify </a>";
					}

				?>
					
					<script type='text/javascript'>
						
						$("#another_delete_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this aspirant's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var search_aspirant = "<?php echo $aspirant;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&search_aspirant="+search_aspirant;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?SearchDeleteAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#another_disqualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disqualify this aspirant from contesting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var search_aspirant = "<?php echo $aspirant;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&search_aspirant="+search_aspirant;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?SearchDisqualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#another_qualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this aspirant to contest?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var search_aspirant = "<?php echo $aspirant;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&search_aspirant="+search_aspirant;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Qualifying aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?SearchQualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#another_edit_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var search_aspirant = "<?php echo $aspirant;?>";
							var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&search_aspirant="+search_aspirant;
							
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving aspirant's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?SearchEditAspirant",
								cache:false,
								
								success: function(msg)
								{
									$("#display_search_aspirants").fadeOut(200);
									$("#display_search_modify_aspirants").html(msg);
									$("#display_search_modify_aspirants").fadeIn(500);
								}
							});
						});

						$("#another_view_aspirant_profile<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var search_aspirant = "<?php echo $aspirant;?>";
							var data = "student="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&search_aspirant="+search_aspirant+"&coming=aspirant";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?SearchStudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_search_aspirants").fadeOut();
									$("#display_search_modify_aspirants").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><a href='#' id='another_view_aspirant_profile<?php echo $aspirant_id;?>'><?php echo $fullname;?></a></td>
						<td><?php echo $nickname;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $status;?></td>
						<td><?php echo $votes;?></td>
						<td>
							<a href='#' id='another_edit_aspirant<?php echo $aspirant_id;?>' class='text-success'> Edit </a> &nbsp;
							<?php echo $do_acc;?> &nbsp; 
							<a href='#' id='another_delete_aspirant<?php echo $aspirant_id;?>' class='text-danger'> Delete </a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
	}
	
	
	else if(isset($_GET["OldDisplayAllAspirants"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
					var support_ajax_status = $("#support_ajax_status");
					
					$('.first_aspirants').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var first_page_num = Number($(this).attr('id'));
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.aspirant("display?DisplayAllAspirants",{current_page:first_page_num, per_page:per_page},function(msg)
						{
							$("#display_aspirants").html(msg).fadeIn(1000);
						});
					});
					
					$('.last_aspirants').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var last_page_num = Number($(this).attr('id'));
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.aspirant("display?DisplayAllAspirants",{current_page:last_page_num, per_page:per_page},function(msg)
						{
							$("#display_aspirants").html(msg).fadeIn(1000);
						});
					});
					
					$('.next_aspirants').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var current_page_num = Number($(this).attr('id'));
						var next_page_num = current_page_num+1;
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.aspirant("display?DisplayAllaspirants",{current_page:next_page_num, per_page:per_page},function(msg)
						{
							$("#display_aspirants").html(msg).fadeIn(1000);
						});
					});
					
					$('.prev_aspirants').click(function(e)
					{
						e.preventDefault();
						var per_page = "<?php echo $per_page;?>";
						var prev_page_num = Number($(this).attr('id'));
						support_ajax_status.show();
						
						$.ajaxSetup(
						{
							beforeSend: function()
							{
								support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
							},
							complete: function()
							{
								support_ajax_status.html("").delay(1000).fadeOut("slow");
							}
						});
						
						$.aspirant("display?DisplayAllAspirants",{current_page:prev_page_num, per_page:per_page},function(msg)
						{
							$("#display_aspirants").html(msg).fadeIn(1000);
						});
					});
				
			</script>
		
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `aspirants` ORDER BY `aspirant_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$aspirants_query  = $db_handle->prepare("SELECT *FROM `aspirants` ORDER BY `aspirant_id` DESC LIMIT $offset,$per_page");
		$aspirants_query->execute();
		$count_aspirants = $aspirants_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_aspirants == 0)
		{
			echo error_admin_msg("No aspirants yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_aspirants'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_aspirants'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_aspirants'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_aspirants'>  &laquo; Prev </button>";
			} 
			
				?>
												
				<div class="col-md-12 col-sm-12">
					<h3 align="center"><i class="icon-user"></i> All aspirants <span class="badge"> <?php echo $count_rows;?> </span> </h3>
				</div><br/>
					
				<div class="table-responsive">
								
				<table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
							<th>S/N</th>
							<th>Fullname</th>
							<th>Matric</th>
							<th>Aspiring for</th>
							<th>Dept/Level</th>
							<th>Eligiblity</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
			
				<?php
				
				$fetch_aspirants = $aspirants_query->fetchAll();
				$i = 0;
				
				foreach($fetch_aspirants as $row)
				{
					$i++;
					$start_from = $i+$offset;
					$aspirant_id = $row['aspirant_id'];
					$aspirant_student_id = $row['aspirant_student_id'];
					list($unique_id,$post_id,$nickname,$matric,$phone,$email,$dept_id,$level,$path) = get_aspirant_details($aspirant_id);
					$fullname = get_student_fullname($aspirant_student_id);
					$post_name = get_post_name($post_id);
					$dept_name = get_dept_name($dept_id);
					$qualify = $row['qualify'];

					if($qualify == "1") {
						$status = "<span class='text-success'><i class='icon-check'></i> Qualified</span>";
						$do_acc = "<a href='#' id='disqualify_aspirant$aspirant_id' class='text-danger'> Disqualify </a>";
					}
					else if($qualify == "0") {
						$status = "<span class='text-danger'><i class='icon-remove'></i> Disqualified</span>";
						$do_acc = "<a href='#' id='qualify_aspirant$aspirant_id' class='text-info'> Qualify </a>";
					}

				?>
					
					<script type='text/javascript'>
						
						$("#delete_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to delete this aspirant's details?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#disqualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to disqualify this aspirant from contesting?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Disabling aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DisqualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#qualify_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							var confirm = window.confirm("Are you sure you want to enable this aspirant to contest?");
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var aspirant_id ="<?php echo $aspirant_id;?>";
								var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Qualifying aspirant <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").hide("fast").html("");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?QualifyAspirant",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(4000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_aspirant<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var data = "aspirant="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page;
							
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Retrieving aspirant's details <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditAspirant",
								cache:false,
								
								success: function(msg)
								{
									$("#display_aspirants").fadeOut(200);
									$("#display_modify_aspirants").html(msg);
									$("#display_modify_aspirants").fadeIn(500);
								}
							});
						});

						$("#view_aspirant_profile<?php echo $aspirant_id;?>").click(function(e)
						{
							e.preventDefault();
							$("#fetch_aspirants").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var aspirant_id ="<?php echo $aspirant_id;?>";
							var data = "student="+aspirant_id+"&current_page="+current_page+"&per_page="+per_page+"&coming=aspirant";
								
							$("#support_ajax_status").show();
								
							$.ajaxSetup(
							{
								beforeSend: function()
								{
									$("#support_ajax_status").html("Please wait <img src='../images/loading_bar.gif'/>");
								},
								complete: function()
								{
									$("#support_ajax_status").hide("fast").html("");
								}
							});
							
							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?StudentProfile",
								cache:false,
								
								success: function(msg)
								{
									$("#display_aspirants").fadeOut();
									$("#display_modify_aspirants").html(msg).fadeIn();
								}
							});
						});

					</script>
					
					<tr>
						<td><?php echo $start_from;?></td>
						<td><a href='#' id='view_aspirant_profile<?php echo $aspirant_id;?>'><?php echo $fullname;?></a></td>
						<td><?php echo $matric;?></td>
						<td><?php echo $post_name;?></td>
						<td><?php echo $dept_name;?>/<?php echo $level;?>L</td>
						<td><?php echo $status;?></td>
						<td>
							<!--<a href='#' id='edit_aspirant<?php echo $aspirant_id;?>' class='text-success'> Edit </a> &nbsp; &nbsp;-->
							<?php echo $do_acc;?> &nbsp; &nbsp;
							<a href='#' id='delete_aspirant<?php echo $aspirant_id;?>' class='text-danger'> Delete </a>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody></table></div>			
				
				<div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
		?>
		
			<!--<script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
			<script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
				
			<script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
			<script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
			<script>
				 $(document).ready(function () {
					 $('#dataTables-example').dataTable();
				 });
			</script>
		-->
				
		<?php
	}
	
	
	else if(isset($_GET["DisplayAllVotingKeys"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		?>
			
			<script type='text/javascript'>
				
				var support_ajax_status = $("#support_ajax_status");
				
				$('.first_keys').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var first_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVotingKeys",{current_page:first_page_num, per_page:per_page},function(msg)
					{
						$("#display_keys").html(msg).fadeIn(1000);
					});
				});
				
				$('.last_keys').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var last_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVotingKeys",{current_page:last_page_num, per_page:per_page},function(msg)
					{
						$("#display_keys").html(msg).fadeIn(1000);
					});
				});
				
				$('.next_keys').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var current_page_num = Number($(this).attr('id'));
					var next_page_num = current_page_num+1;
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVotingKeys",{current_page:next_page_num, per_page:per_page},function(msg)
					{
						$("#display_keys").html(msg).fadeIn(1000);
					});
				});
				
				$('.prev_keys').click(function(e)
				{
					e.preventDefault();
					var per_page = "<?php echo $per_page;?>";
					var prev_page_num = Number($(this).attr('id'));
					support_ajax_status.show();
					
					$.ajaxSetup(
					{
						beforeSend: function()
						{
							support_ajax_status.html("Please wait <img src='../images/loading_bar.gif'/>");
						},
						complete: function()
						{
							support_ajax_status.html("").delay(1000).fadeOut("slow");
						}
					});
					
					$.post("display?DisplayAllVotingKeys",{current_page:prev_page_num, per_page:per_page},function(msg)
					{
						$("#display_keys").html(msg).fadeIn(1000);
					});
				});
				
			</script>
		
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `voting_keys` ORDER BY `keys_id` DESC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$keys_query  = $db_handle->prepare("SELECT *FROM `voting_keys` ORDER BY `keys_id` DESC LIMIT $offset,$per_page");
		$keys_query->execute();
		$count_keys = $keys_query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_keys == 0)
		{
			echo error_admin_msg("No voting keys yet.");
		}
		else
		{
			if( ($current_page == 1) && ($current_page != $total_pages) ) 
			{
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_keys'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_keys'> Last &raquo; </button>";
			} 
			
			else if( ($current_page == 1) && ($current_page == $total_pages) ) { } 
			
			else if( ($current_page > 1) && ($current_page < $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_keys'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_keys'>  &laquo; Prev </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$current_page' class='btn btn-xs btn-info next_keys'> Next &raquo; </button>";
				$paginationDisplay .=  "&nbsp;  <button id='$total_pages' class='btn btn-xs btn-success last_keys'> Last &raquo; </button>";
			} 
			
			else if( ($current_page > 1) && ($current_page == $total_pages) )
			{
				$prev_page = $current_page-1;
				$first_page = 1;
				
				$paginationDisplay .=  "&nbsp;  <button id='$first_page' class='btn btn-xs btn-success first_keys'> &laquo; First</button>";
				$paginationDisplay .=  "&nbsp;  <button id='$prev_page' class='btn btn-xs btn-success prev_keys'>  &laquo; Prev </button>";
			} 
			
				?>
												
					<script type='text/javascript'>
								
						$("#delete_all_keys").click(function()
						{
							var confirm = window.confirm("Are you sure you want to delete all keys?");
							
							if(confirm == false){
								return false;
							}								
							else {
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting all voting keys <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
									}
								});
								
								$.ajax(
								{
									type: "GET",
									url: "../confirm?ResetVotingKeys",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(2000).fadeOut("slow");
									}
								});
							}
						});
				</script>

				<button onClick="Print('all_keys_div');"class="btn btn-info pull-left"><i class="icon-print"></i> Print voting keys </button> 
				
				<!-- <button id="delete_all_keys" class="btn btn-danger pull-right"><i class="icon-remove"></i> Delete all voting keys </button> 
				 -->
				<div style="clear:both"></div>
				<br/><br/>
				
				<div id='all_keys_div' class="col-md-12 col-sm-12">

					<h3 align="center"><i class="icon-key"></i> All generated voting keys </h3>
				<br/>

				<?php
				
				$fetch_keys = $keys_query->fetchAll();
				$i = 0;
				
				foreach($fetch_keys as $row)
				{
					$i++;
					$keys_id = $row['keys_id'];
					$keys = $row['keys'];

				?>
					<div class='keys'>
						<?php echo $keys;?>
					</div>
					
				<?php
				}
				?>
				<br/><br/><br/></div>
				<div style="clear:both"></div>
				<br/><hr/><div align='center'>Page <b><?php echo $current_page;?></b> of <?php echo $total_pages;?> pages 
				<br/><br/><?php echo $paginationDisplay;?></div> <br/>
			<?php
		}
		?>
		
			<!--<script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
			<script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
				
			<script src="assets/plugins/dataTables/jquery.dataTables.js"></script>
			<script src="assets/plugins/dataTables/dataTables.bootstrap.js"></script>
			<script>
				 $(document).ready(function () {
					 $('#dataTables-example').dataTable();
				 });
			</script>
		-->
				
		<?php
	}
	
	
	else if(isset($_GET["DisplayAllConstituencies"]))
	{
		$per_page = $_POST['per_page'];
		$current_page = $_POST['current_page'];
		
		?>
			
			<script type='text/javascript'>
				
				$(document).ready(function(){
			    	$('#table_id').DataTable({
						dom: 'Bfrtip',
						'iDisplayLength': 100,
						// buttons: [
						// 	'copy', 'csv', 'excel', 'pdf', 'print'
						// ]
						buttons: {
							buttons: [
								{
									extend:'excel',
									text: 'Export to excel',
									className: 'btn btn-info'
								},

								{
									extend:'print',
									text: 'Print',
									className: 'btn btn-info'
								}
							]
						}
					});
			    });

			</script>
		
		<?php
		
		$offset = ($current_page-1) * $per_page;
		
		$query  = $db_handle->prepare("SELECT *FROM `constituencies` ORDER BY `name` ASC");
		$query->execute();
		$count_rows = $query->rowCount();
			
		$total_pages = ceil($count_rows/$per_page);
		$paginationDisplay = "";
		
		if($count_rows == 0)
		{
			echo error_admin_msg("No constituency yet.");
		}
		else
		{
			?>
												
				<div class="table-responsive">
								
				<table id="table_id" class="table table-striped table-bordered" style="width:100%;">
	                
	                <thead style="background-color:#000;color:#fff;text-transform: uppercase;">
                        
	                    <tr>
							<th>S/N</th>
							<th>Name</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
			
				<?php
				
				$fetch_constituencies = $query->fetchAll();
				$i = 0;
				
				foreach($fetch_constituencies as $row)
				{
					$i++;
					$const_id = $row['const_id'];
					$name = $row['name'];
				?>
					
					<script type='text/javascript'>
								
						$("#delete_const<?php echo $const_id;?>").click(function()
						{
							var const_name = "<?php echo $name;?>";
							var confirm = window.confirm("Are you sure you want to delete "+const_name);
							
							if(confirm == false){
								return false;
							}								
							else {
								var current_page = "<?php echo $current_page;?>";
								var per_page = "<?php echo $per_page;?>";
								var const_id ="<?php echo $const_id;?>";
								var data = "const="+const_id+"&current_page="+current_page+"&per_page="+per_page;
								
								$("#support_ajax_status").show();
								
								$.ajaxSetup(
								{
									beforeSend: function()
									{
										$("#support_ajax_status").html("Deleting "+const_name+" <img src='../images/loading_bar.gif'/>");
									},
									complete: function()
									{
										$("#support_ajax_status").html("").delay(2000).fadeOut("slow");
									}
								});
								
								$.ajax(
								{
									type: "POST",
									data: data,
									url: "../confirm?DeleteDepartment",
									cache:false,
									
									success: function(msg)
									{
										$("#ajax_status").show();
										$("#ajax_status").html(msg).delay(2000).fadeOut("slow");
									}
								});
							}
						});
						
						$("#edit_const<?php echo $const_id;?>").click(function()
						{
							$("#fetch_consts").html("");
							var current_page = "<?php echo $current_page;?>";
							var per_page = "<?php echo $per_page;?>";
							var const_id ="<?php echo $const_id;?>";
							var data = "const_id="+const_id+"&current_page="+current_page+"&per_page="+per_page;
							
							$("#support_ajax_status").show();
							$("#support_ajax_status").html("");
								
							$("#support_ajax_status").html("Retrieving details <img src='../images/loading_bar.gif'/>");
							
							$("#support_ajax_status").ajaxComplete(function()
							{
								$(this).html("").hide("fast").html("");
							});

							$.ajax(
							{
								type: "POST",
								data: data,
								url: "display?EditConstituency",
								cache:false,
								
								success: function(msg)
								{
									$("#display_constituencies").fadeOut(200);
									$("#edit_constituencies").html(msg);
									$("#edit_constituencies").fadeIn(500);
								}
							});
						});
						
					</script>
					
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $name;?></td>
						<td>
							<a href='#' id='edit_const<?php echo $const_id;?>' class='text-success'><i class='icon-pencil'></i> Edit</a> &nbsp; &nbsp;
							<a href='#' id='delete_const<?php echo $const_id;?>' class='text-danger'><i class='icon-remove'></i> Delete</a>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
				</table></div>			
				
			<?php
		}
	}
	
	