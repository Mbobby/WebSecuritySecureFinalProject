<?php
	require_once("includes/sessions.php");
	if($_SESSION["login"] != "1")
	{
		header("Location: login.php");
		die();
	}

	$id = $_SESSION["user_id"];
	$name = $_SESSION["username"];


	$dbuser = 'test';
	$dbpass = 'test';

	//Initializing Database Handle/Connect to Database
	$DBH = new PDO("mysql:host=$host;dbname=WebSecurity", $dbuser, $dbpass);


	//Make query using database handle
	$query = $DBH->prepare("SELECT * FROM Events where author_id=?");
	$query->execute(array($_SESSION["user_id"]));
	$rows = $query->fetchAll(PDO::FETCH_ASSOC);

	$DBH = null;
	//Validate result size
	if (count($rows) > 0)
	{
		for($i = 0; $i < count($rows); $i = $i + 1)
		{
			echo "<div class=\"row\">";    
            echo "<div class=\"col-sm-10\">";
            echo "<h3>".htmlspecialchars($rows[$i]["title"])."</h3>";
            echo "<small class=\"text-muted\">Created on ".$rows[$i]["reg_date"]."• <a href=\"viewEvent.php?event_id=".$rows[$i]["id"]."\" class=\"text-muted\">View</a></small>";
            echo "</h4>";
            echo "</div>";
            echo "</div>";
			echo "<hr>";
		}
	}
	else
	{
		echo "Sorry, you have no current events to see<br><br>";
	}
	echo "Create new Event <a href=\"newEvent.php\">here.</a><br>";

?>