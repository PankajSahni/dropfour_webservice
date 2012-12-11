<?php

include("includes/config.php");
$response = array();
$json_data = stripslashes($_REQUEST['json_data']);
$json_array = json_decode($json_data, TRUE);
//echo "<pre>";print_r($json_array); die;
$query_get_last_move_user = mysql_query("SELECT move FROM game WHERE id =" . $json_array['game_id']);
if (mysql_num_rows($query_get_last_move_user) == 1) {
    $query_get_last_move_user_row = mysql_fetch_array($query_get_last_move_user);
    $last_move_by_user = $query_get_last_move_user_row['move'];
    if ($last_move_by_user != $json_array['turn_by']) {
        $current_date = date("Y-m-d H:i:s");
        if($json_array['action']=='ADD'){
            $sql_insert_turn = "INSERT INTO turns SET
                                    turn_by = '" . $json_array['turn_by'] . "',
                                    file_name = '" . $json_array['file_name'] . "',
                                    game_id = '" . $json_array['game_id'] . "',
                                    status = '" . $json_array['status'] . "',
                                    position_x = '" . $json_array['position_x'] . "',
                                    position_y = '" . $json_array['position_y'] . "',
                                    moving = '" . $json_array['moving'] . "',
    				                created_at='$current_date',
    				                updated_at='$current_date'";
            $sql_update_game = "UPDATE game SET
                                    move = '" . $json_array['turn_by'] . "',
    				updated_at='$current_date'
                                    WHERE id = '" . $json_array['game_id'] . "'";
            mysql_query($sql_update_game) or die(mysql_error());
            mysql_query($sql_insert_turn) or die(mysql_error());
            $response['STATUS'] = "1";
            $response['MESSAGE'] = "Turn saved successfully";
        }elseif($json_array['action']=='UPDATE'){
            $sql_update = "update tirns set moving = '".$json_array['moving']."',
                                status = '" . $json_array['status'] . "' where game_id='".$json_array['game_id']."' and position_x = '" . $json_array['position_x'] . " and position_y = '" . $json_array['position_y'];
            mysql_query($sql_update) or die(mysql_error());
            $response['STATUS'] = "1";
            $response['MESSAGE'] = "Turn saved successfully";
        }else{
            $response['STATUS'] = "0";
            $response['MESSAGE'] = "Request not containing correct action";
        }
        
    } else {
        $response['STATUS'] = "0";
        $response['MESSAGE'] = "You Already Played Your turn";
    }
} else {
    $response['STATUS'] = "0";
    $response['MESSAGE'] = "Invalid Game Id";
}
echo json_encode($response);
?>
