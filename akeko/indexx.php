<?php require_once("../idibo.php");?>
<!DOCTYPE html>
<head>
     <meta charset="UTF-8" />
    <title><?php echo $student_title;?> | Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
     <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/login.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/plugins/magic/magic.css" />
    <script src="../assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="../assets/js/jquery.confirm.js" type="text/javascript"></script>
    <script src="../assets/js/idibo.js" type="text/javascript"></script>
   <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    
</head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->

	<!--<body style="background-image:url('../images/bgx.jpg')">-->
  <body style="background-image:url('../images/bg.png')">
	
   <div align='center'> <div id='support_ajax_status' class='support_status'> </div> </div>
	<div align='center'> <div id='ajax_status' class='support_status'> </div> </div>
  <br/>
	<!-- PAGE CONTENT --> 
    <?php
		
		if(isset($_SESSION['voted_out']))
		{
			?>
				<script>
					$(document).ready(function()
					{
						$("#support_ajax_status").show();
						$("#support_ajax_status").html("<i class='icon-check'></i> Thanks for voting. Bye bye!").delay(4000).fadeOut("slow");
					});
				</script>
			<?php
      unset($_SESSION['voted_out']);
		}
	?>
	
	    <div class="col-sm-4 col-md-4 col-xs-12 container">
        <br/><form id="student_login_form" method="post" class="form-signin" autocomplete="off">
            <div align="center">
                <a href="../index" class="btn btn-sm btn-info" style="color:#fff"><i class="icon-arrow-left"></i> Home </a> 
            </div>
            <h2 align="center"> <?php echo $student_head_title;?></h2>
            <hr/>
            <div align="center">
              <i> Login below with your matric number and the voting code given to you </i>
            </div>
            <br/>
            <label>Matric Number:</label>
              <input type="text" id="matric" name="matric" class="form-control"/>
              <br/><label>Voting code:</label>
              <input type="text" id="key" name="key" class="form-control" maxlength="7"  onkeypress="return disableSpecialChars(event)"/><br/>
              <button class="btn text-muted text-center btn-info btn-block" type="submit">Sign in &raquo;</button>
        </form>
      </div> <br/><br/>
      
      
      
    </div>

    
    
	  <!--END PAGE CONTENT -->     
	      
      <!-- PAGE LEVEL SCRIPTS -->
      <script src="../assets/plugins/jquery-2.0.3.min.js"></script>
      <script src="../assets/plugins/bootstrap/js/bootstrap.js"></script>
   <script src="../assets/js/login.js"></script>
      <!--END PAGE LEVEL SCRIPTS -->

</body>
    <!-- END BODY -->
</html>
