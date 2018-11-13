<?php
require_once('utils.php');
require_once "pdo.php";
session_start();
if( isset($_POST['username']) && isset($_POST['password']) ) {
	unset($_SESSION['username']);
	$username = $_POST['username'];
	$salt = 'XyZzy12*_';
	$password = hash('md5', $salt.$_POST['password']);
	$sql = "select * from users where username = :username and password = :password";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(":username" => $username,
						":password" => $password));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row === false) {
		$_SESSION['message'] = "Incorrect username or password";
		header("Location: login.php");
		return;
	}
	$_SESSION['username'] = $username;
	$_SESSION['success'] = 'Login Succesfully';
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
	<h1>Please Log In</h1>
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
    		<button type="submit">Login</button>
    		<a href="newaccount.php" style="color: blue; text-decoration: underline;">Sign Up</a>
    	</p>
	</form>
</body>
</html>