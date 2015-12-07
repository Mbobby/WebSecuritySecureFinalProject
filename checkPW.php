<?php 
	require_once("includes/sessions.php");

	if(loggedIn())
	{
		header("Location: index.php");
	}


	// get the User Name and Password
	$username = strtolower($_POST['username']); 
	$pwd = $_POST['pwd'];

	//Database username and password initialization
	$dbuser = 'test';
	$dbpass = 'test';

	//Initializing Database Handle/Connect to Database
	$DBH = new PDO("mysql:host=$host;dbname=WebSecurity", $dbuser, $dbpass);


	//Make query using database handle
	$query = $DBH->prepare("SELECT * FROM Users where username=? and password=?");
	$query->execute(array($username, $pwd));
	$rows = $query->fetchAll(PDO::FETCH_ASSOC);

	$DBH = null;
	//Validate result size
	if (count($rows) == 1)
	{
		//Validate login information
		if($rows[0]['username'] == $username && $rows[0]['password'] == $pwd)
		{
			session_regenerate_id();
			$_SESSION['login'] = "1";
			$_SESSION['username'] = $username;
			$_SESSION['user_id'] = $rows[0]['user_id'];
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
			header('Location: index.php');
		}
		else
		{
			$_SESSION["alert"] = "Your username and password combination is wrong, please try again with the right information.";
			header("Location: login.php");
		}
	}
	else
	{
		$_SESSION["alert"] = "Your username and password combination is wrong, please try again with the right information.";
		header("Location: login.php");
	}
	


?>