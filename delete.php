<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION["email"])) {
  echo "PLEASE LOGIN";
  echo "<br />";
  echo "Redirecting in 3 seconds";
  header("refresh:3;url=index.php");
  die();
}

if (isset($_POST['delete']) && isset($_POST['autos_id'])) {
  $sql = "DELETE FROM autos WHERE autos_id = :zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['autos_id']));
  $_SESSION['success'] = 'Record deleted';
  header('Location: index.php');
  return;
}

if (!isset($_GET['autos_id'])) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT make, autos_id FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = 'Bad value for autos_id';
  header('Location: index.php');
  return;
}

?>

<head>
  <title>Delete</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
  <style>
    main {
      margin-left: 40px;
      margin-top: 20px;
    }
  </style>
</head>
<main>
  <p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>
  <form method="post">
    <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
    <input type="submit" value="Delete" name="delete" class="btn">
    <a href="index.php" class="btn">Cancel</a>
  </form>
</main>