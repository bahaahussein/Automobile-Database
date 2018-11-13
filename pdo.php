<?php
try {
	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=miscc', 'fred', 'zap');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	$pdo = new PDO('mysql:host=localhost;port=3306;', 'root', 'root');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE miscc DEFAULT CHARACTER SET utf8;
			GRANT ALL ON miscc.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
			GRANT ALL ON miscc.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';
			USE miscc;
			CREATE TABLE autos (
   				auto_id INTEGER NOT NULL
     				AUTO_INCREMENT KEY,
   				make VARCHAR(128),
  				model VARCHAR(128),
  				year INTEGER,
   				mileage INTEGER
			) ENGINE=InnoDB CHARSET=utf8;
			CREATE TABLE users (
   				user_id INTEGER NOT NULL
     				AUTO_INCREMENT KEY,
   				username VARCHAR(128),
   				password VARCHAR(128),
   				INDEX(username)
			) ENGINE=InnoDB CHARSET=utf8;";
	$pdo->exec($sql);
}
?>