<?php
session_start();
ob_start();
require_once "pdo.php";
require_once "head.php";

date_default_timezone_set('Asia/Taipei');

$host = $_SERVER['HTTP_HOST'];
$ruta = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$url = "http://$host$ruta";

if (isset($_POST["cancel"])) {
    header("Location: $url/index.php");
    die();
}

if (isset($_POST["email"]) && isset($_POST["pass"])) {
    unset($SESSION["name"]);
    unset($SESSION["user_id"]);


    $salt = 'XyZzy12*_';
    $check = hash("md5", $salt . $_POST["pass"]);

    $stmt = $pdo->prepare(
        'SELECT user_id, name, email
        FROM account
        WHERE
        email = :em AND
        password = :pw'
    );
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    if ($row !== false) {
        if ($_POST["email"] == 'g4o2@protonmail.com' || $_POST["email"] == 'g4o3@protonmail.com' || $_POST["email"] == 'maxhu787@gmail.com') {
            error_log("Login success admin account (" . date(DATE_RFC2822) . ")\n", 3, "./logs/logs.log");
        } else {
            error_log("Login success " . $_POST['email'] . " " . $ip . " (" . date(DATE_RFC2822) . ")\n", 3, "./logs/logs.log");
        }
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["name"] = $row["name"];
        $_SESSION['email'] = $row['email'];
        $_SESSION["success"] = "Logged in.";
        header("Location: $url/index.php");
        die();
    } else {
        $_SESSION["error"] = "Incorrect email or password";
        error_log("Login fail " . $_POST['email'] . " " . $check . " " . $ip . " (" . date(DATE_RFC2822) . ")\n", 3, "./logs/logs.log");
        header("Location: $url/login.php");
        die();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/login.css?v=<?php echo time(); ?>">
</head>

<body>
    <div id="particles-js"></div>
    <div class="login-box">
        <h2>Please Log In</h2>
        <p style="text-align:center;">uppercase and lowercase matters</p>
        <?php
        if (isset($_SESSION["error"])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION["error"]) . "</p>");
            unset($_SESSION["error"]);
        }
        if (isset($_SESSION["success"])) {
            echo ('<p style="color: green">' . htmlentities($_SESSION["success"]) . "</p>");
            unset($_SESSION["success"]);
        }
        ?>
        <form method="post">
            <div class="user-box">
                <input class="input" type="text" name="email" id="id_email" required>
                <label for='email'>Email</label>
            </div>
            <div class="user-box">
                <input class="input" type="password" name="pass" id="id_1723" required>
                <label for='pass'>Password</label>
            </div>
            <div style="float:left;">
                <a class="btn" style='position:absolute;' href="create-account.php">Create account</a>
            </div>
            <div style="float:right;">
                <input id="submit" class="btn" type="submit" onclick="return doValidate();" value="Log In">
                <input id="cancel" class="btn" type="submit" name="cancel" value="Cancel">
                <div>
        </form>
    </div>
    <script src="./particles/particles.js"></script>
    <script>
        function doValidate() {
            console.log("Validating...");
            try {
                email = document.getElementById("id_email").value;
                pw = document.getElementById("id_1723").value;
                console.log("Validating email=" + email);
                console.log("Validating pw=" + pw);
                if (pw == null || pw == "" || email == null || email == "") {
                    alert("Both fields must be filled out");
                    return false;
                }
                if (email.search("@") === -1) {
                    alert("Email address must contain @");
                    return false;
                }
                return true;
            } catch (e) {
                return false;
            }
            return false;
        }
        particlesJS.load('particles-js', './particles/particles.json', function() {
            console.log('callback - particles.js config loaded');
        });
    </script>
</body>

</html>