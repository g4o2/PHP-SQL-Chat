<?php
session_start();

require_once "pdo.php";
$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos ORDER BY make");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
date_default_timezone_set('UTC');
$stmtuser = $pdo->query("SELECT * FROM account");
$users = $stmtuser->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['logout'])) {
    header('Location: logout.php');
    return;
}

if (isset($_SESSION['email'])) {
    $statement = $pdo->prepare("SELECT * FROM user_status_log where user_Id = :usr");
    $statement->execute(array(':usr' => $_SESSION['user_id']));
    $response = $statement->fetch();

    if ($response != null) {
        $sql = "UPDATE user_status_log SET account=?, last_active_date_time=? WHERE user_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['name'], date(DATE_RFC2822), $_SESSION['user_id']]);
    } else {
        $stmt = $pdo->prepare(
            'INSERT INTO user_status_log (user_id, account, last_active_date_time)
  VALUES (:usr, :acc, :date)'
        );

        $stmt->execute(
            array(
                ':usr' => $_SESSION['user_id'],
                ':acc' => $_SESSION['name'],
                ':date' => date(DATE_RFC2822)
            )
        );
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>G4o2</title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/index.css?=<?php echo time(); ?>">
</head>
<script>
    /*
    setInterval(function() {
        location.reload(true);
    }, 5000);*/
</script>

<body>
    <header class="navbar-header">
        <div class="navbar-container">
            <div>
                <a href="./index.php">
                    <img class="logo" alt="logo" src="./favicon.ico">
                </a>
            </div>
            <div>
                <a href="./index.php">
                    <img class="user-logo" alt="user-logo" src="./g4o2.jpeg">
                </a>
            </div>
            <nav>
                <ul>
                    <li><a href="#">Test</a></li>
                    <li><a href="#">Test</a></li>
                    <li><a href="#">Test</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div id="particles-js"></div>
    <div class="container">
        <h1 class='rainbow_text_animated'>Welcome to g4o2</h1>
        <p>Still in development</p>
        <?php
        if (!isset($_SESSION['email'])) {
            echo '<h4><a style="text-decoration: underline" href="login.php">Please log in</a></h4>';
            echo '<a style="user-select: none;" class="pfp-link" href="https://github.com/maxhu787" target="_blank"><img style="animation-name: g4o2-breath; animation-iteration-count: infinite; animation-duration: 2.5s; position: fixed; height: 50px; width: 50px; border-radius: 120px; top: 20px; right: 20px;z-index: 100;" src="./g4o2.jpeg"></a>';
        }
        if (isset($_SESSION["success"])) {
            echo ('<p class="success popup-msg">' . htmlentities($_SESSION["success"]) . "</p>");
            unset($_SESSION["success"]);
            echo "";
        }
        if (isset($_SESSION["error"])) {
            echo ('<p class="error popup-msg">' . htmlentities($_SESSION["error"]) . "</p>");
            unset($_SESSION["error"]);
            echo "";
        }
        ?>
        <?php
        if (isset($_SESSION['email'])) {
            echo '<table border="1">
            <thead>
            <tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr></thead>';
            foreach ($rows as $row) {
                echo "<tr><td>";
                echo ($row['make']);
                echo ("</td><td>");
                echo ($row['model']);
                echo "<td>";
                echo ($row['year']);
                echo ("</td><td>");
                echo ($row['mileage']);
                echo ("</td><td>");
                echo ('<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ');
                echo ('<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>');
                echo ("</td></tr>\n");
                echo ("</td></tr>\n");
            }
            echo "</table>";
        }
        if (isset($_SESSION['email'])) {
            echo '<p><a href="add.php">Add New Entry</a><br></p><a class="chat-btn btn" href="chat.php"><p class="rainbow_text_animated">CHAT</p></a></p>';
        }
        if (isset($_SESSION['email'])) {
            echo '<table border="1">
            <thead>
                <tr>
                    <th>user_id</th>
                    <th>Profile</th>
                    <th>Email</th>
                    <th>Last online</th>
                </tr>
            </thead>';
            foreach ($users as $user) {
                $pfpsrc = './default-pfp.png';
                if ($user['pfp'] != null) {
                    $pfpsrc = $user['pfp'];
                }

                $pfp = "<a class='pfp-link' href='./profile.php?user={$user['user_id']}'><img style='margin-left: 10px;' class='profile-img' src='$pfpsrc'></a>";

                $statement = $pdo->prepare("SELECT * FROM user_status_log where user_Id = :usr");
                $statement->execute(array(':usr' => $user['user_id']));
                $userlog = $statement->fetch();

                $userStatus = "Undefined";

                if ($userlog != null) {
                    $userStatus = $userlog['last_active_date_time'];
                }


                if ($userStatus === "Undefined") {
                    $diff = "<p style='color:red;'>Undefined</p>";
                } else {
                    $last_online    = $userStatus;
                    $current_date_time = date(DATE_RFC2822);
                    $last_online     = new DateTime($last_online);
                    $current_date_time = new DateTime($current_date_time);

                    $diff = $current_date_time->diff($last_online)->format("last online %a days %h hours and %i minutes ago");


                    $exploded = explode(" ", $diff);

                    if ($exploded[2] !== "0") {
                        $diff = "<p style='color:#ffc200;'>Last online $exploded[2] days ago</p>";
                    } elseif ($exploded[4] !== "0") {
                        $diff = "<p style='color:#ffc200;'>Last online $exploded[4] hours ago</p>";
                    } elseif ($exploded[7] !== "0") {
                        $diff = "<p style='color:#ffc200;'>Last online $exploded[7] minutes ago</p>";
                    } else {
                        $diff = "<p style='color: green;'>Online</p>";
                    }
                }
                echo "<tr><td>";
                echo ($user['user_id']);
                echo $pfp;
                echo ("</td><td>");
                echo "<a href='./profile.php?user={$user['user_id']}' >" . $user['name'] . "</a>";
                echo "<td>";
                if ($user['show_email'] === "False") {
                    echo "Hidden";
                } else {
                    echo ($user['email']);
                }
                echo ("</td><td>");
                echo $diff;
                echo ("</td></tr>\n");
                echo ("</td></tr>\n");
            }
            echo "</table>";
        }
        ?>
        <div style='margin-top: 20px;'>
            <a href="https://github.com/g4o2-chat/PHP-SQL-Chat">
                <img src="https://github-readme-stats.vercel.app/api/pin/?username=g4o2-chat&repo=PHP-SQL-Chat&theme=react&bg_color=0D1117" />
            </a>
        </div>
    </div>
    <?php
    if (isset($_SESSION['email'])) {
        $pfpsrc = './default-pfp.png';

        $stmta = $pdo->prepare("SELECT * FROM account WHERE user_id=?");
        $stmta->execute([$_SESSION['user_id']]);
        $pfptemp = $stmta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pfptemp as $test) {
            if ($test['pfp'] != null) {
                $pfpsrc = $test['pfp'];
            }
            $_SESSION['name'] = $test['name'];
            $_SESSION['email'] = $test['email'];
        }

        $pfp = "<a class='pfp-link' href='./profile.php?user={$test['user_id']}'><img class='profile-img-large' src='$pfpsrc'></a>";
        $main = "<p style='margin-top: 20px;font-size: 20px;font-family: monospace;'>{$_SESSION['name']}</p><p style='font-family: monospace;'>{$_SESSION['email']}</p>";
        $profileLink = "<a href='./profile.php?user={$_SESSION['user_id']}'>Your public profile</a>";
        $actions = '<a href="edit-account.php">Edit Account</a> | <a href="logout.php">Logout</a>';
        echo "<div style='border-radius: 12px;' id='profile'><button id='close-btn' onclick='closeProfile()' style='background-color: rgb(71, 71, 71);border:none;position:absolute;top:0;left:0;font-size: 18px;padding:5px 12px 5px 12px;'>&times;</button>{$pfp}{$main}{$actions}<br />{$profileLink}</div>";
        echo "<button id='close-btn-two' onclick='openProfile()' style='background-color: rgb(71, 71, 71);border:none;position:fixed;top:10px;right:10px;font-size: 18px;padding:5px 12px 5px 12px;opacity: 0;'>&#9776;</button>";
    }
    ?>
    <script type="text/javascript" src="./js/jquery-3.6.0.js"></script>
    <script src="./particles/particles.js"></script>
    <script src="./js/index.js"></script>
    <div id="announcements">
        <h3 style="font-family: orbitron;">Announcements</h3><br />
        <h4>Site creation &#127881; <code>2022/8/23</code></h4>
        <h4>Login system working! 8 created accounts <code>2022/8/24</code></h4>
        <h4>Chat now available&#128526; <code>2022/8/25</code></h4>
        <h4>Profile pictures are now available <code>2022/8/26</code></h4>
        <h4>Profile system working and still being worked on for new look <code>2022/8/28</code></h4>
        <h4>New website theme/style & added user 👤 profile link table on index page <code>2022/9/11</code></h4>
        <h4>Show / Hide email 📧 feature implemented check it out now in the <a href="./edit-account.php">account settings</a> <code>2022/9/17</code></h4>
        <h4>You can now <span class='announcement-highlight'>edit messages</span>! <code>2022/9/18</code></h4>
        <h4>You can now edit / change your passwords 🔑 via <a href="./edit-account.php">account settings</a> <code>2022/9/23</code></h4>
        <h4>Chat now only runs a query to get msgs when a new msg is sent <code>2022/9/24</code></h4>
        <h4>The broken message editing is now fixed 😀 <code>2022/9/24</code></h4>
        <h4>New <a href="./login.php">login</a> &amp; <a href="./edit-account.php">edit account</a> pages <code>2022/9/25</code></h4>
        <h4>Update edit account page css <code>2022/9/30</code></h4>
        <h4>New <a href="./edit-account.php">edit account</a> page same style as login page <code>2022/10/2</code></h4>
        <h4>Now hosting php page on <a href="https://php-sql-chat.maxhu787.repl.co/index.php">repl</a> mysql database hosted with <a href="https://www.db4free.net">db4free</a> <code>2022/10/2</code></h4>
        <h4>Added console message stuff <code>2022/10/8</code></h4>
        <h4>New website message styling <code>2022/10/8</code></h4>
        <h4>Index page update <code>2022/10/9</code></h4>
        <h4><a href="https://github.com/g4o2-chat/PHP-SQL-Chat/releases/tag/1.0.0" target="_blank">v1.0.0</a> out now <code>2022/10/16</code></h4>
        <h4>Database migration: we have switched our database host to <a href="https://www.freemysqlhosting.net">freemysqlhosting.net</a> <code>2022/11/3</code></h4>
        <h4>You can now <a href="create-account.php">create accounts</a> <code>2022/11/3</code></h4>
        <h4>New features added include <span class='announcement-highlight'>ip loggin on login fail</span>, and <span class='announcement-highlight'>guest accounts</span> <code>2022/11/4</code></h4>
        <h4>Several exploits fixed <code>2022/11/4</code></h4>
        <p style="color: rgb(153, 157, 162)">Copyright © <?= date("Y") ?> g4o2. All Rights Reserved.</p>
    </div>
</body>