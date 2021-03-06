<?php
include("includes/config.php");

$json_data = json_decode(stripslashes($_REQUEST['json_data']), true);

$response = array();

if(isset($json_data) && count($json_data) && $json_data['fb_id']!=''){
	$fb_id = $json_data['fb_id'];
	$game_invite_sql = "select g.id game_id, g.created_at created_date, u.* from game g inner join user u on g.player_one=u.id where g.player_two in (select id from user u where u.fb_id = '".$fb_id."') and g.status=0";
	$game_invite_res = mysql_query($game_invite_sql) or die(mysql_error());
	$game_invites = array();
	while($game_invite_line = mysql_fetch_assoc($game_invite_res)){
		$time = calculateTime($game_invite_line['created_date']);
		$game_invites[] = array('game_id' => $game_invite_line['game_id'], 'id' => $game_invite_line['fb_id'], 'name' => $game_invite_line['name'], 'time'=>$time);
	}
	$response['game_invites'] = $game_invites;

	$my_turn_sql = "select g.id game_id, g.created_at created_date, u.* from game g inner join user u on g.player_one=u.id where g.turn in (select id from user u where u.fb_id = '".$fb_id."') and g.status=1";
	$my_turn_res = mysql_query($my_turn_sql) or die(mysql_error());
	$my_turns = array();
	while($my_turn_line = mysql_fetch_assoc($my_turn_res)){
		$time = calculateTime($my_turn_line['created_date']);
		$my_turns[] = array('game_id' => $my_turn_line['game_id'], 'id' => $my_turn_line['fb_id'], 'name' => $my_turn_line['name'], 'time'=>$time);
	}
	$response['my_turns'] = $my_turns;

	$their_turn_sql = "select g.id game_id, g.created_at created_date, u.* from game g inner join user u on g.player_one=u.id where (g.player_one in (select id from user u where u.fb_id = '".$fb_id."') or g.player_two in (select id from user u where u.fb_id = '".$fb_id."')) and g.turn not in (select id from user u where u.fb_id = '".$fb_id."') and g.status=1";
	$their_turn_res = mysql_query($their_turn_sql) or die(mysql_error());
	$their_turns = array();
	while($their_turn_line = mysql_fetch_assoc($their_turn_res)){
		$time = calculateTime($their_turn_line['created_date']);
		$their_turns[] = array('game_id' => $their_turn_line['game_id'], 'id' => $their_turn_line['fb_id'], 'name' => $their_turn_line['name'], 'time'=>$time);
	}
	$response['their_turns'] = $their_turns;

}else{
	$response['STATUS'] = "0";
	$response['MESSAGE'] = "Facebook Id is not provided!";
}



echo json_encode($response);
?>