<?php
	
	require_once("../idibo.php");
	require_once("../image.php");

	if(isset($_GET["DisplayVotingKeys"]))
	{
		$keys_query  = $db_handle->prepare("SELECT *FROM `voting_keys` WHERE `voted` = '0' ORDER BY RAND() DESC LIMIT 0,50");
		$keys_query->execute();
		$count_keys = $keys_query->rowCount();
			
		if($count_keys == 0)
		{
			echo error_admin_msg("No voting keys yet.");
		}
		else
		{
			?>
				<h3 align="center"><i class="icon-key"></i> Use any of the voting keys below</h3>
				
				<?php
				
				$fetch_keys = $keys_query->fetchAll();
				
				foreach($fetch_keys as $row)
				{
					$keys = $row['keys'];
					echo "<div class='col-sm-2 col-md-2 col-xs-4' style='margin:10px'>".$keys."</div>";
				}
				?>
				</div>
				<div style="clear:both"></div>
			
			<?php
		}
		echo "<hr/>";
	}

	else if(isset($_GET["DisplayVoters"]))
	{
		$matric_query  = $db_handle->prepare("SELECT *FROM `voters` WHERE `voted` = '0' ORDER BY RAND() DESC LIMIT 0,50");
		$matric_query->execute();
		$count_matric = $matric_query->rowCount();
			
		if($count_matric == 0)
		{
			echo error_admin_msg("No voting keys yet.");
		}
		else
		{
			?>
				<h3 align="center"><i class="icon-key"></i> Use any of the voters' matric no below</h3>
				
				<?php
				$fetch_matric = $matric_query->fetchAll();
				
				foreach($fetch_matric as $row)
				{
					$matric = $row['matric'];
					echo "<div class='col-sm-2 col-md-2 col-xs-4' style='margin:10px'>".$matric."</div>";
				}
				?>
				</div>
				<div style="clear:both"></div>
		
			<?php
		}
	}
	
?>