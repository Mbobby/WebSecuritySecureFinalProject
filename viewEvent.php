<?php
require_once("includes/sessions.php");
if(!loggedIn())
{
	redirectToLogin();
}
require_once("includes/header.php");
?>
<div class="padding">
	<div class="full col-sm-9">

		<!-- content -->

		<div class="col-sm-12" id="featured">   
			<div class="page-header text-muted">
				Event
			</div> 
		</div>
		<?php 
		if($_SESSION["alert"])
		{
			echo "<div class=\"alert alert-success\" role=\"alert\">".$_SESSION["alert"]."</div>";
			unset($_SESSION["alert"]);
		}
		$event_id = $_GET["event_id"];
		$dbuser = 'test';
		$dbpass = 'test';

		//Initializing Database Handle/Connect to Database
		$DBH = new PDO("mysql:host=$host;dbname=WebSecurity", $dbuser, $dbpass);


		//Make query using database handle
		$query = $DBH->prepare("SELECT * FROM Events where id=?");
		$query->execute(array($event_id));
		$rows = $query->fetchAll(PDO::FETCH_ASSOC);

		$DBH = null;
		//Validate result size
		if (count($rows) == 1 && $rows[0]["author_id"] == $_SESSION["user_id"])
		{
			echo "<div class=\"row\">";    
			echo "<div class=\"col-sm-10\">";
			echo "<h3>".htmlspecialchars($rows[0]["title"])."</h3>";
			echo "<p>";
			echo htmlspecialchars($rows[0]["information"]);
			echo "</p>";
			echo "<small class=\"text-muted\">Created on ".$rows[0]["reg_date"]." • <a href=\"deleteEvent.php?event_id=".$rows[0]["id"]."&token=".$_SESSION["token"]."\" class=\"text-muted\">Delete</a></small>";
			echo "</h4>";
			echo "</div>";
			echo "</div>";

			echo "<hr>";
		}
		else
		{
										//$_SESSION["alert"] = "The event was not found";
										//header("Location: index.php");
			echo "The event you are looking for does not exist";
		}
		?>
	</div><!-- /col-9 -->
</div><!-- /padding -->
<?php
require_once("includes/footer.php");
?>