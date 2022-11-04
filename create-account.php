<?php
session_start();
require_once "pdo.php";
date_default_timezone_set('UTC');

if (isset($_SESSION["email"])) {
    header('Location: index.php');
}

if (isset($_POST["submit"])) {
    $statement = $pdo->prepare("SELECT * FROM account where email = :em");
    $statement->execute(array(':em' => $_POST['email']));
    $response = $statement->fetch();

    if ($response == "") {
        $salt = 'XyZzy12*_';
        $check = hash("md5", $salt . $_POST['password']);

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $check;

        $salt = 'XyZzy12*_';
        $check = hash("md5", $salt . $_POST['password']);

        $stmt = $pdo->prepare('INSERT INTO account
            (name, email, password) VALUES ( :nm, :em, :pw)');
        $stmt->execute(
            array(
                ':nm' => $name,
                ':em' => $email,
                ':pw' => $password
            )
        );
        $_SESSION['success'] = "Account Created. Please login.";
        header('Location:login.php');
    } else {
        $_SESSION['error'] = "Email taken.";
        header('Location:create-account.php');
    }
    return;
}
?>

<head>
    <title>Create Accnount</title>
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/edit-account.css?v=<?php echo time(); ?>">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<?php
if (isset($_SESSION["error"])) {
    echo ('<p class="error popup-msg popup-msg-long">' . htmlentities($_SESSION["error"]) . "</p>");
    unset($_SESSION["error"]);
    echo "";
}
?>
<div id="particles-js"></div>
<div class="login-box">
    <form id="form" action="create-account.php" method="post" enctype="multipart/form-data">
        <div class="user-box">
            <input required type="text" name="name">
            <label>Name:</label>
        </div>
        <div class="user-box">
            <input required type="text" name="email" id="id_email">
            <label>Email:</label>
        </div>
        <div class="user-box">
            <input required size='21' type="password" name="password" id="id_1723">
            <label>Password:</label>
        </div>
        <br />
        <div style="float:left;">
            <input type="submit" value="Create account" class="btn" name="submit" onclick="return doValidate();">
            <a href="./index.php" class="btn">Cancel</a>
        </div>
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