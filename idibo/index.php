<?php 
require_once("../idibo.php");

if(isset($_POST['admin_login'])) 
{
  $username =  $_POST['username'];
  $password = md5(trim($_POST['password']));
  list($count,$ojuse) = check_admin_log_in($username,$password);
  
  if($count > 0)
  {
      if($ojuse == "1") {
        $_SESSION['tesojue_admin'] = $username;
        redirect_to("dashboard");
        echo success_admin_msg("Login successful. Please wait <img src='../assets/images/loading_bar.gif'/>");
      }
      else if($ojuse == "2") {
        $_SESSION['tesojue_electoral'] = $username;
        redirect_to("electoral_dashboard");
        echo success_admin_msg("Login successful. Please wait <img src='../assets/images/loading_bar.gif'/>");
      }
      else
      {
        echo error_admin_msg("Incorrect login details");
      }
  }
  else
  {
    echo error_admin_msg("Incorrect login details");
  }
}
?>
<!DOCTYPE html>
<head>
     <meta charset="UTF-8" />
    <title><?php echo $admin_title;?> | Login</title>
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

	<body oncontextmenu="return false;" style="background-image:url('../images/bg.png');display:inline-table;height:100vh">

  <div align='center'> <div id='support_ajax_status' class='support_status'> </div> </div>
	<div align='center'> <div id='ajax_status' class='support_status'> </div> </div>
  <!-- PAGE CONTENT --> 
    <?php
		
		if(isset($_SESSION['logged_out']))
		{
			?>
				<script>
					$(document).ready(function()
					{
						$("#support_ajax_status").show();
						$("#support_ajax_status").html("<i class='icon-check'></i> You've been logged out.").delay(3000).fadeOut("slow");
					});
				</script>
			<?php
      unset($_SESSION['logged_out']);
		}

	?>
	<div style="color:#fff;display:table-cell;vertical-align:middle;width:100vw">
    <div class="container"> 

      <form id="login_form" method="post" class="form-signin" autocomplete="off">
          <div align="center">
              <a href="../index" class="btn btn-sm btn-success" style="color:#fff"><i class="icon-arrow-left"></i> Home </a> 
          </div>
          <h2 align="center"> <?php echo $admin_head_title;?> Login </h2><br/>
  				<label>Username:</label>
            <input type="text" id="username" name="username" class="form-control"/>
            <br/><label>Password:</label>
            <input type="password" id="password" name="password" class="form-control"/><br/>
            <button type="submit" name="admin_login" class="btn text-muted text-center btn-success btn-block">Sign in <i class="icon-arrow-right"></i> </button>
      </form>
    </div>
  </div>
    
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

