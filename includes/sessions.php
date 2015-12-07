<?php 
	session_name("Secure");
	session_start();

	function loggedIn()
	{
		if($_SESSION['login'] == "1")
			return true;
		return false;
	}

	function redirectToLogin()
	{
		if(!loggedIn())
		{
			header("Location: login.php");
		}
	}


?>