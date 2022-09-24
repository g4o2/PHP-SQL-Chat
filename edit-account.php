<?php
session_start();
require_once "pdo.php";
date_default_timezone_set('UTC');

if (!isset($_SESSION["email"])) {
    echo "<p class='die-msg'>PLEASE LOGIN</p>";
    echo '<link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">';
    echo "<br />";
    echo "<p class='die-msg'>Redirecting in 3 seconds</p>";
    header("refresh:3;url=index.php");
    die();
}
if (isset($_SESSION["email"])) {
    $statement = $pdo->prepare("SELECT * FROM account where user_Id = :usr");
    $statement->execute(array(':usr' => $_SESSION['user_id']));
    $response = $statement->fetch();
}

if (isset($_POST["submit"])) {
    if (!file_exists($_FILES['fileToUpload']['tmp_name']) || !is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
        $stmta = $pdo->prepare("SELECT pfp FROM account WHERE name=?");
        $stmta->execute([$_SESSION['name']]);
        $pfptemp = $stmta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($pfptemp as $test) {
            if ($test['pfp'] != null) {
                $base64 = $test['pfp'];
            }
        }
    } else {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        $uploadOk = 1;
        $path = $_FILES["fileToUpload"]["tmp_name"];
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    if ($check !== false) {
        if (isset($_POST['password'])) {
            $salt = 'XyZzy12*_';
            $newPassword = $_POST['password'];
            $hash = hash("md5", $salt . $newPassword);
        }
        if ($_POST["show_email"] == "on") {
            $show_email = "True";
        } else {
            $show_email = "False";
        }

        $sql = "UPDATE account SET pfp = :pfp, 
        name = :newName,
        email = :email,
        password = :password,
        about = :about,
        show_email = :showEmail
        WHERE name = :name";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':pfp' => $base64,
            ':name' => $_SESSION['name'],
            ':newName' => $_POST['name'],
            ':email' => $_POST['email'],
            ':password' => $hash,
            ':about' => $_POST['about'],
            ':showEmail' => $show_email
        ));
        $_SESSION['success'] = 'Account details updated.';
    } else {
        $_SESSION['error'] = "File is not an image.";
        $uploadOk = 0;
    }
    header("Location: ./index.php");
}
?>

<head>
    <title>Account</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<form action="edit-account.php" method="post" enctype="multipart/form-data">
    Select image to upload for <?= $_SESSION['name'] ?>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <label for=""></label>
    <p>Name:
        <input required type="text" name="name" value="<?= $response['name'] ?>">
    </p>
    <p>Email:
        <input required type="text" name="email" value="<?= $response['email'] ?>">
    </p>
    <p>About:
        <input type="text" name="about" value="<?= $response['about'] ?>">
    </p>
    <p>New Password:
        <input required size='21' type="text" name="password">
    </p>
    <p>Show email:
        <!-- value="<?= $response["show_email"] ?>"-->
        <input type="checkbox" name="show_email" <?php echo ($response['show_email'] == 'True') ? 'checked' : '' ?>>
    </p>
    <br /><input type="submit" value="Submit Changes" class="btn" name="submit">
    <a href="./index.php" class="btn">Cancel</a>
</form><br />