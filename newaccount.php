<?php
require_once('utils.php');
require_once "pdo.php";
session_start();
if( isset($_POST['username']) && isset($_POST['password']) ) {
	unset($_SESSION['username']);
	$username = $_POST['username'];
	$salt = 'XyZzy12*_';
	$password = hash('md5', $salt.$_POST['password']);
	$sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":username" => $username,
						":password" => $password));
	$row = $stmt->execute(PDO::FETCH_ASSOC);
	$_SESSION['username'] = $username;
	$_SESSION['success'] = 'Account made Succesfully';
	header("Location: view.php");
	return;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Sign Up</h1>
	<?php
		flash($_SESSION);
	?>
	<form method="POST">
		<p>Username:
    	<input type="text" placeholder="Enter Username" name="username" pattern=".{6,}" required>
    	</p>
   		<p>Password:
    	<input type="password" placeholder="Enter Password" name="password" pattern=".{6,}" required>
    	</p>
    	<p>
    		<button type="submit">Sign Up</button>
    	</p>
	</form>
</body>
</html>