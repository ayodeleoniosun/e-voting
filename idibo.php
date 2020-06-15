<?php

error_reporting(0);
session_start();

/*
DEFINE("DB_HOST","localhost");
DEFINE("DB_USERNAME","eurotops_root");
DEFINE("DB_PASSWORD","baddo^fatsssa_election2016-gbefun");
DEFINE("DB_NAME","eurotops_voting");
*/

DEFINE("DB_HOST","localhost");
DEFINE("DB_USERNAME","root");
DEFINE("DB_PASSWORD","");
DEFINE("DB_NAME","voting");

try{
	$db_handle = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."",DB_USERNAME,DB_PASSWORD);
}
catch(PDOException $error){
	echo $error->getMessage();
}

date_default_timezone_set("Africa/Lagos");
$admin_title = "Independence Hall Admin ";
$electoral_title = "Electoral Officer";
$admin_head_title = "Independence Hall Voting | Admin";
$student_title = "Independence Hall Voting | Students";
$student_head_title = "Independence Hall Voting | Students Login";
$vote_title = "Independence Hall Voting";
$current_date = date("d-m-Y");
$current_datex = date("m-d-Y");
$current_time = date("g:i A");
$election_date = "10-11-2016";
$hr_plus = date("g")+3;
$current_timex = date($hr_plus.":i A");
$cur_month = date("m");
$cur_month_name = date("F");
$cur_mth = date("F");
$cur_mth = strtolower($cur_mth);
$cur_year = date("Y");
$comment_per_page = "7";

function errors($msg)
{
	$error = "<span><i class='icon-remove'></i> $msg</span><br/>";
	return $error;
}

function successes($msg)
{
	$error = "<span><i class='icon-ok'></i> $msg</span><br/>";
	return $error;
}

function error_admin_msg($msg)
{
	$error = "<br/><div class='alert alert-danger ' align='center'> <i class='icon-remove'></i> $msg </div>";
	return $error;
}

function success_admin_msg($msg)
{
	$success = "<br/><div class='alert alert-success' align='center'> <i class='icon-ok'></i> $msg </div>";
	return $success;
}

function confirm_success($msg)
{
	?>
	<script>
		$("#msg").html("<div class='alert alert-success' align='center'> <i class='icon-ok'></i> $msg </div>").delay(3000).fadeOut("slow");
	</script>
	
	<?php
}

function redirect_to($link)
{
	?>
		<script type="text/javascript">
			window.location = "<?php echo $link;?>";
		</script>
	<?php
}

function redirect_time($seconds, $link)
{
	?>
		<meta http-equiv="refresh" content="<?php echo $seconds;?>;url=<?php echo $link;?>">
	<?php
}

function Generate_Random_Password($length)
{
	$allowed_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./^%?/&*@!$\,>.<'}{]()-+#";
	$length_chars = strlen($allowed_chars)-1;
	$shuffle_chars = str_shuffle($allowed_chars);
	$password = "";
	
	for($i = 0; $i < $length; $i++)
	{
		$random_int = mt_rand(0,$length);
		$password.= $shuffle_chars[$random_int % $length_chars];
	}
	return $password;
}

function combine_array($a, $b) 
{ 
	$acount = count($a); 
	$bcount = count($b); 
	$size = ($acount > $bcount) ? $bcount : $acount; 
	$a = array_slice($a, 0, $size); 
	$b = array_slice($b, 0, $size); 
	return array_combine($a, $b); 
} 


function Generate_Voting_Keys($length)
{
	$allowed_chars = "123456789342516879";
	$length_chars = strlen($allowed_chars)-1;
	$shuffle_chars = str_shuffle($allowed_chars);
	$password = "";
	
	for($i = 0; $i < $length; $i++)
	{
		$random_int = mt_rand(0,$length);
		$password.= $shuffle_chars[$random_int % $length_chars];
	}
	return $password;
}

//@#$%&*

function Generate_Random_Number($length)
{
	$allowed_chars = "ABCDEF01GHIJKLMNOPQ23RSTUVWX45YZabc67defghijklmnopqr89stuvwxyz";
	$length_chars = strlen($allowed_chars)-1;
	$shuffle_chars = str_shuffle($allowed_chars);
	$random_number = "";
	
	for($i = 0; $i < $length; $i++)
	{
		$random_int = mt_rand(0,$length);
		$random_number.= $shuffle_chars[$random_int % $length_chars];
	}
	return $random_number;
}

