<?php
include("includes/config.php");

$fb_id = $_REQUEST['fb_id'];

$response = array();

$game_invite_res = mysql_query("select * from game g inner join user u on g.player_two=u.id where u.fb_id = '".$fb_id."' and g.status=0") or die(mysql_error());
$game_invites = array();
while($game_invite_line = mysql_fetch_assoc($game_invite_res)){
	$game_invites[] = array($game_invite_line['fb_id'], $game_invite_line['name']);
}
$response['game_invites'] = $game_invites;

echo json_encode($response);
?>