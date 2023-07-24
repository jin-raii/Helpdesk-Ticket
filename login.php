<?php 
include 'init.php';
if($users->isLoggedIn()) {
	header('Location: ticket.php');
}
$errorMessage = $users->login();
include('inc/header.php');
?>
<title>Helpdesk System</title>
<link rel="stylesheet" href="css/style.css">

<style>
	body {
		overflow: hidden;
		/* background-image: url("image/ba.jpg"); 
  background-color: #cccccc;
  height: 100vh; 
  background-position: center; 
  background-repeat: no-repeat; 
  background-size: cover;  */
	}
</style>
<?php include('inc/container.php');?>
<div id='scroll'>
	</div>
	<div class="container contact">	
		<div class="col-md-6">      
			<div id="logo">

				<img src="ira.png" alt="" srcset="">
			</div>              
		<div class="panel ">
			<div class="panel-heading" style="background:#274181;color:white;">
				<div class="panel-title">HELPDESK SYSTEM</div>                        
			</div> 
			<div style="padding-top:30px" class="panel-body" >
				<?php if ($errorMessage != '') { ?>
					<div id="login-alert" class="alert alert-danger col-sm-12"><?php echo $errorMessage; ?></div>                            
				<?php } ?>
				<form id="loginform" class="form-horizontal" role="form" method="POST" action="">                                    
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input type="text" class="form-control" id="email" name="email" placeholder="example@example.com" style="background:white;" required>                                        
					</div>                                
					<div style="margin-bottom: 25px" class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input type="password" class="form-control" id="password" name="password"placeholder="**********" required>
					</div>
					<div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
						  <input type="submit" name="login" value="Login" class="btn loginBtn">						  
						</div>						
					</div>	
					<!-- <div style="margin-top:10px" class="form-group">                               
						<div class="col-sm-12 controls">
						Admin: ira@incessantrainacademy.com<br>
						password:123	<br><br>
						User: smith@webdamn.com<br>
						password:123							
						</div>						
					</div>	 -->
				</form>   
			</div>                     
		</div>  
	</div>
</div>	
<?php include('inc/footer.php');?>