function Generate_Pin($numlen)
{
	$pastyear  = mktime(date("h"), date("i"), date("s"), date("m"), date("d"), date("Y")-50);

	$number_key = 3*(101*time());
	$st = strlen($number_key) - $numlen;
	$new_number_string = substr($number_key, $st, $numlen);
	$number_key = $new_number_string;
	
	$number_key2 = 3*(101*$pastyear);
	$st = strlen($number_key2) - $numlen;
	$new_number_string = substr($number_key2, $st, $numlen);
	$number_key2 = $new_number_string;

	return $number_key2;
}

function GetFileSize($bytes)
{
	$filesize_array = array("B", "KB" , "MB" , "GB" , "TB" , "PB" , "EB" , "ZB" , "YB");
	$filesize_index = 0;
	
	while($bytes >= 1024)
	{
		$bytes = $bytes/1024;
		$filesize_index++;
	}
	
	$formatted_filesize = number_format($bytes,2);
	$formatted_filesize = $formatted_filesize. " ".$filesize_array[$filesize_index];
	
	return $formatted_filesize;
}

function format_date_time($date_added)
{
	$split_date_posted = explode(" ",$date_added);
	$split_date = $split_date_posted[0];
	$split_time = $split_date_posted[1];

	$split_date_timestamp = strtotime($split_date);
	$converted_split_date_posted_timestamp = date("F jS, Y", $split_date_timestamp);

	$split_time_timestamp = strtotime($split_time);
	$converted_split_time_posted_timestamp = date("g:i A", $split_time_timestamp);
	
	$concatenate_date_time = $converted_split_date_posted_timestamp." at ".$converted_split_time_posted_timestamp;
	
	return $concatenate_date_time;
}

function format_date_only($date_added)
{
	$split_date_posted = explode(" ",$date_added);
	$split_date = $split_date_posted[0];
	$split_time = $split_date_posted[1];

	$split_date_timestamp = strtotime($split_date);
	$converted_split_date_posted_timestamp = date("F jS, Y", $split_date_timestamp);

	return $converted_split_date_posted_timestamp;
}

function format_date($date)
{
	$split_date_timestamp = strtotime($date);
	$converted_split_date_posted_timestamp = date("F jS, Y", $split_date_timestamp);

	return $converted_split_date_posted_timestamp;
}

function format_time($time)
{
	$split_time_timestamp = strtotime($time);
	$converted_split_time_posted_timestamp = date("g:i A", $split_time_timestamp);
	
	return $converted_split_time_posted_timestamp;
}

function get_dept_id($unique_id){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept_id` FROM `depts` WHERE `unique_id` = ?");
	$query->bindparam(1,$unique_id);
	$query->execute();
	$dept_id = $query->fetchColumn();
	return $dept_id;
}

function dept_exists($dept){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept_id` FROM `depts` WHERE `dept` = ?");
	$query->bindparam(1,$dept);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function dept_exist_in_db($dept_id,$dept_name){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept_id` FROM `depts` WHERE `dept_id` <> ? AND `dept`= ?");
	$query->bindparam(1,$dept_id);
	$query->bindparam(2,$dept_name);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true:false;
}

function get_dept_name($dept){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept` FROM `depts` WHERE `dept_id` = ?");
	$query->bindparam(1,$dept);
	$query->execute();
	$name = $query->fetchColumn();
	return ucfirst($name);
}

function get_post_name($post) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `post` FROM `posts` WHERE `post_id` = ?");
	$query->bindparam(1,$post);
	$query->execute();
	$name = $query->fetchColumn();
	return ucfirst($name);
}

