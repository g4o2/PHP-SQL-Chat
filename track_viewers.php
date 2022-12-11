<?php
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
error_log("Page viewer " . $ip . " (" . date(DATE_RFC2822) . ")\n", 3, "./logs/track_viewers.log");
?>