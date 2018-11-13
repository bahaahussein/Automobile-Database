<?php
require_once "pdo.php";
require_once('utils.php');
session_start();
if(! isset($_SESSION['username']) ) {
	die("ACCESS DENIED");
}
if( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['model']) && isset($_POST['mileage']) ) {
	$make = $_POST['make'];
	$year = $_POST['year'];
	$mileage = $_POST['mileage'];
	$model = $_POST['model'];
	$validity = isValid($make, $year, $mileage, $model);
	if($validity === true) {
		$sql = "INSERT INTO autos (make, year, mileage, model) 
              VALUES (:make, :year, :mileage, :model)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
        ':make' => $make,
        ':year' => $year,
        ':mileage' => $mileage,
    	':model' => $model));
        $_SESSION['success'] = "Record added";
        header("Location: view.php");
		return;
	} else {
		$_SESSION['message'] = $validity;
		header("Location: add.php");
		return;
	}
}
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
	<h1>Add a new Auto</h1>
	<form method="POST">
		<p>Make:
    	<input type="text" size="60" placeholder="Enter Make" name="make"></p>
   		<p>Model:
    	<input type="text" size="60" placeholder="Enter Model" name="model"></p>
   		<p>Year:
    	<input type="text" placeholder="Enter Year" name="year"></p>
    	<p>Mileage:
    	<input type="text" placeholder="Enter Mileage" name="mileage"></p>
    	<p>
    		<input type="submit" name="submit" value="Add">
    		<a href="view.php" style="color: blue; text-decoration: underline;">Cancel</a>
    	</p>
	</form>
</body>
</html>