function post_exists($position){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `post_id` FROM `posts` WHERE `post` = ?");
	$query->bindparam(1,$position);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function is_post_added(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `post_id` FROM `posts`");
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function is_dept_added(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept_id` FROM `depts`");
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function post_exist_in_db($position_id,$position_name){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `post_id` FROM `posts` WHERE `post_id` <> ? AND `post` = ?");
	$query->bindparam(1,$position_id);
	$query->bindparam(2,$position_name);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function aspirant_exists($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `aspirant_id` FROM `aspirants` WHERE `matric` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function floor_rep_exists($constituency) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `rep_id` FROM `floor_reps` WHERE `constituency` = ?");
	$query->bindparam(1,$constituency);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function floor_rep_exists_in_db($constituency,$id) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `rep_id` FROM `floor_reps` WHERE `constituency` = ? AND `rep_id` <> ?");
	$query->bindparam(1,$constituency);
	$query->bindparam(2,$id);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function aspirant_exists_in_db($matric,$id){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `aspirant_id` FROM `aspirants` WHERE `matric` = ? AND `aspirant_id` <> ?");
	$query->bindparam(1,$matric);
	$query->bindparam(2,$id);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function count_aspirants(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `aspirant_id` FROM `aspirants`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_floor_reps(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `rep_id` FROM `floor_reps`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_post_aspirants($post){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `aspirant_id` FROM `aspirants` WHERE `post_id` = ?");
	$query->bindparam(1,$post);
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_voters() {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_accredited() {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `accredit_id` FROM `accredited`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_voted(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `voted` = '1'");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_keys(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `keys_id` FROM `voting_keys`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_posts(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `post_id` FROM `posts`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_depts(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept_id` FROM `depts`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function count_constituencies(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `const_id` FROM `constituencies`");
	$query->execute();
	$count = $query->rowCount();
	return $count;
}

function voter_exists($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function accredited_voter_exists($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `accredit_id` FROM `accredited` WHERE `matric` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function is_voter_accredited($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `accredit_id` FROM `accredited` WHERE `matric` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function is_voter_pin_attached($voter,$pin){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `accredit_id` FROM `accredited` WHERE `matric` = ? AND `pin` = ?");
	$query->bindparam(1,$voter);
	$query->bindparam(2,$pin);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function accredited_voter_pin_exists($pin) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `accredit_id` FROM `accredited` WHERE `pin` = ?");
	$query->bindparam(1,$pin);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function voter_phone_exists($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `phone` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function voter_matric_exists_in_db($voter,$id){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` = ? AND `voters_id` <> ?");
	$query->bindparam(1,$voter);
	$query->bindparam(2,$id);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function voter_phone_exists_in_db($voter,$id){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `phone` = ? AND `voters_id` <> ?");
	$query->bindparam(1,$voter);
	$query->bindparam(2,$id);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function admin_exists($admin){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `agbara_id` FROM `alagbara` WHERE `oruko_nla` = ?");
	$query->bindparam(1,$admin);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function check_admin_log_in($admin,$password) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `alagbara` WHERE `oruko_nla` = ? AND `kokoro`= ?");
	$query->bindparam(1,$admin);
	$query->bindparam(2,$password);
	$query->execute();
	$details = array();
	$count = $query->rowCount();
	return ($count > 0) ? true: false;
}

function admin_exists_in_db($admin,$id){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `agbara_id` FROM `alagbara` WHERE `oruko_nla` = ? AND `agbara_id` = ?");
	$query->bindparam(1,$admin);
	$query->bindparam(2,$id);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function is_key_used($key){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `keys_id` FROM `voting_keys` WHERE `keys` = ? AND `voted` = '1'");
	$query->bindparam(1,$key);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function is_settings_exist(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `settings_id` FROM `settings`");
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function get_election_settings(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `settings`");
	$query->execute();
	$count = $query->rowCount();
	$election_details = array();
	
	if($count > 0)
	{
		$fetch = $query->fetchAll();
		
		foreach($fetch as $row) {
			$start_date = $row['election_date'];
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
			
			$election_details[] = $start_date;
			$election_details[] = $start_time;
			$election_details[] = $end_time;
			
		}
		return $election_details;
	}
}

function get_key_used($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `keys` FROM `voting_keys` WHERE `used_by` = ? AND `voted` = '1'");
	$query->bindparam(1,$voter);
	$query->execute();
	$key = $query->fetchColumn();
	return $key;
}

function is_key_exists($key){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `keys_id` FROM `voting_keys` WHERE `keys` = ?");
	$query->bindparam(1,$key);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true:false;
}

function is_voter_exist($matric){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` = ?");
	$query->bindparam(1,$matric);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true:false;
}

function is_voter_voted($matric){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` = ? AND `voted` = '1'");
	$query->bindparam(1,$matric);
	$query->execute();
	$count = $query->rowCount();
	return ($count > 0)? true : false;
}

function voter_voted_on($matric){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voted_on` FROM `voters` WHERE `matric` = ? AND `voted` = '1'");
	$query->bindparam(1,$matric);
	$query->execute();
	$voted_on = $query->fetchColumn();
	return $voted_on;
}

function voter_key_used($matric){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `key_used` FROM `voters` WHERE `matric` = ? AND `voted` = '1'");
	$query->bindparam(1,$matric);
	$query->execute();
	$key_used = $query->fetchColumn();
	return $key_used;
}

function is_voter_qualified($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `qualify` FROM `voters` WHERE `voters_id` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$qualify = $query->fetchColumn();
	return ($qualify == "1")? true : false;
}

function is_voter_matric_qualified($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `qualify` FROM `voters` WHERE `matric` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$qualify = $query->fetchColumn();
	return ($qualify == "1")? true : false;
}

function is_aspirant_qualified($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `qualify` FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$qualify = $query->fetchColumn();
	return ($qualify == "1")? true : false;
}

function is_rep_qualified($rep){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `qualify` FROM `floor_reps` WHERE `rep_id` = ?");
	$query->bindparam(1,$rep);
	$query->execute();
	$qualify = $query->fetchColumn();
	return ($qualify == "1")? true : false;
}

function get_voter_details($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `voters` WHERE `voters_id` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$count = $query->rowCount();
	$voter_details = array();
	
	if($count > 0){
		$fetch_voters = $query->fetchAll();
		
		foreach($fetch_voters as $row) {
			$surname = ucfirst($row['surname']);
			$firstname = ucfirst($row['firstname']);
			$othername = ucfirst($row['othername']);
			$matric = $row['matric'];
			$constituency = $row['constituency'];
			$phone = $row['phone'];
			$email = $row['email'];
			$dept_id = $row['dept_id'];
			$level = $row['level'];
			
			$voter_details[] = $surname;
			$voter_details[] = $firstname;
			$voter_details[] = $othername;
			$voter_details[] = $matric;
			$voter_details[] = $phone;
			$voter_details[] = $email;
			$voter_details[] = $dept_id;
			$voter_details[] = $level;
			$voter_details[] = $constituency;
		}
		return $voter_details;
	}
}

function get_voter_matric($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `matric` FROM `voters` WHERE `voters_id` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$matric = $query->fetchColumn();
	return $matric;
}

function get_voter_constituency($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `constituency` FROM `voters` WHERE `voters_id` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$constituency = $query->fetchColumn();
	return $constituency;
}

function get_the_voter_constituency($voter){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `constituency` FROM `voters` WHERE `matric` = ?");
	$query->bindparam(1,$voter);
	$query->execute();
	$constituency = $query->fetchColumn();
	return $constituency;
}

function get_aspirant_details($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$count = $query->rowCount();
	$aspirant_details = array();
	
	if($count > 0){
		$fetch_aspirants = $query->fetchAll();
		
		foreach($fetch_aspirants as $row) 
		{
			$unique_id = $row['unique_id'];
			$fullname = $row['fullname'];
			$matric = "";
			$dept_id = "";
			$level = "";
			$post_id = $row['post_id'];
			$votes = $row['votes'];
			$nickname = ucfirst($row['nickname']);
			$path = $row['path'];

			$aspirant_details[] = $fullname;
			$aspirant_details[] = $matric;
			$aspirant_details[] = $unique_id;
			$aspirant_details[] = $post_id;
			$aspirant_details[] = $nickname;
			$aspirant_details[] = $dept_id;
			$aspirant_details[] = $level;
			$aspirant_details[] = $votes;
			$aspirant_details[] = $path;
			
		}
		return $aspirant_details;
	}
}

function get_floor_rep_details($rep){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `floor_reps` WHERE `rep_id` = ?");
	$query->bindparam(1,$rep);
	$query->execute();
	$count = $query->rowCount();
	$rep_details = array();
	
	if($count > 0){
		$fetch_reps = $query->fetchAll();
		
		foreach($fetch_reps as $row) 
		{
			$unique_id = $row['unique_id'];
			$fullname = $row['fullname'];
			$constituency = $row['constituency'];
			$votes = $row['votes'];
			$nickname = ucfirst($row['nickname']);
			$path = $row['path'];

			$rep_details[] = $fullname;
			$rep_details[] = $unique_id;
			$rep_details[] = $nickname;
			$rep_details[] = $constituency;
			$rep_details[] = $votes;
			$rep_details[] = $path;
		}
		return $rep_details;
	}
}


function get_aspirant_unique_id($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `unique_id` FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$unique_id = $query->fetchColumn();
	return $unique_id;	
}

function get_rep_unique_id($rep){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `unique_id` FROM `floor_reps` WHERE `rep_id` = ?");
	$query->bindparam(1,$rep);
	$query->execute();
	$unique_id = $query->fetchColumn();
	return $unique_id;	
}

function get_floor_rep_preview_details($rep){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `floor_reps` WHERE `rep_id` = ?");
	$query->bindparam(1,$rep);
	$query->execute();
	$count = $query->rowCount();
	$rep_details = array();
	
	if($count > 0){
		$fetch_reps = $query->fetchAll();
		
		foreach($fetch_reps as $row) 
		{
			$fullname = $row['fullname'];
			$constituency = $row['constituency'];
			$nickname = ucfirst($row['nickname']);
			$path = $row['path'];

			$rep_details[] = $fullname;
			$rep_details[] = $nickname;
			$rep_details[] = $path;
		}
		return $rep_details;
	}
}

function get_aspirant_preview_details($aspirant)
{
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$count = $query->rowCount();
	$aspirant_details = array();
	
	if($count > 0)
	{
		$fetch_aspirants = $query->fetchAll();
		
		foreach($fetch_aspirants as $row) 
		{
			$aspirant_student_id = "";
			$fullname = ucwords($row['fullname']);
			$dept_id = "";
			$dept_name = "";
			$level = "";
			$course = $dept_name."/".$level."L";
			$nickname = ucfirst($row['nickname']);
			$path = $row['path'];
			
			$aspirant_details[] = $fullname;
			$aspirant_details[] = $path;
			$aspirant_details[] = $nickname;
			$aspirant_details[] = $course;
		}
		return $aspirant_details;
	}
}

function get_aspirant_course($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `dept_id`,`level` FROM `voters` WHERE `voters_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$count = $query->rowCount();
	$aspirant_details = array();
	
	if($count > 0)
	{
		$fetch_aspirants = $query->fetchAll();
		
		foreach($fetch_aspirants as $row) 
		{
			$dept_id = $row['dept_id'];
			$level = $row['level'];
			$dept_name = get_dept_name($dept_id);
			$course = $level."L / ".$dept_name;
			return $course;			
		}
	}
}

function old_get_aspirant_preview_details($aspirant)
{
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$count = $query->rowCount();
	$aspirant_details = array();
	
	if($count > 0)
	{
		$fetch_aspirants = $query->fetchAll();
		
		foreach($fetch_aspirants as $row) 
		{
			$aspirant_student_id = $row['aspirant_student_id'];
			$fullname = get_student_fullname($aspirant_student_id);
			$post_id = $row['post_id'];
			$nickname = ucfirst($row['nickname']);
			$path = $row['path'];
			$course = get_aspirant_course($aspirant_student_id);

			$aspirant_details[] = $fullname;
			$aspirant_details[] = $path;
			$aspirant_details[] = $nickname;
			$aspirant_details[] = $course;
		}
		return $aspirant_details;
	}
}

function get_aspirant_post($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `post_id` FROM `aspirants` WHERE `aspirant_student_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$post = $query->fetchColumn();
	return $post;
}

function get_student_id_from_aspirant($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `aspirant_student_id` FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$post = $query->fetchColumn();
	return $post;
}

function count_aspirant_votes($aspirant){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `votes` FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$votes = $query->fetchColumn();
	return $votes;
}

function count_post_votes($post){
	global $db_handle;
	$all_votes = 0;
	$query = $db_handle->prepare("SELECT `votes` FROM `aspirants` WHERE `post_id` = ?");
	$query->bindparam(1,$post);
	$query->execute();
	$fetch_posts = $query->fetchAll();
	
	foreach($fetch_posts as $row) 
	{
		$votes = $row['votes'];
		$all_votes+=$votes;
	}
	return $all_votes;
}

function count_post_against_votes($post){
	global $db_handle;
	$all_votes_against = 0;
	$query = $db_handle->prepare("SELECT `against` FROM `aspirants` WHERE `post_id` = ?");
	$query->bindparam(1,$post);
	$query->execute();
	$fetch_posts = $query->fetchAll();
	
	foreach($fetch_posts as $row) 
	{
		$against = $row['against'];
		$all_votes_against+=$against;
	}
	return $all_votes_against;
}

function count_constituency_votes($constituency){
	global $db_handle;
	$all_votes = 0;
	$query = $db_handle->prepare("SELECT `votes` FROM `floor_reps` WHERE `constituency` = ?");
	$query->bindparam(1,$constituency);
	$query->execute();
	$fetch_items = $query->fetchAll();
	
	foreach($fetch_items as $row) 
	{
		$votes = $row['votes'];
		$all_votes+=$votes;
	}
	return $all_votes;
}

function count_constituency_against_votes($constituency){
	global $db_handle;
	$all_votes_against = 0;
	$query = $db_handle->prepare("SELECT `against` FROM `floor_reps` WHERE `constituency` = ?");
	$query->bindparam(1,$constituency);
	$query->execute();
	$fetch_items = $query->fetchAll();
	
	foreach($fetch_items as $row) 
	{
		$against = $row['against'];
		$all_votes_against+=$against;
	}
	return $all_votes_against;
}

function count_aspirant_against_votes($aspirant) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `against` FROM `aspirants` WHERE `aspirant_id` = ?");
	$query->bindparam(1,$aspirant);
	$query->execute();
	$votes = $query->fetchColumn();
	return $votes;
}

function count_aspirant_void_votes($post_id) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voids` FROM `void_executives_votes` WHERE `post_id` = ?");
	$query->bindparam(1,$post_id);
	$query->execute();
	$votes = $query->fetchColumn();
	return $votes;
}

function count_floor_rep_votes($rep) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `votes` FROM `floor_reps` WHERE `rep_id` = ?");
	$query->bindparam(1,$rep);
	$query->execute();
	$votes = $query->fetchColumn();
	return $votes;
}

function count_floor_rep_void_votes($constituency) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voids` FROM `void_rep_votes` WHERE `constituency` = ?");
	$query->bindparam(1,$constituency);
	$query->execute();
	$votes = $query->fetchColumn();
	return $votes;
}


function count_floor_rep_against_votes($rep) {
	global $db_handle;
	$query = $db_handle->prepare("SELECT `against` FROM `floor_reps` WHERE `rep_id` = ?");
	$query->bindparam(1,$rep);
	$query->execute();
	$votes = $query->fetchColumn();
	return $votes;
}

function get_student_id($student){
	global $db_handle;
	$query = $db_handle->prepare("SELECT `voters_id` FROM `voters` WHERE `matric` = ?");
	$query->bindparam(1,$student);
	$query->execute();
	$post = $query->fetchColumn();
	return $post;
}

function get_all_aspirant_posts()
{
	global $db_handle;
	$query = $db_handle->prepare("SELECT DISTINCT `post_id` FROM `aspirants`");
	$query->execute();
	$count = $query->rowCount();
	$post_array = array();

	if($count == 0) {
		echo error_admin_msg("No aspirant yet.");
	}
	else
	{
		$fetch = $query->fetchAll();
		
		foreach($fetch as $row) 
		{
			$post = $row['post_id'];
			$post_array[] = $post;
		}
	}
	return $post_array;
}

function get_other_halls($hall){
	global $db_handle;
	$query  = $db_handle->prepare("SELECT *FROM `halls` WHERE `halls_id` <> ?");
	$query->bindparam(1,$hall);
	$query->execute();
	$count = $query->rowCount();
	$fetch_other_halls = $query->fetchAll();
	$details = array();
	$details[] = $fetch_other_halls;
	$details[] = $count;
	return $details;
}

function get_student_fullname($student){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `voters` WHERE `voters_id` = ?");
	$query->bindparam(1,$student);
	$query->execute();
	$count = $query->rowCount();
	
	if($count > 0)
	{
		$fetch_voters = $query->fetchAll();
		
		foreach($fetch_voters as $row) {
			$surname = ucfirst($row['surname']);
			$firstname = ucfirst($row['firstname']);
			$othername = ucfirst($row['othername']);
			$fullname = $surname." ".$firstname." ".$othername;
			return $fullname;
		}
	}
}

function fetch_selected_depts($dept){
	global $db_handle;
	
	$query  = $db_handle->prepare("SELECT *FROM `depts` WHERE `dept_id` = ?");
	$query->bindparam(1,$dept);
	$query->execute();
	$count = $query->rowCount();
	
	$select = "<select class='form-control' id='dept' name='dept'>";
	
	if($count > 0)
	{
		$name = get_dept_name($dept);
		$select.= "<option value='$dept'> $name </option>";
		
		$other_dept_query  = $db_handle->prepare("SELECT *FROM `depts` WHERE `dept_id` <> ?");
		$other_dept_query->bindparam(1,$dept);
		$other_dept_query->execute();
		$fetch_other_depts = $other_dept_query->fetchAll();
		
		foreach($fetch_other_depts as $dept_row)
		{
			$dept_id = $dept_row['dept_id'];
			$dept_name = ucfirst($dept_row['dept']);
			
			$select.= "<option value='$dept_id'>$dept_name</option>";
		}
	}
	else
	{
		$new_query  = $db_handle->prepare("SELECT *FROM `depts` ORDER BY `dept`");
		$new_query->execute();
		$fetch_new_depts = $new_query->fetchAll();
		$select.= "<option value=''> --  Select department -- </option>";
		
		foreach($fetch_new_depts as $new_row)
		{
			$new_dept_id = $new_row['dept_id'];
			$new_dept_name = ucfirst($new_row['dept']);
			
			$select.= "<option value='$new_dept_id'>$new_dept_name</option>";
		}
	}
	$select.= "<select>";
	
	return $select;
}


function fetch_selected_posts($post){
	global $db_handle;
	
	$query  = $db_handle->prepare("SELECT *FROM `posts` WHERE `post_id` = ?");
	$query->bindparam(1,$post);
	$query->execute();
	$count = $query->rowCount();
	
	$select = "<select class='form-control' id='post' name='post'>";
	
	if($count > 0)
	{
		$name = get_post_name($post);
		$select.= "<option value='$post'> $name </option>";
		
		$other_post_query  = $db_handle->prepare("SELECT *FROM `posts` WHERE `post_id` <> ?");
		$other_post_query->bindparam(1,$post);
		$other_post_query->execute();
		$fetch_other_posts = $other_post_query->fetchAll();
		
		foreach($fetch_other_posts as $post_row)
		{
			$post_id = $post_row['post_id'];
			$post_name = ucfirst($post_row['post']);
			
			$select.= "<option value='$post_id'>$post_name</option>";
		}
	}
	else
	{
		$new_query  = $db_handle->prepare("SELECT *FROM `posts` ORDER BY `post`");
		$new_query->execute();
		$fetch_new_posts = $new_query->fetchAll();
		$select.= "<option value=''> --  Select post -- </option>";
		
		foreach($fetch_new_posts as $new_row)
		{
			$new_post_id = $new_row['post_id'];
			$new_post_name = ucfirst($new_row['post']);
			
			$select.= "<option value='$new_post_id'>$new_post_name</option>";
		}
	}
	$select.= "<select>";
	
	return $select;
}

function fetch_selected_constituencies($constituency){
	global $db_handle;
	
	$query  = $db_handle->prepare("SELECT *FROM `constituencies` WHERE `name` = ?");
	$query->bindparam(1,$constituency);
	$query->execute();
	$count = $query->rowCount();
	
	$select = "<select class='form-control' id='constituency' name='constituency'>";
	
	if($count > 0)
	{
		$select.= "<option value='$constituency'> $constituency </option>";
		
		$other_query  = $db_handle->prepare("SELECT *FROM `constituencies` WHERE `name` <> ?");
		$other_query->bindparam(1,$constituency);
		$other_query->execute();
		$fetch_other_items = $other_query->fetchAll();
		
		foreach($fetch_other_items as $row)
		{
			$the_constituency = $row['name'];
			
			$select.= "<option value='$the_constituency'>".strtoupper($the_constituency)."</option>";
		}
	}
	else
	{
		$new_query  = $db_handle->prepare("SELECT *FROM `constituencies` ORDER BY `const_id`");
		$new_query->execute();
		$fetch_new_items = $new_query->fetchAll();
		$select.= "<option value=''> --  Select constituency -- </option>";
		
		foreach($fetch_new_items as $new_row)
		{
			$new_const = $new_row['name'];
			$select.= "<option value='$new_const'>".strtoupper($new_const)."</option>";
		}
	}
	$select.= "<select>";
	
	return $select;
}

function get_admin_id($admin)
{
	global $db_handle;
	$query = $db_handle->prepare("SELECT `agbara_id` FROM `alagbara` WHERE `oruko_nla` = ?");
	$query->bindparam(1,$admin);
	$query->execute();
	$admin_id = $query->fetchColumn();
	return $admin_id;
}

function get_admin_password($admin_id)
{
	global $db_handle;
	$query = $db_handle->prepare("SELECT `kokoro` FROM `alagbara` WHERE `agbara_id` = ?");
	$query->bindparam(1,$admin_id);
	$query->execute();
	$password = $query->fetchColumn();
	return $password;
}

function fetch_all_depts(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `depts` ORDER BY `dept`");
	$query->execute();
	$count = $query->rowCount();
	
	if($count > 0){
		$fetch_depts = $query->fetchAll();
		echo "<select class='form-control chzn-select' tabindex='2' id='dept' name='dept'>
		<option value=''> --  Select department -- </option>";
		
		foreach($fetch_depts as $row)
		{
			$dept_id = $row['dept_id'];
			$name = $row['dept'];
			
			echo "<option value='$dept_id'>$name</option>";
		}
		echo "<select>";
	}
}

function fetch_all_voters(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `voters` ORDER BY `surname`");
	$query->execute();
	$count = $query->rowCount();
	
	if($count > 0){
		$fetch_voters = $query->fetchAll();
		echo "<select data-placeholder='Select an aspirant' id='aspirant' name='aspirant' class='form-control chzn-select' tabindex=2'>
		<option value=''> --  Select an aspirant -- </option>";
		
		foreach($fetch_voters as $row)
		{
			$voters_id = $row['voters_id'];
			$surname = ucfirst($row['surname']);
			$firstname = ucfirst($row['firstname']);
			$othername = ucfirst($row['othername']);
			$fullname = $surname." ".$firstname." ".$othername;

			echo "<option value='$voters_id'>$fullname</option>";
		}
		echo "<select>";
	}
}

function fetch_all_posts(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `posts` ORDER BY `post`");
	$query->execute();
	$count = $query->rowCount();
	
	if($count > 0){
		$fetch_voters = $query->fetchAll();
		echo "<select data-placeholder='Select a post' id='post' name='post' class='form-control chzn-select' tabindex=2'>
		<option value=''> --  Select a post -- </option>";
		
		foreach($fetch_voters as $row)
		{
			$post_id = $row['post_id'];
			$post = ucfirst($row['post']);
			echo "<option value='$post_id'>$post</option>";
		}
		echo "<select>";
	}
}

function fetch_all_constituencies(){
	global $db_handle;
	$query = $db_handle->prepare("SELECT *FROM `constituencies` ORDER BY `const_id`");
	$query->execute();
	$count = $query->rowCount();
	
	if($count > 0){
		$fetch_items = $query->fetchAll();
		echo "<select data-placeholder='Select a constituency' id='constituency' name='constituency' class='form-control chzn-select' tabindex=2'>
		<option value=''> --  Select a constituency -- </option>";
		
		foreach($fetch_items as $row)
		{
			$item_id = $row['const_id'];
			$item = ucfirst($row['name']);
			echo "<option value='$item'>$item</option>";
		}
		echo "<select>";
	}
}

function time_ago($time_ago)
{
	$time_diff = time() - $time_ago;
	$seconds = $time_diff;
	$minutes = round($time_diff/60);
	$hours = round($time_diff/3600);
	$days = round($time_diff/86400);
	$weeks = round($time_diff/604800);
	$months = round($time_diff/2419200);
	$years = round($time_diff/29030400);
	
	if($seconds <= 60)
	{
		if($seconds < 2)
		{
			return $seconds. " second ago";
		}
		else
		{
			return $seconds . " seconds ago";
		}
	}
	else if($minutes <= 60)
	{
		if($minutes == 1)
		{
			return "1 minute ago";
		}
		else
		{
			return $minutes. " minutes ago";
		}
	}
	else if($hours <= 24)
	{
		if($hours == 1)
		{
			return "1 hour ago";
		}
		else
		{
			return $hours. " hours ago";
		}
	}
	else if($days <= 7)
	{
		if($days == 1)
		{
			return "1 day ago";
		}
		else
		{
			return $days. " days ago";
		}
	}
	else if($weeks <= 4)
	{
		if($weeks == 1)
		{
			return "1 week ago";
		}
		else
		{
			return $weeks. " weeks ago";
		}
	}
	else if($months <= 12)
	{
		if($months == 1)
		{
			return "1 month ago";
		}
		else
		{
			return $months. " months ago";
		}
	}
	else
	{
		if($years == 1)
		{
			return "1 year ago";
		}
		else
		{
			return $years. " years ago";
		}
	}
}

function prog_day_diff($date)
{
	$days = round($date/86400);
	
	if($days == 0)
	{
		return "Programme ends the same day";
	}
	if($days == 1)
	{
		return "1 day";
	}
	else
	{
		return $days. " days";
	}
}
?>
