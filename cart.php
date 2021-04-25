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
 	$sql = 'SELECT cart.product_id, product_name, product_type, product_brand, product_price, cart.product_quantity
	 		FROM product
			JOIN cart ON cart.product_id = product.product_id
			WHERE cart.user_id = ?';

	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('i', $_SESSION['uid']);
	$stmt->execute();
	$stmt->bind_result($db_id, $db_name, $db_type, $db_brand, $db_price, $db_quantity);
	
	$output = '';
	//looping through results 	
	while($stmt->fetch()) {
		$output .= $db_name . ' ' . $db_type . ' ' . $db_brand . ' ' . $db_price . ' ';
		$output .= '<span id="quantity-'.$db_id.'">'.$db_quantity.'</span>';
		$output .= '<button onclick="incrementQuantity('.$db_id.')">+</button>';
		$output .= '<button onclick="decrementQuantity('.$db_id.')">-</button>';
		$output .= '<button onclick="deleteFromCart('.$db_id.')">Delete</button><br>';
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
		function runAjax(id, num) {
			const span = document.getElementById("quantity-" + id);
			const newQuant = Number(span.innerHTML) + num;

			if (newQuant >= 1) {
				const data = {
					product_id: id,
					add: num,
					uid: <?php echo $_SESSION['uid']; ?>
				};
				$.ajax({
					type: "POST",
					url: "./changeQuantity.php",
					data: data,
					success: function (err, status) {
						if (err != 1) { // 1 means there's an error
							span.innerHTML = newQuant;
						}
						else {
							console.log("error");
						}
					}
				});
			}
		}
		function incrementQuantity(id) {
			runAjax(id, 1);
		}
		function decrementQuantity(id) {
			runAjax(id, -1);
		}

		function deleteFromCart(id) {
			const data = {
				product_id: id,
				uid: <?php echo $_SESSION['uid']; ?>
			};
			$.ajax({
				type: "POST",
				url: "./deleteFromCart.php",
				data: data,
				success: function (data, status) {
					location.reload();
				}
			});
			
		}
		
	</script>
</body>
</html>
