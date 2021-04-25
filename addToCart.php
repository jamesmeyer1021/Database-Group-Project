<?php
	if (!empty($_POST['product_id'] && !empty($_POST['uid']))) {
		$p_id = $_POST['product_id'];
		$u_id = $_POST['uid'];

		//Check if item is already in cart
		$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');
		$sql = 'SELECT product_id
				FROM cart
				WHERE product_id = ? AND user_id = ?';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $p_id, $u_id);
		$stmt->execute();
		$stmt->bind_result($db_pid);
		$stmt->fetch();
		$stmt->close();

		//If item isn't already added to cart,
		if (empty($db_pid)) {

			//run insert
			$sql = 'INSERT INTO cart
					(product_id, user_id, product_quantity)
					VALUES
					(?, ?, 1)';
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('ii', $p_id, $u_id);
			$stmt->execute();
			$stmt->close();
		}
		$mysqli->close();
	}


?>