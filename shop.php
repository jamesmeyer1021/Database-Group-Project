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
//opens mysqli connection
$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');

//sql query
if(isset($_POST['type'])) { 
	$type = $_POST['type'];
	$sql = "SELECT * FROM product WHERE product_type =?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $type);
} 
else if (isset($_POST['brand'])) {
	$brand= $_POST['brand'];
	$sql = "SELECT * FROM product WHERE product_brand =?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $brand);
} 
else if (isset($_POST['price'])) {
	$low = -999999;
	$high = 999999;
	if(!empty($_POST['low'])){
		$low = $_POST['low'];
	}
	if (!empty($_POST['high'])) {
		$high = $_POST['high'];
	}
 
	$sql= "SELECT * FROM product WHERE product_price BETWEEN ? AND ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('ii', $low, $high);
}
else if (isset($_POST['location'])) {
	$location = $_POST['location'];
	$sql = 'SELECT product_id, product_name, product_type, product_brand, product_quantity, product_price, product.location_id
			FROM product
			JOIN location ON product.location_id = location.location_id
			WHERE location_name = ?';
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $location);
}
else {
	$sql = 'SELECT * FROM product';
	$stmt = $mysqli->prepare($sql);
}

$stmt->execute();
$stmt->bind_result($db_product_id, $db_product_name, $db_product_type, $db_product_brand, $db_product_quantity, $db_product_price, $db_location_id);

$output = '';
//setting titles
$output .= '<table>';
$output .= '<tr> 
		<th> Product Name </th>
		<th> Product Type </th>
		<th> Brand </th>
		<th> In Stock </th>
		<th> Price </th>
		</tr>';
//looping through results 	
while ($stmt->fetch()) {
	//if product is not out of stock
	if ($db_product_quantity > 0) {
		$output .= '<tr>';
		$output .= '<td>' . $db_product_name . '</td><td>' . $db_product_type . '</td><td>' . $db_product_brand . '</td><td>' . $db_product_quantity . '</td><td>$' . $db_product_price .  '</td>';
		$output .= '<td><button id="btn-'.$db_product_id.'" onclick="addToCart(' . $db_product_id . ')">Add To Cart</button> </td>';
		$output .= '</tr>';
	}
}
$output .= '</table>';

//closing connections
$stmt->close();
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
	background-color:white;
}
body{
	background-image:url("https://www.toptal.com/designers/subtlepatterns/patterns/triangle-mosaic.png");
	font-family:Verdana;
}
@font-face{ 
	font-family:Starborn; 
	src:url('STARBORN.OTF');
}
.priceInput {
	width: 50px;
}
</style>
</head>

<body>
<p style="text-align: right"><a href="cart.php">View Cart</a></p>
<p style="text-align: right"><a href="index.php">Log Out</a></p>
<center><p style="font-size:100px; font-family:Starborn; margin-top:0px;">Fantasy Shop</p></center>

	<center><p>From below dropdown menus you can apply filters</p><center>
	  <!--filter forms-->
			<!--filter forms-->
			<form action="" method="post">
				<select name="type">
					<option value="">Select Type</option>
					<option value="Weapon">Weapon</option>
					<option value="Potion">Potion</option>
				</select>
				<button type="submit">Apply</button>
			</form>

			<form action="" method="post">
				<select name="brand">
					<option value="">Select Brand</option>
					<option value="Halo">Halo</option>
					<option value="Kingdom Hearts">Kingdom Hearts</option>
					<option value="Zelda">Zelda</option>
					<option value="Mario">Mario</option>
					<option value="Activision">Activision</option>
				</select>
				<button type="submit">Apply</button>
			</form>
			<br>
			<form action="" method="post">
				Select Price Range: <br>
				Low: <input type="number" name="low" class="priceInput">
				High: <input type="number" name="high" class="priceInput">
				<button type="submit" name="price" value="1">Apply</button>
			</form>
			<br>
			<form action="" method="post">
				<select name="location">
					<option value="">Select Location</option>
					<option value="RPG Emporium">RPG Emporium</option>
					<option value="The Fantasy Corner">The Fantasy Corner</option>
					<option value="The Heros Respite">The Hero's Respite</option>
					<option value="Heros last stand">Hero's last stand</option>
					<option value="Potions and curiosities">Potions and curiosities</option>
				</select>
				<button type="submit">Apply</button>
			</form>

	<h2 style="font-family:Starborn;">Products</h2>
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
					if (status == "success") {
						$("#btn-" + id).html("Added!");
					}
				}
			});
		}
	</script>

<center><p style="font-size:10px;">Built by James Meyer, Jordan Odenthal, Jason Shea, Tony Shelton-McGaha, and Zoe Zellner</p></center>

</body>

</html>
