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

	//setting titles
	$output = '<table>';
	$output .= '<tr> 
					<th> Product ID </th>
					<th> Product Name </th>
					<th> Product Type </th>
					<th> Brand </th>
					<th> In Stock </th>
					<th> Price </th>
				</tr>';


	$sql = 'SELECT * FROM product ' . $sqlConditions;


	//sql query
	$sql = 'SELECT * FROM product';
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($db_product_id, $db_product_name, $db_product_type, $db_product_brand, $db_product_quantity, $db_product_price);


	//looping through results	 
	while($stmt->fetch()) {
		//if product is not out of stock
		if($db_product_quantity > 0) {
			$output .= '<tr>';
			$output .= '<td>' . $db_product_id . '</td><td>' . $db_product_name . '</td><td>' . $db_product_type . '</td><td>' . $db_product_brand . '</td><td>' . $db_product_quantity . '</td><td>$' . $db_product_price .  '</td>';
			$output .= '<td><button onclick="addToCart('.$db_product_id.')">Add To Cart</button> </td>';
			$output .= '</tr>';
		}
	
	}
	$stmt->close();

	$output .= '</table>';
	$mysqli->close();
?>


<!-- HTML SECTION -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<title>Fantasy Shop</title>

<style>
table, th, td {
	border: 1px solid black;
	padding: 5px;
}
</style>
</head>

<body>
	<center><p>From below dropdown menus you can apply filters</p><center>
	  <!--filter forms-->
	<form action="" method="post">
		<select name="type">
			<option value="">Select Type</option>
			<option value="Weapon">Weapon</option>
			<option value="Potion">Potion</option>
		</select>
		<select name="brand">
			<option value="">Select Brand</option>
			<option value="Halo">Halo</option>
			<option value="Kingdom Hearts">Kingdom Hearts</option>
			<option value="Zelda">Zelda</option>
			<option value="Mario">Mario</option>
			<option value="Activision">Activision</option>
		</select>
		<select name="price">
			<option value="">Select Price Range</option>
			<option value="range1">200 - 300</option>
			<option value="range2">300 - 400</option>
			<option value="range3">400 - 500</option>
		</select>
		<button type="submit" class="btn btn-primary">Apply</button>
	</form>

	<h2>Products</h2>
	<p><a href="cart.php">View cart</a></p>
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
