<?php
// require_once 'Users.php';
// $users = new Users;
class Tickets extends Database {  
    private $ticketTable = 'hd_tickets';
	private $ticketRepliesTable = 'hd_ticket_replies';
	private $departmentsTable = 'hd_departments';
	private $dbConnect = false;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    } 
	// public function showTickets(){
	// 	$sqlWhere = '';	
	// 	if(!isset($_SESSION["admin"])) {
	// 		$sqlWhere .= " WHERE t.user = '".$_SESSION["userid"]."' ";
	// 		if(!empty($_POST["search"]["value"])){
	// 			$sqlWhere .= " and ";
	// 		}
	// 	} else if(isset($_SESSION["admin"]) && !empty($_POST["search"]["value"])) {
	// 		$sqlWhere .= " WHERE ";
	// 	} 		
	// 	$time = new time;  			 
	// 	$sqlQuery = "SELECT t.id, t.uniqid, t.title, t.init_msg as message, t.date, t.last_reply, t.resolved, u.name as creater, d.name as department, u.user_type, t.user, t.user_read, t.admin_read
	// 		FROM hd_tickets t 
	// 		LEFT JOIN hd_users u ON t.user = u.id 
	// 		LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere ";
	// 	if(!empty($_POST["search"]["value"])){
	// 		$sqlQuery .= ' (uniqid LIKE "%'.$_POST["search"]["value"].'%" ';					
	// 		$sqlQuery .= ' OR title LIKE "%'.$_POST["search"]["value"].'%" ';
	// 		$sqlQuery .= ' OR resolved LIKE "%'.$_POST["search"]["value"].'%" ';
	// 		$sqlQuery .= ' OR last_reply LIKE "%'.$_POST["search"]["value"].'%") ';			
	// 	}
	// 	if(!empty($_POST["order"])){
	// 		$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
	// 	} else {
	// 		$sqlQuery .= 'ORDER BY t.id DESC ';
	// 	}
	// 	if($_POST["length"] != -1){
	// 		$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
	// 	}	
	// 	$result = mysqli_query($this->dbConnect, $sqlQuery);
	// 	$numRows = mysqli_num_rows($result);
	// 	$ticketData = array();	
	// 	while( $ticket = mysqli_fetch_assoc($result) ) {		
	// 		$ticketRows = array();			
	// 		$status = '';
	// 		if($ticket['resolved'] == 0)	{
	// 			$status = '<span class="label label-success">Open</span>';
	// 		} else if($ticket['resolved'] == 1) {
	// 			$status = '<span class="label label-danger">Closed</span>';
	// 		}	
	// 		$title = $ticket['title'];
	// 		if((isset($_SESSION["admin"]) && !$ticket['admin_read'] && $ticket['last_reply'] != $_SESSION["userid"]) || (!isset($_SESSION["admin"]) && !$ticket['user_read'] && $ticket['last_reply'] != $ticket['user'])) {
	// 			$title = $this->getRepliedTitle($ticket['title']);			
	// 		}
	// 		$disbaled = '';
	// 		if(!isset($_SESSION["admin"])) {
	// 			$disbaled = 'disabled';
	// 		}			
	// 		$ticketRows[] = $ticket['id'];
	// 		$ticketRows[] = $ticket['uniqid'];
	// 		$ticketRows[] = $title;
	// 		$ticketRows[] = $ticket['department'];
	// 		$ticketRows[] = $ticket['creater']; 			
	// 		$ticketRows[] = $time->ago($ticket['date']);
	// 		$ticketRows[] = $status;
	// 		$ticketRows[] = '<a href="view_ticket.php?id='.$ticket["uniqid"].'" class="btn btn-success btn-xs update">View Ticket</a>';	
	// 		$ticketRows[] = '<button type="button" name="update" id="'.$ticket["id"].'" class="btn btn-warning btn-xs update" '.$disbaled.'>Edit</button>';
	// 		$ticketRows[] = '<button type="button" name="delete" id="'.$ticket["id"].'" class="btn btn-danger btn-xs delete"  '.$disbaled.'>Close</button>';
	// 		$ticketData[] = $ticketRows;
	// 	}
	// 	$output = array(
	// 		"draw"				=>	intval($_POST["draw"]),
	// 		"recordsTotal"  	=>  $numRows,
	// 		"recordsFiltered" 	=> 	$numRows,
	// 		"data"    			=> 	$ticketData
	// 	);
	// 	echo json_encode($output);
	// }	


