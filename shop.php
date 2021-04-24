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
 	$sql = 'SELECT * FROM product';
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($db_product_id, $db_product_name, $db_product_type, $db_product_brand, $db_product_quantity, $db_product_price, $db_user_id, $db_cart_id);
	
	$output = '';
	//looping through results 	
	while($stmt->fetch()) {
		//if product is not out of stock
		if($db_product_quantity > 0){
		$output .= $db_product_id . ' ' . $db_product_name . ' ' . $db_product_type . ' ' . $db_product_brand . ' ' . $db_product_quantity . ' ' . $db_product_price . ' ' . $db_user_id . ' ' . $db_cart_id . '<br>';
		$output .= '<button onclick="addToCart('.$db_product_id.')">Add To Cart</button> <br>';
		}
	
	}
	//closing connections
	$stmt->close();
	$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Fantasy Shop</title>
</head>

<body>

	<?php echo $output; ?>


	<script>
		function addToCart(id) {
			const data = {
				product_id: id,
				uid: <?php echo $_SESSION['uid']; ?>
			};
			$.ajax({
				type: "POST",
				url: "./addToCart.php",
				data: data,
				success: function (data, status) {
					console.log(status);
				}
			});
		}
	</script>
</body>
</html>
