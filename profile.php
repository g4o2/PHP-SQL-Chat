<?php
session_start();
require_once "pdo.php";
date_default_timezone_set('UTC');

/*if (!isset($_SESSION["email"])) {
    echo "PLEASE LOGIN";
    echo "<br />";
    echo "Redirecting in 3 seconds";
    header("refresh:3;url=index.php");
    die();
}
*/

$pfpsrc = './default-pfp.png';

$stmt = $pdo->prepare("SELECT * FROM account WHERE name=?");
$stmt->execute([$_GET['user']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($rows) > 0) {
    foreach ($rows as $test) {
        if ($test['pfp'] != null) {
            $pfpsrc = $test['pfp'];
        }
        $show_email = $test['show_email'];
        $user = "<p id='user-name'>{$test['name']}</p>";
        $pfp = "<img id='profile-image' src='$pfpsrc'>";
        $email = "<p id='user-email'>{$test['email']}</p>";
    }
    echo $pfp;
    echo $user;
    if ($show_email === "True") {
        echo $email;
    } else {
        echo "";
    }
} else {
    echo "<p style='font-size: 22px;font-family: Arial;text-align:center;color:red;'>User not found</p>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <style>
        body {
            text-align: center;
            padding: 30px;
            background-image: none;
            background-color: rgb(41, 41, 41);
        }

        #user-name {
            font-size: 40px;
            font-family: 'orbitron';
        }

        #user-email {
            font-size: 20px;
            font-family: Arial, Helvetica, sans-serif;
        }

        #profile-image {
            height: 200px;
            border-radius: 10px;
            border: solid 5px #ffa500;
        }
    </style>
</head>

<body>

</body>

</html>