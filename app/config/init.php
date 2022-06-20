<?php 

/* Initializing lemon */
function init_db(){
	
	// Mysql Host
	$host = 'localhost';

	// Mysql User
	$user = 'root';

	// Mysql password
	$password = 'mypassword';

	// Mysql database name
	$database = 'estate_manager';

	try {
		// connecting to database
		$conn = mysqli_connect( $host, $user, $password, $database );
		if( !$conn ){
			echo "The configuration details are not matching the server details. Please review your configuration settings or contact the system provider.";
			exit();
		}	
		return $conn;
	} catch (Exception $e) {
		// if connection fails keep retrying
		init_db();
	}

}

?>
