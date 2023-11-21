<?php

class Users extends Database { 
	private $userTable = 'hd_users';
	private $dbConnect = false;
	private $id;
	public function __construct(){		
        $this->dbConnect = $this->dbConnect();
    }	
	public function isLoggedIn () {
		if(isset($_SESSION["userid"])) {
			return true; 			
		} else {
			return false;
		}
	}
	
	// public function login(){		
	// 	$errorMessage = '';
	// 	if(!empty($_POST["login"]) && $_POST["email"]!=''&& $_POST["password"]!='') {	
	// 		$email = $_POST['email'];
	// 		$password = $_POST['password'];
	// 		$sqlQuery = "SELECT * FROM ".$this->userTable." 
	// 			WHERE email='".$email."' AND password='".md5($password)."' AND status = 1";
				
	// 		$resultSet = mysqli_query($this->dbConnect, $sqlQuery);
	// 		$isValidLogin = mysqli_num_rows($resultSet);	
	// 		if($isValidLogin){
	// 			$userDetails = mysqli_fetch_assoc($resultSet);
	// 			$_SESSION["userid"] = $userDetails['id'];
	// 			$_SESSION["user_name"] = $userDetails['name'];
	// 			if($userDetails['user_type'] == 'admin') {
	// 				$_SESSION["admin"] = 1;
	// 			}
				
	// 			header("location: ticket.php"); 		
	// 		} else {		
	// 			$errorMessage = "Invalid login!";		 
	// 		}
	// 	} else if(!empty($_POST["login"])){
	// 		$errorMessage = "Enter Both user and password!";	
	// 	}
	// 	return $errorMessage; 		
	// }





	// second attemtp : added ldap authentication with searh and bind funtion 
	function login() {
		$errorMessage = '';

		// Check if email and password are provided
		if (!empty($_POST["login"]) && $_POST["email"] != '' && $_POST["password"] != '') {
			// LDAP server connection details
			$ldapServer = "ldap://192.168.99.4";
			$ldapConn = ldap_connect($ldapServer);

			if ($ldapConn) {
				// LDAP administrative credentials
				$ldapAdminUsername = 'ira@incessantrainacademy.local';
				$ldapAdminPassword = 'K!Racad3my';

				// Bind with administrative account
				$ldapBindAdmin = ldap_bind($ldapConn, $ldapAdminUsername, $ldapAdminPassword);

				if ($ldapBindAdmin) {
					// LDAP bind successful with administrative credentials
					// Now, proceed to bind as the user for authentication
					$email = $_POST["email"];
					$password = $_POST["password"];

					// Perform an LDAP search to find the user by their username
					$username = str_replace('.', ' ', strstr($email, '@', true));
					$filter = "(cn=" . $username . ")";
					$attributes = ['distinguishedName','memberOf'];
					$ldapSearch = ldap_search($ldapConn, 'OU=IRA,DC=incessantrainacademy,DC=local', $filter, $attributes);
					
					if ($ldapSearch) {
						$ldapEntries = ldap_get_entries($ldapConn, $ldapSearch);
						if ($ldapEntries['count'] > 0) {
							$userDn = $ldapEntries[0]['distinguishedname'][0];
							$user_member = $ldapEntries[0]['memberof'][0];
							// print_r($userDn);	
							// print_r($email);
							
							// Try to bind as the user with the provided password
							$ldapBindUser = ldap_bind($ldapConn, $userDn, $password);
							// print_r($ldapBindUser);
							ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
							ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
    						ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
							if ($ldapBindUser) {
								// LDAP authentication successful as the user
								// You can now perform additional checks or retrieve user information from LDAP
								$_SESSION["userid"] = $username;
								$_SESSION["userEmail"] = $_POST['email'];
								// $_SESSION["user_name"] = $username;
								// Check if the user is a member of 'OU=it'
							

								if (isset($user_member)) {
									// print_r(substr($user_member, 0, 5));
									if(substr($user_member, 0, 5) == 'CN=it'){
										// $isMemberOfIT = TRUE;
										$_SESSION["admin"] = 1;
									} 
									// Split the string into an array of DNs using the comma as the delimiter
									// $groups = explode(',', $user_member);
									// // print_r($groups);
									// foreach ($groups as $group) {
									// 	$arr = array($group);
									// 	$cn_name = $arr[0];
										
										
										
									// 	if (strpos($group[0], 'CN=it') !== false) {
									// 		$isMemberOfIT = TRUE;
									// 		// Exit the loop if 'CN=it' is found in any group
									// 	} else {
									// 		$isMemberOfIT = FALSE;
									// 	}
									// }
								} else {
									print_r('no user memeber');
								}

								


								
								header("location: ticket.php");
							} else {
								$errorMessage = "LDAP bind error: " . ldap_error($ldapConn);
								print_r($errorMessage);
							}
						} else {
							$errorMessage = "User not found!";
						}
					} else {
						// LDAP search failed
						$errorMessage = "LDAP search failed: " . ldap_error($ldapConn);
					}
				} else {
					$errorMessage = "Failed to bind with administrative credentials.";
				}

				ldap_close($ldapConn);
			} else {
				$errorMessage = "Failed to connect to LDAP server.";
			}
		} else if (!empty($_POST["login"])) {
			$errorMessage = "Enter both username and password!";
		}

		return $errorMessage;
	}