// public function showTickets() {
//     $sqlWhere = '';
//     if (!isset($_SESSION["admin"])) {
//         $sqlWhere .= " WHERE t.user = '".$_SESSION["userid"]."' ";
//         if (!empty($_POST["search"]["value"])) {
//             $sqlWhere .= " and ";
//         }
//     } else if (isset($_SESSION["admin"]) && !empty($_POST["search"]["value"])) {
//         $sqlWhere .= " WHERE ";
//     }

//     $time = new time;
//     $sqlQuery = "SELECT t.id, t.uniqid, t.title, t.init_msg as message, t.date, t.last_reply, t.resolved, u.name as creater, d.name as department, u.user_type, t.user, t.user_read, t.admin_read
//         FROM hd_tickets t 
//         LEFT JOIN hd_users u ON t.user = u.id 
//         LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere ";

//     if (!empty($_POST["search"]["value"])) {
//         $sqlQuery .= ' (uniqid LIKE "%'.$_POST["search"]["value"].'%" ';                   
//         $sqlQuery .= ' OR title LIKE "%'.$_POST["search"]["value"].'%" ';
//         $sqlQuery .= ' OR resolved LIKE "%'.$_POST["search"]["value"].'%" ';
//         $sqlQuery .= ' OR last_reply LIKE "%'.$_POST["search"]["value"].'%") ';          
//     }


//     if (!empty($_POST["order"])) {
//         $sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
//     } else {
//         $sqlQuery .= 'ORDER BY t.id DESC ';
//     }

//     $limit = $_POST['length'];
//     $offset = $_POST['start'];
//     $sqlQuery .= "LIMIT $limit OFFSET $offset";

//     $result = mysqli_query($this->dbConnect, $sqlQuery);
//     $numRows = mysqli_num_rows($result);
//     $ticketData = array();

//     while ($ticket = mysqli_fetch_assoc($result)) {
//         $ticketRows = array();
//         $status = '';
//         if ($ticket['resolved'] == 0) {
//             $status = '<span class="label label-success">Open</span>';
//         } else if ($ticket['resolved'] == 1) {
//             $status = '<span class="label label-danger">Closed</span>';
//         }

//         $title = $ticket['title'];
//         if ((isset($_SESSION["admin"]) && !$ticket['admin_read'] && $ticket['last_reply'] != $_SESSION["userid"]) || (!isset($_SESSION["admin"]) && !$ticket['user_read'] && $ticket['last_reply'] != $ticket['user'])) {
//             $title = $this->getRepliedTitle($ticket['title']);
//         }

//         $disbaled = '';
//         if (!isset($_SESSION["admin"])) {
//             $disbaled = 'disabled';
//         }

//         $ticketRows[] = $ticket['id'];
//         $ticketRows[] = $ticket['uniqid'];
//         $ticketRows[] = $title;
//         $ticketRows[] = $ticket['department'];
//         $ticketRows[] = $ticket['creater'];           
//         $ticketRows[] = $time->ago($ticket['date']);
//         $ticketRows[] = $status;
// 		$ticketRows[] = '<a href="view_ticket.php?id='.$ticket["uniqid"].'" class="btn btn-success btn-xs update">View Ticket</a>';
//      // $ticketRows[] = '<a href="view_ticket.php?id='.$ticket["uniqid"].'" class="btn btn-success btn-xs update">View Ticket</a>';    
//         $ticketRows[] = '<button type="button" name="update" id="'.$ticket["id"].'" class="btn btn-warning btn-xs update" '.$disbaled.'>Edit</button>';
//         $ticketRows[] = '<button type="button" name="delete" id="'.$ticket["id"].'" class="btn btn-danger btn-xs delete"  '.$disbaled.'>Close</button>';
//         $ticketData[] = $ticketRows;
//     }

