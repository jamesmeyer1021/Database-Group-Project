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
	$stmt->bind_result($db_product_id, $db_product_name, $db_product_type, $db_product_brand, $db_product_quantity, $db_product_price, $db_user_id, $db_cart_id);

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
		//looping through results 	
		while($stmt->fetch()) {
			echo $db_product_id . ' ' . $db_product_name . ' ' . $db_product_type . ' ' . $db_product_brand . ' ' . $db_product_quantity . ' ' . $db_product_price . ' ' . $db_user_id . ' ' . $db_cart_id . '<br>';
	}
	//closing connections
		$stmt->close();
		$mysqli->close(); 
	?>

</body>
</html>
