<?php
require_once "pdo.php";
require_once('utils.php');
session_start();
if(! isset($_SESSION['username']) ) {
	die("ACCESS DENIED");
}
$stmt = $pdo->query("SELECT * FROM autos order by make desc");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
	<h1>Tracking Autos for <?= $_SESSION['username'] ?></h1>
	<h2>Automobiles</h2>
	<?php
	if(count($rows) == 0) {
		echo "<h3>No rows found</h3>";
	} else {
		echo ("<table border='1'>
				<thead>
					<tr>
						<th>Make</th>
						<th>Model</th>
						<th>Year</th>
						<th>Mileage</th>
						<th>Action</th>
					</tr>
				</thead><tbody>");
		foreach ( $rows as $row ) {
			$id = $row['auto_id'];
		    echo ("<tr><td>");
		    echo(htmlentities($row['make']));
		    echo("</td><td>");
		    echo(htmlentities($row['model']));
		    echo("</td><td>");
		    echo(htmlentities($row['year']));
		    echo("</td><td>");
		    echo(htmlentities($row['mileage']));
		    echo("</td><td>");
		    echo("<a href='edit.php?auto_id=$id' style='color: blue; text-decoration: underline;'>Edit</a> \ 
		    	<a href='delete.php?auto_id=$id' style='color: blue; text-decoration: underline;'>Delete</a></td></tr>");
		}
		echo("</tbody></table>");
	}
	?>
	<p>
		<a href="add.php" style="color: blue; text-decoration: underline;">Add New</a>
	</p>
	<p>
		<a href="logout.php" style="color: blue; text-decoration: underline;">Logout</a>
	</p>
</body>
</html>