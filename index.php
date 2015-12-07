<?php
require_once("includes/sessions.php");
require_once("includes/header.php");
?>
<div class="padding">
	<div class="full col-sm-9">
		<div class="col-sm-12" id="featured">   
			<div class="page-header text-muted">
				Welcome to Events Manager
			</div> 
		</div>
		<?php

		if(loggedIn())
		{
			include "viewEvents.php";
		}
		else
		{
			include "login.php";
		}

		?>
	</div><!-- /col-9 -->
</div><!-- /padding -->
<?php
	require_once("includes/footer.php");
?>