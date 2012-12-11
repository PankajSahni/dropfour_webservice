<?php

include("includes/config.php");
$response = array();
$array_turn_rows = array();
$json_data = stripslashes($_REQUEST['json_data']);
$json_array = json_decode($json_data, TRUE);
$game_id = $json_array['game_id'];
$query_get_all_turns_for_game = mysql_query("SELECT * FROM turns WHERE game_id = '$game_id' order by id desc ".($json_array['action']=='LASTTURN'?' Limit 0, 1':''));
if (mysql_num_rows($query_get_all_turns_for_game) > 0) {
    while ($query_get_all_turns_for_game_row = mysql_fetch_array($query_get_all_turns_for_game)) {
        $array_turn_rows[] = $query_get_all_turns_for_game_row;
    }
    $response['STATUS'] = "1";
    $response['TURNS'] = $array_turn_rows;
    $response['MESSAGE'] = "turns found";
}
 else {
    $response['STATUS'] = "0";
    $response['TURNS'] = "";
    $response['MESSAGE'] = "Game Not Started Yet";
}
echo json_encode($response);
?>
