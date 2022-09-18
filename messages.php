<?php
session_start();
require_once "pdo.php";
function loadChat($pdo) {
    $stmt = $pdo->query(
        "SELECT * FROM chatlog"
    );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) > 0) {
        echo "<p style='text-align:center;color: #ffa500;'>This is the start of all messages</p>";
        foreach ($rows as $row) {
            $pfpsrc = './default-pfp.png';
            $user = "<a href='./profile.php?user={$row['account']}' class='account rainbow_text_animated'>" . $row['account'] . "</a>";
            
            $stmta = $pdo->prepare("SELECT pfp FROM account WHERE name=?");
            $stmta->execute([$row['account']]);
            $pfptemp = $stmta->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($pfptemp as $test) {
                if($test['pfp'] != null) {
                    $pfpsrc = $test['pfp'];
                }
            }
            $pfp = "<img class='profile-image' src='$pfpsrc'>";


            $message = htmlentities($row['message']);
            if (isset($_COOKIE['timezone'])) {

                //might break the chat 
                $timezone_offset_minutes = $_COOKIE['timezone'];
                $time = new DateTime($row["message_date"]);
                $minutes_to_add = ($timezone_offset_minutes);
                $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                $stamp = $time->format('D, d M Y H:i:s');
                // here ^

            } else {
                $stamp = $row["message_date"];
            }
            $info = "<p class='stats'>{$user} ({$stamp})</p>";
            $editBtn = "<button class='btn'>Edit {$row['message_id']}</button>";
            $msg = "<p class='msg'>{$message} {$editBtn}</p>";
            echo $pfp;
            echo "<div style='margin-left: 10px;margin-top: 18px;'>{$info}{$msg}</div>";
        }
    }
}

/*$stmt = $pdo->prepare("SELECT * FROM account WHERE name=?");
$stmt->execute([$_SESSION['name']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);*/
loadChat($pdo);
?>