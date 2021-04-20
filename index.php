<?php
	session_start();

	$err = '';
	$goodToRedirect = false;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$mysqli = new mysqli('localhost', 'root', '', 'FantasyShop');

		//REGISTER CODE
		/*
		We need to make sure both that the register form was submitted rather than the
		login, and that all the fields were filled out. The hidden input makes sure the
		register form was submitted. array_filter removes empty elements, so we check if
		the size of that returned array matches the size of the normal array. That checks 
		if everything was filled out properly.
		*/
		if (!empty($_POST['register']) && count(array_filter($_POST)) == count($_POST)) { 
			$city = $_POST['regCity'];
			$state = $_POST['regState'];
			$zip = $_POST['regZip'];
			$addr = $_POST['regAddr'];
			$fName = $_POST['regFn'];
			$lName = $_POST['regLn'];
			$phone = $_POST['regPhone'];
			$email = $_POST['regEmail'];
			$pw = $_POST['regPw'];
			
			//Make sure the email isn't already in use
			$sql = 'SELECT user_id
					FROM user
					WHERE email = ?';
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->bind_result($db_uid);
			$stmt->fetch();
			$stmt->close();
			
			if (isset($db_uid)) {
				$err = 'Sorry, that email already has an account';
			}
			else { //Good to insert user information into db
				$sql = 'INSERT INTO user
						(city, state, zip, address, first_name, last_name, phone_number, email, password)
						VALUES
						(?, ?, ?, ?, ?, ?, ?, ?, ?)';
				$stmt = $mysqli->prepare($sql);
				$stmt->bind_param('sssssssss', $city, $state, $zip, $addr, $fName, $lName, $phone, $email, $pw);
				$stmt->execute();
				$stmt->close();

				$goodToRedirect = true;
			}
		}

		//LOGIN CODE
		else if (!empty($_POST['logEmail']) && !empty($_POST['logPw'])) {
			$email = $_POST['logEmail'];
			$pw = $_POST['logPw'];

			$sql = 'SELECT user_id, email, password
					FROM user
					WHERE email = ?
					LIMIT 1';
			$stmt = $mysqli->prepare($sql);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->bind_result($db_uid, $db_email, $db_pw);
			$stmt->fetch();
			$stmt->close();

			if ($pw == $db_pw) {
				$goodToRedirect = true;
			}
			else {
				$err = 'Incorrect username/password';
			}
		}

		else {
			$err = 'Please fill out all the required fields';
		}
		$mysqli->close();

		if ($goodToRedirect === true) {
			header('Location:shop.php');
			die();
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Food for Thought</title>
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>
	Login:
	<form action="" method="POST">
		<label>Email:</label><br>
		<input type="text" name="logEmail" required><br>
		<label>Password:</label><br>
		<input type="password" name="logPw" required><br>
		<button type="submit">Login</button>
	</form>
	<br>
	Register:
	<form action="" method="POST">
		<label>City:</label><br>
		<input type="text" name="regCity" required><br>
		<label>State:</label><br>
		<input type="text" name="regState" required><br>
		<label>Zip:</label><br>
		<input type="text" name="regZip" required><br>
		<label>Address:</label><br>
		<input type="text" name="regAddr" required><br>
		<label>First name:</label><br>
		<input type="text" name="regFn" required><br>
		<label>Last name:</label><br>
		<input type="text" name="regLn" required><br>
		<label>Phone number:</label><br>
		<input type="text" name="regPhone" required><br>
		<label>Email:</label><br>
		<input type="text" name="regEmail" required><br>
		<label>Password:</label><br>
		<input type="password" name="regPw" required><br>
		<input type="hidden" name="register" value="1">

		<button type="submit">Register</button>
	</form>

	<p style="color:red;"><?=$err?></p>
</body>

</html>