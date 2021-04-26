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
elseif (isset($_POST['brand'])) {
	$brand= $_POST['brand'];
	$sql = "SELECT * FROM product WHERE product_brand =?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('s', $brand);
} 
elseif  (isset($_POST['price'])) {
	if($_POST['price']=='range1'){
		$low = 0; $high = 100;
	}

	if($_POST['price']=='range2'){
		$low = 100; $high = 200;
	}
	if($_POST['price']=='range3'){
		$low = 200; $high = 300;
	} 
	if($_POST['price']=='range4'){
		$low = 300; $high = 400;
	}
	if($_POST['price']=='range5'){
		$low = 400; $high = 500;
	} 
	if($_POST['price']=='range6'){
		$low = 500; $high = 600;
	} 
	$sql= "SELECT * FROM product WHERE product_price BETWEEN ? AND ?";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param('ii', $low, $high);
}
else{
	$sql = 'SELECT * FROM product';
	$stmt = $mysqli->prepare($sql);
}

$stmt->execute();
$stmt->bind_result($db_product_id, $db_product_name, $db_product_type, $db_product_brand, $db_product_quantity, $db_product_price, $db_location_id);

$output = '';
//setting titles
$output .= '<table>';
$output .= '<tr> 
		<th> Product ID </th>
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
		$output .= '<td>' . $db_product_id . '</td><td>' . $db_product_name . '</td><td>' . $db_product_type . '</td><td>' . $db_product_brand . '</td><td>' . $db_product_quantity . '</td><td>$' . $db_product_price .  '</td>';
		$output .= '<td><button onclick="addToCart(' . $db_product_id . ')">Add To Cart</button> </td>';
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
	src:url('STARBORN.TTF');
}
</style>
</head>

<body>
<p style="text-align: right"><a href="cart.php">View cart</a></p>
<center><p style="font-size:100px; font-family:Starborn;">Fantasy Shop</p></center>

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

			<form action="" method="post">
				<select name="price">
					<option value="">Select Price Range</option>
					<option value="range1">0 - 100</option>
					<option value="range2">100 - 200</option>
					<option value="range3">200 - 300</option>
					<option value="range4">300 - 400</option>
					<option value="range5">400 - 500</option>
					<option value="range6">500 - 600</option>
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
				}
			});
		}
	</script>

<center><p style="font-size:10px;">Built by James Meyer, Jordan Odenthal, Jason Shea, Tony Shelton-McGaha, and Zoe Zellner</p></center>

</body>

</html>
