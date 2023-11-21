<nav class="navbar navbar-dark bg-primary" style="background:#274181;color:#f6f8f9;font-weight:bold;">
	<div class="container-fluid">		
		<ul class="nav navbar-nav menus" id='navbar-hover' >
			
			
			<li id="ticket"><a href="ticket.php" class="navbar-brand" style="color: #FFFFFF">Ticket</a></li>
			<?php if(isset($_SESSION["admin"])) { ?>
				<li id="department"><a href="department.php" style="color: #FFFFFF">Department</a></li>
				<li id="user"><a href="user.php" style="color: #FFFFFF">Users</a></li>				
			<?php } ?>						
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" >
				<img src="image/u.png" width="30px" >&nbsp;
				<span>

					<?php 
					if(isset($_SESSION["userid"])) { 
						// var_dump($_SESSION);
    					// var_dump($user);
						// if(isset($user) && isset($user['userid'])) {
						// 	echo $_SESSION['userid'];
						// }
						echo $_SESSION['userid'];
					}
					?>
				</span>
				</a>
				<ul class="dropdown-menu">					
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>