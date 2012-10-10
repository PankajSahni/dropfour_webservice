<?php
include("includes/config.php");

$response = array();
if(isset($_POST) && count($_POST) || 1){
	$json_data = stripslashes($_REQUEST['json_data'])	;
	$json_array = json_decode($json_data, true);
	if(isset($json_array) && count($json_array)){
	 	@extract($json_array);
	 	$sql_select = mysql_query("select * from user where fb_id = '".$fb_id."'") or die(mysql_error());
	 	$num = mysql_num_rows($sql_select);
	 	$line_select = mysql_fetch_array($sql_select);
	 	//print_r($line_select);

	 	$sql_player1 = mysql_query("select * from user where fb_id = '".$invited_by."'") or die(mysql_error());
	 	$res_player1 = mysql_fetch_array($sql_player1);
	 		
	 	$sql_chk_game = mysql_query("select * from game where (player_one in ('".$res_player1['id']."', '".$line_select['id']."') or player_two in ('".$res_player1['id']."', '".$line_select['id']."')) and status!=2") or die(mysql_error());
	 	$num_chk_game = mysql_num_rows($sql_chk_game);
	 	$line_chk_game = mysql_fetch_assoc($sql_chk_game);

	 	if(!mysql_num_rows($sql_select)){
	 		$sql = "insert into user set
	 					fb_id='".$fb_id."',
	 					name='".$name."',
	 					invited_by='".$invited_by."',
	 					created_at = '".date("Y-m-d H:i:s")."',
	 					updated_at = '".date("Y-m-d H:i:s")."'";
	 		$res = mysql_query($sql) or die(mysql_error());

	 		$line_select['id'] = mysql_insert_id();

	 		$sql = "insert into game set
		 				player_one = '".$res_player1['id']."',
		 				player_two = '".$line_select['id']."',
		 				status=0,
		 				turn = '".$line_select['id']."',
		 				created_at = '".date("Y-m-d H:i:s")."',
		 				updated_at = '".date("Y-m-d H:i:s")."'";
		 	
		 	mysql_query($sql) or die(mysql_error());

	 		$response['STATUS'] = "1";
	 		$response['MESSAGE'] = "Your friend invited join App!";
	 	}elseif($line_select['status']==1){
	 		
	 		//print_r($line_chk_game);
	 		if($num_chk_game && $line_chk_game['status']==0 && $line_chk_game['player_one']==$res_player1['id']){
	 			$response['STATUS'] = "0";
				$response['MESSAGE'] = "You have already invited him, waiting for his response!";
	 		}elseif($num_chk_game && $line_chk_game['status']==0 && $line_chk_game['player_one']==$line_select['id']){
	 			$response['STATUS'] = "0";
				$response['MESSAGE'] = "He has alraedy invited you, please accept hi game request!";
	 		}elseif($num_chk_game && $line_chk_game['status'] = "1"){
	 			$response['STATUS'] = "0";
				$response['MESSAGE'] = "You are already playing a game with him, please complete that game!";
	 		}elseif($num_chk_game == 0){
	 			$sql = "insert into game set
		 				player_one = '".$res_player1['id']."',
		 				player_two = '".$line_select['id']."',
		 				status=0,
		 				turn = '".$line_select['id']."',
		 				created_at = '".date("Y-m-d H:i:s")."',
		 				updated_at = '".date("Y-m-d H:i:s")."'";
		 		mysql_query($sql) or die(mysql_error());
		 		$response['STATUS'] = "1";
	 			$response['MESSAGE'] = "Your friend invited Play game with you!";
	 		}
	 	}else{
	 		$sql = "update user set updated_at='".date("Y-m-d H:i:s")."' where fb_id = '".$fb_id."'";
	 		mysql_query($sql) or die(mysql_error());
	 		$response['STATUS'] = "1";
			$response['MESSAGE'] = "Your friend already invited successfully, Posted on his wall on your behalf!";
	 	}

	}else{
	 	$response['STATUS'] = "0";
	 	$response['MESSAGE'] = "No data found in json parameter";
	}
}else{
	$response['STATUS'] = "0";
	$response['MESSAGE'] = "You are not using POST method to send data";
}
echo json_encode($response);
?>