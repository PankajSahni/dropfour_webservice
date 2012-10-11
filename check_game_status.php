<?php 
include("includes/config.php");
$json_data = json_decode(stripslashes($_REQUEST['json_data']), true);
$response = array();

if(isset($json_data) && count($json_data) && $json_data['game_id']!=''){
	$my_fb_id = $json_data['my_fb_id'];
	$opponent_fb_id = $json_data['opponent_fb_id'];
	$game_id = $json_data['game_id'];
	
	$sql_game = "select * from game where id = '".$game_id."'";
	$res_game = mysql_query($sql_game) or die(mysql_error());
	$line_game = mysql_fetch_assoc($res_game);

	$response['game_data'] = $line_game;

	$sql_my = "select * from user where fb_id = '".$my_fb_id."'";
	$res_my = mysql_query($sql_my) or die(mysql_error());
	$line_my = mysql_fetch_assoc($res_my);

	$response['my_data'] = $line_my;

	$sql_opp = "select * from user where fb_id = '".$opponent_fb_id."'";
	$res_opp = mysql_query($sql_opp) or die(mysql_error());
	$line_opp = mysql_fetch_assoc($res_opp);

	$response['opponent_data'] = $line_opp;		


}else{
	$response['STATUS'] = "0";
	$response['MESSAGE'] = "Game Id is not provided!";
}



echo json_encode($response);


?>