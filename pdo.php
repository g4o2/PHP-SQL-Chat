<?php
/*  
$HOST = '85.10.205.173';
$PORT = 3306;
$DB_NAME = 'g4o2_chat';
$DB_USER = 'maxhu787';
$DB_PASSWORD = getenv('DB_PASSWORD');
$pdo = new PDO(
    "mysql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
*/
    


ob_start();
$HOST = 'localhost';
$PORT = 3306;
$DB_NAME = 'misc';
$DB_USER = 'g4o2';
$DB_PASSWORD = 'g4o2';
$pdo = new PDO(
    "mysql:host=$HOST;port=$PORT;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
