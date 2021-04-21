<?php

	//opens mysqli connection
	$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');
	//error handler
	if ($mysqli->connect_error) {
		die("Connection failed: " . $mysqli->connect_error);
	}

	//sql query
 $sql = 'SELECT * FROM product';
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

 <?php
		//lloping through results 	
		while($stmt->fetch()) {
			echo $db_product . ' ';
	}
	//closing connections
		$stmt->close();
		$mysqli->close(); 
	?>

</body>
</html>
