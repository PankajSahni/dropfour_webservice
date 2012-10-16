<?php
function calculateTime($created_at){
	$created_at_sec = strtotime($created_at);
	$now = time();
	$seconds = $now - $created_at_sec;
	$res = '';
	print $days = intval($seconds/(60*60*24));

	if(intval($seconds/(60*60*24))>0){
		$res = intval($seconds/(60*60*24))." days";
	}elseif(intval($seconds/(60*60))>0){
		$res = intval($seconds/(60*60))." hours";
	}elseif(intval($seconds/(60))>0){
		$res = intval($seconds/(60))." mins";
	}elseif($seconds>0){
		$res = $seconds." seconds";
	}else{
		$res = "0 second";
	}


	return $res;
}
?>