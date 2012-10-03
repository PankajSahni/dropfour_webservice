<?php

require_once 'connection.php';
$array_response = array();
$current_date = date("Y-m-d H:i:s");
$json_data = stripslashes($_REQUEST['json_data']);
$json_array = json_decode($json_data,TRUE);
$fb_id = $json_array['fb_profileid'];
$name = $json_array['name'];
$query_check_if_fb_id_exist = mysql_query("SELECT * FROM user WHERE fb_id = $fb_id");
$array_response["status"] = "0";
if(mysql_num_rows($query_check_if_fb_id_exist) == 0)
{
    mysql_query("INSERT INTO user SET fb_id = $fb_id,
    name = '$name', invited_by = 0, created_at = '$current_date', updated_at = '$current_date'");
    $array_response["status"] = "1";
    $array_response["action"] = "record inserted";
}
else
{
    mysql_query("UPDATE user SET updated_at = '$current_date' WHERE fb_id = $fb_id");
    $array_response["status"] = "1";
    $array_response["action"] = "record updated";
}
echo json_encode($array_response);
?>