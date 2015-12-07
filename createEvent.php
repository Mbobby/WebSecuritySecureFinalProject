<?php 
	require_once("includes/sessions.php");
	if($_SESSION["login"] != "1")
	{
		header("Location: login.php");
		die();
	}

	$author_id = $_SESSION["user_id"];
	$title = $_POST["title"];
	$token = $_POST["token"];
	$information = $_POST["information"];
	$date = $_POST["date"];
	$author_id = $_SESSION["user_id"];


	$dbuser = 'test';
	$dbpass = 'test';

	if($token != $_SESSION["token"])
	{
		$_SESSION["alert"] = "CSRF attack failed!";
		header("Location: index.php");
		die();
	}
	//Initializing Database Handle/Connect to Database
	$DBH = new PDO("mysql:host=$host;dbname=WebSecurity", $dbuser, $dbpass);


	//Make query using database handle
	$query = $DBH->prepare("INSERT INTO  Events(title, information, author_id, event_date) VALUES (?, ?, ?, ?)");
	
	
	if($query->execute(array($title, $information, $author_id, $date)))
	{
		$_SESSION["alert"] = "Event Successfully created";
		header("Location: index.php");
	}
	else
	{
		$_SESSION["alert"] = "Error: Event was not created";
		header("Location: newEvent.php");
	}
?>