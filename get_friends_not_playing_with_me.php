<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$ch = curl_init('https://graph.facebook.com/me/friends?access_token=BAAGGxlclDVABABQmGtAowYfDhbDH6s3kpsTxF7wyAJZADZCmfXfUL2VqYzQhZAZAwuIpbuSnsWf6uinTyZC8Lbo8tuM4ZBZCYRqZCFNR4oaXEo4k7teryRGD5gByTEMMRpbJagE6FuKdyZCDvzmEy3d7o');



curl_setopt($ch, CURLOPT_HEADER, 0);

$outputArray = curl_exec($ch);

echo "<pre>";print_r($outputArray); die;
?>
