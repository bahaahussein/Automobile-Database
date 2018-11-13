<?php
session_start();
if(! isset($_SESSION['username']) ) {
	header("Location: login.php");
	return;
} else {
	header("Location: view.php");
	return;
}
?>