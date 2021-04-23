<?php
	session_start();
	//If user isn't logged in, send them back to the login page
	if (empty($_SESSION['uid'])) {
		header('Location:index.php');
	}


	//opens mysqli connection
	$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');

	//error handler
	if ($mysqli->connect_error) {
		die("Connection failed: " . $mysqli->connect_error);
	}

	//sql query
 	$sql = 'SELECT product_name, product_type, product_brand, product_price, cart.product_quantity
	 		FROM product
			JOIN cart ON cart.product_id = product.product_id
			WHERE cart.user_id = ?';

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_SESSION['uid']);
	$stmt->execute();
	$stmt->bind_result($db_name, $db_type, $db_brand, $db_price, $db_quantity);
	
	$output = '';
	//looping through results 	
	while($stmt->fetch()) {
		$output .= $db_name . ' ' . $db_type . ' ' . $db_brand . ' ' . $db_price . ' ' . $db_quantity . '<br>';
	}
	//closing connections
	$stmt->close();
	$mysqli->close();
?>

<html>
	<?=$output;?>
</html>