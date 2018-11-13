<?php
require_once "pdo.php";
require_once('utils.php');
session_start();
if(! isset($_SESSION['username']) ) {
	die("ACCESS DENIED");
}
if ( isset($_POST['make']) && isset($_POST['year'])
     && isset($_POST['model']) && isset($_POST['mileage'])
     && isset($_POST['auto_id']) ) {
	// POST REQUEST
	$id = $_POST['auto_id'];
	$make = $_POST['make'];
	$year = $_POST['year'];
	$mileage = $_POST['mileage'];
	$model = $_POST['model'];
	$validity = isValid($make, $year, $mileage, $model);
	if($validity === true) {
		$sql = "UPDATE autos SET make = :make,
            year = :year, mileage = :mileage,
            model = :model WHERE auto_id = $id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':make' => $make,
        ':year' => $year,
        ':mileage' => $mileage,
    	':model' => $model));
        $_SESSION['success'] = "Record edited";
        header("Location: view.php");
		return;
	} else {
		$_SESSION['message'] = $validity;
		header("Location: add.php");
		return;
	}
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

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	flash($_SESSION);
	?>
	<h1>Edit Auto</h1>
	<form method="POST">
		<p>Make:
    	<input type="text" size="60" value="<?= $make ?>" name="make"></p>
   		<p>Model:
    	<input type="text" size="60" value="<?= $model ?>" name="model"></p>
   		<p>Year:
    	<input type="text" value="<?= $year ?>" name="year"></p>
    	<p>Mileage:
    	<input type="text" value="<?= $mileage ?>" name="mileage"></p>
    	<input type="hidden" name="auto_id" value="<?= $id ?>">
    	<p>
    		<input type="submit" name="submit" value="Edit">
    		<a href="view.php" style="color: blue; text-decoration: underline;">Cancel</a>
    	</p>
	</form>
</body>
</html>