	// first attemt 
	// function login() {
	// 	$errorMessage = '';

	// 	// Check if email and password are provided
	// 	if (!empty($_POST["login"]) && $_POST["email"]!=''&& $_POST["password"]!=''){
	// 		// LDAP server connection details
	// 		$ldapServer = "ldap://192.168.99.4";
	// 		$ldapConn = ldap_connect($ldapServer);
			
	// 		if ($ldapConn) {
				
	// 			// LDAP administrative credentials
	// 			// $ldapAdminUsername = 'CN=IR A,DC=incessantrainacademy,DC=local';
	// 			$ldapAdminUsername = 'ira@incessantrainacademy.local';
	// 			$ldapAdminPassword = 'K!Racad3my';
	// 			// $ldapAdminUsername = $_POST['email'];
	// 			// $ldapAdminPassword = $_POST['password'];

	// 			// Bind with administrative account
	// 			$ldapBindAdmin = ldap_bind($ldapConn, $ldapAdminUsername, $ldapAdminPassword);
	// 			// var_dump($ldapBindAdmin);
	// 			if ($ldapBindAdmin) {
	// 				// LDAP bind successful with administrative credentials
	// 				// Now, proceed to bind as the user for authentication
	// 				$email = $_POST["email"];
    //                 $username = str_replace('.', ' ', strstr($email, '@', true));
	// 				// var_dump($username);
	// 				// $filter = "(cn=" . $username . ")";
	// 				// $filter = "(|(ou=Student)(ou=IT))";
	// 				$filter = "(cn=*)";

	// 				// var_dump($filter);
    //                 $attributes = ['sn', 'givenName', 'distinguishedName', 'memberOf'];
    //                 $ldapSearch = ldap_search($ldapConn, 'OU=IRA,DC=incessantrainacademy,DC=local', $filter, $attributes);
	// 				if ($ldapSearch) {
	// 					$ldapEntries = ldap_get_entries($ldapConn, $ldapSearch);
	// 					var_dump($ldapEntries);
	// 					if ($ldapEntries['count'] > 0) {
	// 						$distinguishedName = $ldapEntries[0]['distinguishedname'][0];
	// 						$givenName = $ldapEntries[0]['givenname'][0];
	// 						$sn = $ldapEntries[0]['sn'][0];
	// 						$memberOf = $ldapEntries[0]['memberof'][0];
	// 						echo "Member of : $memberOf<br>";
	// 						echo "Distinguished Name (DN): $distinguishedName<br>";
	// 						echo "Given Name: $givenName<br>";
	// 						echo "Surname: $sn<br>";
	// 						$_SESSION["userid"] = $givenName;
	// 						// $_SESSION["user_name"] = $givenName;
	// 						// if($userDetails['user_type'] == 'admin') {
	// 						// 	$_SESSION["admin"] = 1;
	// 						// }


	// 						// header("location: ticket.php");	
							
	// 						if (strpos($memberOf, 'OU=it') !== false) {
	// 							// $_SESSION["admin"] = TRUE;
	// 							var_dump(strpos($memberOf, 'OU=it'));
	// 						} else {
	// 							// $_SESSION["admin"] = FALSE;
	// 						}

	// 						// Redirect to the ticket page
	// 						// header("Location: ticket.php");
	// 						exit;
	// 					}
	// 				} else {
	// 					// LDAP search failed
	// 					echo "LDAP search failed: " . ldap_error($ldapConn);
	// 				}

