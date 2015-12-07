<?php 
	require_once("includes/sessions.php");

	if($_SESSION['login'] == "1")
	{
		header("Location: index.php");
	}

	// get the User Name and Password
	$username = $_POST['username'];
	$email = $_POST['email']; 
	$pwd = $_POST['pwd'];
	$pwdC = $_POST['pwdC'];

	$dbuser = 'test';
	$dbpass = 'test';

	//Initializing Database Handle/Connect to Database
	$DBH = new PDO("mysql:host=$host;dbname=WebSecurity", $dbuser, $dbpass);


	//Make query using database handle
	$query = $DBH->prepare("INSERT INTO  Users ( email, username, password) VALUES (?, ?, ?)");
	
	if(!($pwd == $pwdC))
	{
		$_SESSION["alert"] = "Your passwords do not match, please try again";
		header("Location: register.php");
		die();
	}
	
	if($query->execute(array($email, strtolower($username), $pwd)))
	{
		$query = $DBH->prepare("SELECT * from Users where email=?");
		$query->execute(array($email));
		$row = $query->fetchAll(PDO::FETCH_ASSOC);

		$_SESSION['login'] = "1";
		$_SESSION['username'] = $username;
		$_SESSION['user_id'] = $row[0]["user_id"];
		$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
		header("Location: index.php");
	}
	else
	{
		$_SESSION["alert"] = "Your account could not be created at this time, please try again.".mysql_error();
		header("Location: register.php");
	}
	$DBH = null;

?>