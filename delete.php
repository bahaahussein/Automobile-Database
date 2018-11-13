<?php
require_once "pdo.php";
session_start();
if(! isset($_SESSION['username']) ) {
	die("ACCESS DENIED");
}
if( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
	// POST REQUEST
	$sql = "DELETE FROM autos WHERE auto_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':id' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: view.php' ) ;
    return;
}
// GET REQUEST
// Guardian: Make sure that auto_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['message'] = "Missing auto_id";
  header('Location: view.php');
  return;
}
$id = $_GET['auto_id'];
$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :id");
$stmt->execute(array(":id" => $id));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['message'] = 'Bad value for auto_id';
    header( 'Location: view.php' ) ;
    return;
}
$make = $row['make'];
$model = $row['model'];
$year = $row['year'];
$mileage = $row['mileage'];
?>

<p>Confirm: Deleting <?= htmlentities($row['make']) ?></p>

<form method="post">
<input type="hidden" name="auto_id" value="<?= $id ?>">
<input type="submit" value="Delete" name="delete">
<a href="index.php">Cancel</a>
</form>