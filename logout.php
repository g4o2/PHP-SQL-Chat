<?php
session_start();

error_log("Logout success " . $_SESSION['email'] . " (" . date(DATE_RFC2822) . ")\n", 3, "./logs/logs.log");
unset($_SESSION['name']);
unset($_SESSION['user_id']);
unset($_SESSION['email']);
session_start();
session_destroy();

header('Location: index.php');
?>
