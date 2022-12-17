<?php
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
if($ip !== '216.144.248.19') {
    error_log("Page viewer " . $ip . " (" . date(DATE_RFC2822) . ")\n", 3, "./logs/track_viewers.log");
}
/*
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
if($ip !== '216.144.248.19') {
    if (strpos(file_get_contents("../logs/track_viewers.log"), $ip) !== false) {
        error_log("Page viewer " . $ip . " (" . date(DATE_RFC2822) . ")\n", 3, "./logs/track_viewers.log");
    } else {

    }
}*/
?>