//     // $sqlCountQuery = "SELECT COUNT(*) as total FROM hd_tickets t LEFT JOIN hd_users u ON t.user = u.id LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere";
// 	$sqlCountQuery = "SELECT COUNT(*) as total FROM hd_tickets t LEFT JOIN hd_users u ON t.user = u.id LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere";

//     $countResult = mysqli_query($this->dbConnect, $sqlCountQuery);
//     $filteredRecords = mysqli_fetch_assoc($countResult)['total'];

//     $output = array(
//         "draw" => intval($_POST["draw"]),
//         "recordsTotal" => $filteredRecords,
//         "recordsFiltered" => $filteredRecords,
//         "data" => $ticketData
//     );
// 	header('Content-Type: application/json');
//     echo json_encode($output);
// }
public function showTickets()
{
	
    $sqlWhere = '';
    if (!isset($_SESSION["admin"])) {
        $sqlWhere .= " WHERE t.user = '" . $_SESSION["userid"] . "' ";
        if (!empty($_POST["search"]["value"])) {
            $sqlWhere .= " AND ";
        }
    } else if (isset($_SESSION["admin"]) && !empty($_POST["search"]["value"])) {
        $sqlWhere .= " WHERE ";
    }

    $sqlQuery = "SELECT t.id, t.uniqid, t.title, t.init_msg AS message, t.date, t.last_reply, t.resolved, t.solution, u.name AS creater, d.name AS department, u.user_type, t.user, t.user_read, t.admin_read
        FROM hd_tickets t 
        LEFT JOIN hd_users u ON t.user = u.id 
        LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere ";

    if (!empty($_POST["search"]["value"])) {
        $sqlQuery .= ' (uniqid LIKE "%' . $_POST["search"]["value"] . '%" ';
        $sqlQuery .= ' OR title LIKE "%' . $_POST["search"]["value"] . '%" ';
        $sqlQuery .= ' OR resolved LIKE "%' . $_POST["search"]["value"] . '%" ';
		$sqlQuery .= ' OR user LIKE "%' . $_POST["search"]["value"] . '%" ';
        $sqlQuery .= ' OR last_reply LIKE "%' . $_POST["search"]["value"] . '%") ';
    }

    if (!empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY t.id DESC ';
    }

    $limit = $_POST['length'];
    $offset = $_POST['start'];
    $sqlQuery .= "LIMIT $limit OFFSET $offset";

    $result = mysqli_query($this->dbConnect, $sqlQuery);
    $numRows = mysqli_num_rows($result);
    $ticketData = array();

    while ($ticket = mysqli_fetch_assoc($result)) {
		// var_dump($ticket);
        $ticketRows = array();
        $status = '';
        if ($ticket['resolved'] == 0) {
            $status = '<span class="label label-success">Open</span>';
        } else if ($ticket['resolved'] == 1) {
            $status = '<span class="label label-danger">Closed</span>';
        }

        $title = $ticket['title'];
        if ((isset($_SESSION["admin"]) && !$ticket['admin_read'] && $ticket['last_reply'] != $_SESSION["userid"]) || (!isset($_SESSION["admin"]) && !$ticket['user_read'] && $ticket['last_reply'] != $ticket['user'])) {
            $title = $this->getRepliedTitle($ticket['title']);
        }

        $disbaled = '';
        if (!isset($_SESSION["admin"])) {
            $disbaled = 'disabled';
        }

        $ticketRows[] = $ticket['id'];
        $ticketRows[] = $ticket['uniqid'];
        $ticketRows[] = $title;
        $ticketRows[] = $ticket['department'];
		if(isset($_SESSION['admin'])) {

			$ticketRows[] = $ticket['solution'];
		}
		// var_dump($ticket['user']);
		// var_dump($_SESSION['userid']);
		// Replaced $ticket['creator'] variable to $ticket
        $ticketRows[] = $ticket['user'];
		// $ticketRows[] = $_SESSION['userid'];
		// $ticketRows[] = $ticket['date'];
		// print_r($ticket['creater']);
		// print_r($ticket['user']);
		

        $ticketRows[] = date('Y-m-d',$ticket['date']);
		// print_r("Ticket Id : ". $ticket["id"]. "<br>");
		// $ticketRows[] = date('Y-m-d H:i', strtotime($ticket['date']));
        $ticketRows[] = $status;
        $ticketRows[] = '<a href="view_ticket.php?id=' . $ticket["uniqid"] . '" class="btn btn-success btn-xs update">View Ticket</a>';
        $ticketRows[] = '<button type="button" name="update" id="' . $ticket["id"] . '" class="btn btn-warning btn-xs update" ' . $disbaled . '>Edit</button>';
        $ticketRows[] = '<button type="button" name="delete" id="' . $ticket["id"] . '" class="btn btn-danger btn-xs delete"  ' . $disbaled . '>Close</button>';
        $ticketData[] = $ticketRows;
    }

    $sqlCountQuery = "SELECT COUNT(*) as total FROM hd_tickets t LEFT JOIN hd_users u ON t.user = u.id LEFT JOIN hd_departments d ON t.department = d.id $sqlWhere";

    if (!empty($_POST["search"]["value"])) {
        $sqlCountQuery .= ' (uniqid LIKE "%' . $_POST["search"]["value"] . '%" ';
        $sqlCountQuery .= ' OR title LIKE "%' . $_POST["search"]["value"] . '%" ';
        $sqlCountQuery .= ' OR resolved LIKE "%' . $_POST["search"]["value"] . '%" ';
        $sqlCountQuery .= ' OR last_reply LIKE "%' . $_POST["search"]["value"] . '%") ';
    }

    $countResult = mysqli_query($this->dbConnect, $sqlCountQuery);
    $filteredRecords = mysqli_fetch_assoc($countResult)['total'];

    $output = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => $filteredRecords,
        "recordsFiltered" => $filteredRecords,
        "data" => $ticketData
    );

    header('Content-Type: application/json');
    echo json_encode($output);
	
}






	public function getRepliedTitle($title) {
		$title = $title.'<span class="answered">Answer</span>';
		return $title; 		
	}
	public function createTicket() {      
		
		if(!empty($_POST['subject']) && !empty($_POST['message'])) {      
			// if(isset($_SESSION['userid'])) {
			// print_r($_SESSION['userid']);
			// }       
			
			$date = new DateTime();
			$date = $date->getTimestamp();
			$uniqid = uniqid();                
			$message = strip_tags($_POST['message']);              
			$queryInsert = "INSERT INTO ".$this->ticketTable." (uniqid, user, title, init_msg, department, date, last_reply, user_read, admin_read, resolved, solution) 
			VALUES('".$uniqid."', '".$_SESSION["userid"]."', '".$_POST['subject']."', '".$message."', '".$_POST['department']."', '".$date."', '".$_SESSION["userid"]."', 0, 0, '".$_POST['status']."','".$_POST['solution']."')";			
			mysqli_query($this->dbConnect, $queryInsert);	
				
			echo 'success ' . $uniqid;
			

			// $to = 'rajesh.rai@incessantrainacademy.com';
			// $subject = 'New ticket created';
			// $emailMessage = 'A new ticket has been created. Subject: ' . $_POST['subject'];
			// $headers = 'From: jinrai5777@gmail.com'; // Set the sender's email address
			
			// if (mail($to, $subject, $emailMessage, $headers)) {
			// 	echo 'success ' . $uniqid;
			// } else {
			// 	echo 'Error sending email';
			// }
			
		} else {
			echo '<div class="alert error">Please fill in all fields.</div>';
		}
	}	
	public function getTicketDetails(){
		if($_POST['ticketId']) {	
			$sqlQuery = "
				SELECT * FROM ".$this->ticketTable." 
				WHERE id = '".$_POST["ticketId"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);	
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			echo json_encode($row);
		}
	}
	public function updateTicket() {
		if($_POST['ticketId']) {	
			$updateQuery = "UPDATE ".$this->ticketTable." 
			SET title = '".$_POST["subject"]."', department = '".$_POST["department"]."', init_msg = '".$_POST["message"]."', resolved = '".$_POST["status"]."', solution = '".$_POST["solution"]."'
			WHERE id ='".$_POST["ticketId"]."'";
			$isUpdated = mysqli_query($this->dbConnect, $updateQuery);		
			var_dump($isUpdated);
		}	
	}		
	public function closeTicket(){
		if($_POST["ticketId"]) {
			$sqlDelete = "UPDATE ".$this->ticketTable." 
				SET resolved = '1'
				WHERE id = '".$_POST["ticketId"]."'";		
			mysqli_query($this->dbConnect, $sqlDelete);		
		}
	}	
	public function getDepartments() {       
		$sqlQuery = "SELECT * FROM ".$this->departmentsTable;
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		while($department = mysqli_fetch_assoc($result) ) {       
            echo '<option value="' . $department['id'] . '">' . $department['name']  . '</option>';           
        }
    }

	public function getDepartmentName($departmentId) {
		$sqlQuery = "SELECT name FROM ".$this->departmentsTable." WHERE id = '".$departmentId."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
	
		if ($result && mysqli_num_rows($result) > 0) {
			$department = mysqli_fetch_assoc($result);
			return $department['name'];
		} else {
			return "Unknown Department";
		}
	}
			
    public function ticketInfo($id) {  		
		$sqlQuery = "SELECT t.id, t.uniqid, t.title, t.user, t.init_msg as message, t.date, t.last_reply, t.resolved, u.name as creater, d.name as department 
			FROM ".$this->ticketTable." t 
			LEFT JOIN hd_users u ON t.user = u.id 
			LEFT JOIN hd_departments d ON t.department = d.id 
			WHERE t.uniqid = '".$id."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
        $tickets = mysqli_fetch_assoc($result);
        return $tickets;        
    }    
	public function saveTicketReplies () {
		if($_POST['message']) {
			$date = new DateTime();
			$date = $date->getTimestamp();
			$queryInsert = "INSERT INTO ".$this->ticketRepliesTable." (user, text, ticket_id, date) 
				VALUES('".$_SESSION["userid"]."', '".$_POST['message']."', '".$_POST['ticketId']."', '".$date."')";
			mysqli_query($this->dbConnect, $queryInsert);				
			$updateTicket = "UPDATE ".$this->ticketTable." 
				SET last_reply = '".$_SESSION["userid"]."', user_read = '0', admin_read = '0' 
				WHERE id = '".$_POST['ticketId']."'";				
			mysqli_query($this->dbConnect, $updateTicket);
		} 
	}	
	// public function getTicketReplies($id) {  		
	// 	$sqlQuery = "SELECT r.id, r.text as message, r.date, u.name as creater, d.name as department, u.user_type  
	// 		FROM ".$this->ticketRepliesTable." r
	// 		LEFT JOIN ".$this->ticketTable." t ON r.ticket_id = t.id
	// 		LEFT JOIN hd_users u ON r.user = u.id 
	// 		LEFT JOIN hd_departments d ON t.department = d.id 
	// 		WHERE r.ticket_id = '".$id."'";	
	// 	$result = mysqli_query($this->dbConnect, $sqlQuery);
    //    	$data= array();
	// 	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	// 		$data[]=$row;            
	// 	}
    //     return $data;
    // }
	public function getTicketReplies($id) {  
		// var_dump($id);		
		$sqlQuery = "SELECT r.id, r.text as message, r.date, r.user as creater, d.name as department, t.admin_read 
			FROM ".$this->ticketRepliesTable." r
			LEFT JOIN ".$this->ticketTable." t ON r.ticket_id = t.id or r.user = t.id 
			LEFT JOIN hd_departments d ON t.department = d.id 
			WHERE r.ticket_id = '".$id."'";	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		// var_dump(mysqli_fetch_array($result, MYSQLI_ASSOC));
       	$data= array();
		
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		// print_r($data);
        return $data;
    }
	public function updateTicketReadStatus($ticketId) {
		$updateField = '';
		if(isset($_SESSION["admin"])) {
			$updateField = "admin_read = '1'";
		} else {
			$updateField = "user_read = '1'";
		}
		$updateTicket = "UPDATE ".$this->ticketTable." 
			SET $updateField
			WHERE id = '".$ticketId."'";				
		mysqli_query($this->dbConnect, $updateTicket);
	}
}