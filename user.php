<?php
include("includes/config.php");
$response = array();

if(isset($_POST) && count($_POST) || 1){
	$current_date = date("Y-m-d H:i:s");

	$json_data = stripslashes($_REQUEST['json_data']);

	$json_array = json_decode($json_data,TRUE);

	if(isset($json_array) && count($json_array)){
		@extract($json_array);
		$res_select = mysql_query("select * from user where fb_id='$fb_id'") or die(mysql_error());
		if(!mysql_num_rows($res_select)){
			$sql_insert = "insert into user set fb_id='$fb_id',
				name='$name',
				status=1,
				invited_by=0,
				created_at='$current_date',
				updated_at='$current_date'";
			mysql_query($sql_insert) or die(mysql_error());
			$response['STATUS'] = "1";
			$response['MESSAGE'] = "Data inserted successfully!";
		}else{
			$sql_update = "update user set
				name='$name',
				status=1,
				updated_at='$current_date' where fb_id='$fb_id'";
			mysql_query($sql_update) or die(mysql_error());
			$response['STATUS'] = "1";
			$response['MESSAGE'] = "Data updated successfully!";
		}

	}else{
		$response['STATUS'] = "0";
		$response['MESSAGE'] = "No data found in json data";
	}

}else{
	$response['STATUS'] = "0";
	$response['MESSAGE'] = "You are not using POST method to send data";
}
echo json_encode($response);
?>