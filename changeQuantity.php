<?php
	if (!empty($_POST['product_id']) && !empty($_POST['uid']) && !empty($_POST['add'])) {
		$p_id = $_POST['product_id'];
		$u_id = $_POST['uid'];
		$num = $_POST['add']; //either 1 or -1 for increment/decrement
		$err = false;

		//Make sure user isn't trying to buy more items than we have
		$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');
		$sql = 'SELECT product_quantity
				FROM product
				WHERE product_id = ?';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('i', $p_id);
		$stmt->execute();
		$stmt->bind_result($prod_quantity);
		$stmt->fetch();
		$stmt->close();

		if ($prod_quantity - $num >= 1) {
			//run update
			$sql = 'UPDATE cart
					SET product_quantity = product_quantity + ?
					WHERE product_id = ? AND user_id = ?';
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('iii', $num, $p_id, $u_id);
			$stmt->execute();
			$stmt->close();
		}
		else {
			$err = true;
		}

		$mysqli->close();

		echo $err;
	}


?>