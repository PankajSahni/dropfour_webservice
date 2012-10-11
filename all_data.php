<?php
include("includes/config.php");

$json_data = json_decode(stripslashes($_REQUEST['json_data']), true);

$response = array();

if(isset($json_data) && count($json_data) && $json_data['fb_id']!=''){
	$fb_id = $json_data['fb_id'];
	$game_invite_sql = "select * from game g inner join user u on g.player_one=u.id where g.player_two in (select id from user u where u.fb_id = '".$fb_id."' and g.status=0)";
	$game_invite_res = mysql_query($game_invite_sql) or die(mysql_error());
	$game_invites = array();
	while($game_invite_line = mysql_fetch_assoc($game_invite_res)){
		$game_invites[] = array($game_invite_line['fb_id'], $game_invite_line['name']);
	}
	$response['game_invites'] = $game_invites;

}else{
	$response['STATUS'] = "0";
	$response['MESSAGE'] = "Facebook Id is not provided!";
}



echo json_encode($response);
?>