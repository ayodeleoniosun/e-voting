<?php 
	require_once("../idibo.php");
	unset($_SESSION["tesojue_admin"]);
	$_SESSION["logged_out"] = "true";
?>
	<script>
		window.location = "index";
	</script>