    //                 // $ldapEntries = ldap_get_entries($ldapConn, $ldapSearch);
    //                 // if ($ldapEntries['count'] > 0) {
	// 				// 	var_dump($ldapEntries);
    //                 //     $sAMAccountName = $ldapEntries[0]["givenName"][0];
    //                 //     $cn = $ldapEntries[0]["sn"][0];
    //                 //     $memberOf = $ldapEntries[0]["distinguishedName"];
	// 				// 	var_dump($sAMAccountName);
    //                 //     // Store retrieved LDAP attributes in session or use them as needed
    //                 //     $_SESSION["userid"] = $sAMAccountName;
    //                 //     $_SESSION["user_name"] = $cn;
    //                 //     $_SESSION["user_groups"] = $memberOf;

    //                 //     // Redirect to the ticket page
    //                 //     header("location: ticket.php");	
	// 				// } else {
	// 				// 	$errorMessage = "Invalid login!";
	// 				// 	echo $errorMessage;
	// 				// }
	// 			} else {
	// 				$errorMessage = "Failed to bind with administrative credentials.";
	// 			}

	// 			ldap_close($ldapConn);
	// 		} else {
	// 			$errorMessage = "Failed to connect to LDAP server.";
	// 			echo $errorMessage;
	// 		}
	// 	} else if (!empty($_POST["login"])) {
	// 		$errorMessage = "Enter both username and password!";
	// 	}

	// 	return $errorMessage;
	// }




	public function getUserInfo() {
		// var_dump($_SESSION['userid']);
		if(!empty($_SESSION["userid"])) {
			$sqlQuery = "SELECT * FROM ".$this->userTable." 
				WHERE id ='".$_SESSION["userid"]."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);		
			$userDetails = mysqli_fetch_assoc($result);
			// var_dump($userDetails);
			return $userDetails;
		}		
	}
	public function getColoumn($id, $column) {     
        $sqlQuery = "SELECT * FROM ".$this->userTable." 
			WHERE id ='".$id."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);		
		$userDetails = mysqli_fetch_assoc($result);
		return $userDetails[$column];       
    }
	
	


