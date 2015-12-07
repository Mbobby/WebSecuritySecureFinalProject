<?php 
	require_once("includes/sessions.php");

	if($_SESSION['login'] != "1")
	{
		header("Location: login.php");
		die();
	}
	$event_id = $_GET["event_id"];
	$dbuser = 'test';
	$dbpass = 'test';
	$token = $_GET["token"];
	//Check Token for CSRF attack
	if($token != $_SESSION['token'])
	{
		$_SESSION["alert"] = "Your CSRF attack failed on method Delete<br><br>Gotten Token = ".$token;
		header("Location: index.php");
		die();
	}

	//Initializing Database Handle/Connect to Database
	$DBH = new PDO("mysql:host=$host;dbname=WebSecurity", $dbuser, $dbpass);


	//Make query using database handle
	$query = $DBH->prepare("DELETE from Events where id=?");
	
	
	if($query->execute(array($event_id)))
	{
		$_SESSION["alert"] = "The Event has been deleted";
		header("Location: index.php");
		die();
	}
	else
	{
		$_SESSION["alert"] = "The event was not able to be deleted at this time.";
		header("Location: index.php");
		die();
	}

	$DBH = null;
?>