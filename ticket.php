<?php 


include 'init.php'; 
if(!$users->isLoggedIn()) {
	header("Location: login.php");	
}
include('inc/header.php');
$user = $users->getUserInfo();
// date_default_timezone_set('Asia/Kathmandu');
// phpinfo();
// echo date_default_timezone_get();
// echo(isset($_SESSION["admin"]));
?>


<!-- <link 
  rel="stylesheet" 
  type="text/css" 
  href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  
<script 
  type="text/javascript" 
  charset="utf8" 
  src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js">
  </script>  -->
  <script src="js/jquery.dataTables.min.js"></script>
 <script src="js/dataTables.bootstrap.min.js"></script>	
 <!-- buttons pdf, print -->
 <?php if(isset($_SESSION["admin"])) { ?>
 <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.0/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
  <!-- <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.pdf.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

  <?php } ?>	
<!-- <link rel="stylesheet" href="bootstrap.css" /> -->
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/buttons.dataTables.min.css">
<script src="js/general.js"></script>
<script src="js/tickets.js"></script>
<link rel="stylesheet" href="css/style.css" />

<title>IRA Helpdesk System </title>	
<?php include('inc/container.php');?>

<div class="container">	
	<div class="row home-sections">
		<div id="logo">

			<img src="ira.png" class="img-fluid" height="50px" alt="IRA" srcset="">	
		</div>
	<?php include('menus.php'); ?>		
	</div> 
	<div class="" id="test">   		
		<!-- <p>View and manage tickets that may have responses from support team.</p>	 -->
		
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2" align="right">
					<button type="button" name="add" id="createTicket" class="btn btn-success btn-xs">Create Ticket</button>
				</div>
			</div>
		</div>
		<div class="datatable-wide">
		<table id="listTickets" class="table table-bordered table-striped display nowrap">
			<thead>
				<tr>
					<th>S/N</th>
					<th>Ticket ID</th>
					<th>Computer</th>
					<th>Department</th>
					<?php if(isset($_SESSION['admin'])) { ?>
						<th>Solution</th>
					<?php } ?>
					<th>User</th>					
					<th>Created</th>	
					<th>Status</th>
					<th></th>
					<th></th>
					<th></th>					
				</tr>
			</thead>
		</table>
		</div>
	</div>
	<?php include('add_ticket_model.php'); ?>
</div>

<?php include('inc/footer.php');?>