	// user function to return users from Active Directory 
	public function listUser(){
		// print_r(!empty($_POST["search"]["value"]));
		$errorMessage = '';
		$ldapServer = "ldap://192.168.99.4";
		$ldapConn = ldap_connect($ldapServer);
		// LDAP administrative credentials
		$ldapAdminUsername = 'ira@incessantrainacademy.local';
		$ldapAdminPassword = 'K!Racad3my';

		// Bind with administrative account
		$ldapBindAdmin = ldap_bind($ldapConn, $ldapAdminUsername, $ldapAdminPassword);
		// Check if the LDAP connection is valid
		if ($ldapBindAdmin) {
			$filter = "(cn=*)";
			$attributes = ['memberOf', 'displayName', 'logonCount', 'userPrincipalName', 'whenCreated']; // Add more attributes as needed

			// Perform an LDAP search to retrieve user details
			$ldapSearch = ldap_search($ldapConn, 'OU=IRA,DC=incessantrainacademy,DC=local', $filter, $attributes);
			
			if ($ldapSearch) {
				$ldapEntries = ldap_get_entries($ldapConn, $ldapSearch);
				
				// Use the "draw" parameter to track the request
    			$draw = isset($_POST["draw"]) ? intval($_POST["draw"]) : 1;

				// Determine the start and length based on the draw request
				$start = isset($_POST['start']) ? intval($_POST['start']) : 0;
				$length = isset($_POST['length']) ? intval($_POST['length']) : 10;
				

            // $ldapEntrie = array_slice($ldapEntries, $start, $length);
				$userData = array();
			
				for ($i = 0; $i < min($start + $length, $ldapEntries['count']); $i++) {
					$userRows = array();
					$userRows[] = $i + 1; // Add 1 to start index from 1
					// $userRows[] = count($userData); // prints 212 sn
					
					// print_r(count($userData));
					if (!isset($ldapEntries[$i]['displayname'][0])){
						$userRows[] = 'default';
					} else {
						$userRows[] = $ldapEntries[$i]['displayname'][0];
					
					}
					if (!isset($ldapEntries[$i]['userprincipalname'][0])){
						$userRows[] = 'default';
					} else {
						$userRows[] = $ldapEntries[$i]['userprincipalname'][0];
					}
					if(!isset($ldapEntries[$i]['logoncount'][0])){
						$userRows[] = 'default';

					}else {
						$userRows[] = $ldapEntries[$i]['logoncount'][0];
					}
					

					$userRole = '';
					if (!isset($ldapEntries[$i]['memberof'][0])){
						$userRows[] = 'Not Defined';
					} else {
						$cn = $ldapEntries[$i]['memberof'][0];
						$cnIt = 'CN=it';
						$cnMgmt = 'CN=management';
						$cnVfx = 'CN=vfx';
						$cnAnim = 'CN=Anim';
						$cnMentor = 'CN=mentor';
						$cnReference = 'CN=references';
						$cnClassroom = 'CN=classroom';
						$components = explode(",", $cn);
						$firstComponent = $components[0];
						if($firstComponent === $cnIt){
							$userRole = '<span >IT</span>';
						} elseif ($firstComponent === $cnMgmt) {
							$userRole = '<span >Management</span>';
						}elseif($firstComponent === $cnVfx) {
							$userRole = '<span >VFX</span>';
						} elseif($firstComponent === $cnAnim) {
							$userRole = '<span >Animation</span>';
						} elseif ($firstComponent === $cnMentor) {
							$userRole = '<span > Mentor </span>';
						}elseif ($firstComponent === $cnReference) {
							$userRole = '<span > Reference </span>';
						} elseif ($firstComponent === $cnClassroom) {
							$userRole = '<span > Class Room </span>';

						}
						
					}
					$userRows[] = $userRole;

					if(!isset($ldapEntries[$i]['whencreated'][0])){
						$userRows[] = 'default';

					}else {
						$dateStrings = $ldapEntries[$i]['whencreated'][0];
						$formattedDates = array();
						if (!is_array($dateStrings)) {
							// If it's a single string, convert it to an array with one element
							$dateStrings = array($dateStrings);
						}

						foreach ($dateStrings as $dateString) {
							$dateTime = DateTime::createFromFormat("YmdHis.uP", $dateString);

							if ($dateTime !== false) {
								$formattedDate = $dateTime->format("m_d_Y H:i:s");
								$formattedDates[] = $formattedDate;
							}
						}

						// Replace the original date strings with the formatted dates
						$ldapEntries[$i]['whencreated'] = $formattedDates;
						$userRows[] = $formattedDates;
					}

					$userData[] = $userRows;
				}
				// print_r($userData);
				
				$output = array(
					"draw" => $draw,
					"recordsTotal" => $ldapEntries['count'],
					"recordsFiltered" => $ldapEntries['count'],
					"data" => $userData,
					
				);
				// print_r($output);
				// print_r($output['data']);
				$userList = $output['data'];
				usort($userList, function ($a, $b) {
					return strcmp($a[1], $b[1]);
				});
				$output['data'] = $userList;
				echo json_encode($output);
			} else {
				$errorMessage = "LDAP search failed: " . ldap_error($ldapConn);
			}
		} else {

		}
		

		return $errorMessage;
	}




	public function setId($id){
		$this->id = $id;
	}
	
	public function insert() {      
		if($this->userName && $this->email) {		              
			$this->userName = strip_tags($this->userName);			
			$this->newPassword = md5($this->newPassword);			
			$queryInsert = "
				INSERT INTO ".$this->userTable."(name, email, user_type, status, password) VALUES(
				'".$this->userName."', '".$this->email."', '".$this->role."','".$this->status."', '".$this->newPassword."')";				
			mysqli_query($this->dbConnect, $queryInsert);			
		}
	}	
	
	public function update() {      
		if($this->updateUserId && $this->userName) {		              
			$this->userName = strip_tags($this->userName);

			$changePassword = '';
			if($this->newPassword) {
				$this->newPassword = md5($this->newPassword);
				$changePassword = ", password = '".$this->newPassword."'";
			}
			
			$queryUpdate = "
				UPDATE ".$this->userTable." 
				SET name = '".$this->userName."', email = '".$this->email."', user_type = '".$this->role."', status = '".$this->status."' $changePassword
				WHERE id = '".$this->updateUserId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}	
	
	public function delete() {      
		if($this->deleteUserId) {		          
			$queryUpdate = "
				DELETE FROM ".$this->userTable." 
				WHERE id = '".$this->deleteUserId."'";				
			mysqli_query($this->dbConnect, $queryUpdate);			
		}
	}
	
}