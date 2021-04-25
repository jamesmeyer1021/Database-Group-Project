<?php
	if (!empty($_POST['product_id']) && !empty($_POST['uid'])) {
		$p_id = $_POST['product_id'];
		$u_id = $_POST['uid'];

		$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');
		$sql = 'DELETE FROM cart
				WHERE product_id = ? AND user_id = ?';
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param('ii', $p_id, $u_id);
		$stmt->execute();
		$stmt->bind_result($prod_quantity);
		$stmt->fetch();
		$stmt->close();

		$mysqli->close();
	}
?>