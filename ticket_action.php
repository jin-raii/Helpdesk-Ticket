<?php
include 'init.php';


if(!empty($_POST['action']) && $_POST['action'] == 'auth') {
	$users->login();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listTicket') {
	$tickets->showTickets();
	
}
if(!empty($_POST['action']) && $_POST['action'] == 'createTicket') {
	// var_dump($_POST['action']);
	// echo 'hello world';
	$tickets->createTicket();
	// $user = $users->getUserInfo();
	// sendEmail($user['email']);
	// sendEmail('jinrai577@gmail.com');
	// echo $_POST['action'];
	// print_r($_SESSION['userid']);

	// if ($tickets->success) {
    //     echo 'Ticket created successfully';
    // } else {
    //     http_response_code(500);
    //     echo 'Failed to create ticket';
    // }
	
}
if(!empty($_POST['action']) && $_POST['action'] == 'getTicketDetails') {
	$tickets->getTicketDetails();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateTicket') {
	$tickets->updateTicket();
}
if(!empty($_POST['action']) && $_POST['action'] == 'closeTicket') {
	$tickets->closeTicket();
}
if(!empty($_POST['action']) && $_POST['action'] == 'saveTicketReplies') {
	$tickets->saveTicketReplies();
}
?>