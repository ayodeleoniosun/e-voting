
<?php
	//include connection file 
	 
	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;
		
 	if( !empty($params['search']['value']) ) 
	{   
		$name = $params['search']['value'];
		
		$queryRecords = $db_handle->prepare("SELECT *FROM `employee` WHERE employee_name LIKE '".$params['search']['value']."%' OR employee_salary LIKE '".$params['search']['value']."%'  OR employee_age LIKE '".$params['search']['value']."%' OR phone LIKE '".$params['search']['value']."%'");
		$queryRecords->execute();
		$totalRecords = $queryRecords->rowCount();
		$fetch_members = $queryRecords->fetchAll();
		
		foreach($fetch_members as $row)
		{
			$data[] = $row;
		}
	}
	else
	{
		$start = $params['start'];
		$length = $params['length'];
		
		/*
		$ordx = $columns[$params['order'][0]['column']];
		$ordy = $params['order'][0]['dir'];
		*/
		
		$queryRecords = $db_handle->prepare("SELECT *FROM `employee` ORDER BY `id` LIMIT $start,$length");
		$queryRecords->execute();
		$fetch_members = $queryRecords->fetchAll();
		
		$queryRecordx = $db_handle->prepare("SELECT *FROM `employee`");
		$queryRecordx->execute();
		$totalRecords = $queryRecordx->rowCount();
		
		foreach($fetch_members as $row)
		{
			$data[] = $row;
		}
	}
		
	$json_data = array(
			"draw"            => intval($params['draw'] ),   
			"recordsTotal"    => intval($totalRecords ),  
			"recordsFiltered" => intval($totalRecords),
			"data"            => $data   // total data array
			);

	echo json_encode($json_data);  // send data as json format
?>
	