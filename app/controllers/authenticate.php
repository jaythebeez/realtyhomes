<?php
//////////////////////////////////
// Authentiating
//////////////////////////////////

class Authenticate {

	// Check user existence [ email is unique ] and account status
	public function login($conn, $username, $password){
		try {
			$sql = "SELECT * FROM user WHERE username='$username' AND password='$password' AND status='active'";
			$result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			// return user array
			if (!isset($result['user_id'])) return array("error" => "User not found or deactivated");
			return $result;
		}
		catch(Exception $e) {
			return array("error" => "Could not login please try again later");
		}
	}
	
    public function signup($conn, $form) {
		try {
			$username = strtolower($form['username']);
			$checksql = "SELECT * FROM user WHERE username = '$username'";
			$checkResult = mysqli_fetch_assoc(mysqli_query($conn, $checksql));
	
			if (!isset($checkResult)) {
				$id = uniqid();
				$password = $form['password'];
				$name = $form['name'];
				$phone = $form['phone'];
				$email = strtolower($form['email']);
				$gender = $form['gender'];
				$sql = "INSERT INTO user (user_id, username, password, role) VALUES ('$id', '$username', '$password', 'customer')";
				mysqli_query($conn, $sql);
				$sql = "INSERT INTO customer (user_id, name, phone, gender, email ) VALUES ('$id', '$name', '$phone', '$gender', '$email')";
				mysqli_query($conn, $sql);
				return array("success" => "User Created Successfully");
			}
			else {
				return array("error" => "Username or Password taken");
			}
		} catch(Exception $e) {
			return array("error" => "Could not create User please try again");
		}
    }

	// Function to log user out from system
	public function logout($conn){
		try{
			session_destroy();
			header("Location: /realtyhomes/");
		}
		catch (Exception $e) {
			return ('error logging out');
		}
	}
	
	// Protects against unauthorized access
	public function protect(){
		if( isset( $_SESSION['user_id'] ) == true && isset( $_SESSION['role_id'] ) == true ){
			header("Location: /lemonv2/app/");
		}else{
			header("Location: /lemonv2/");
		}
	}

	public function addAgent($conn, $data) {
		try{
			extract($data);

			$checksql = "SELECT * FROM user WHERE username = '$username'";
			$checkResult = mysqli_fetch_assoc(mysqli_query($conn, $checksql));

			if(!isset($checkResult) ){
				$id = uniqid();
				$sql = "INSERT INTO user (user_id, username, password, role) VALUES ('$id','$username', '$password', 'agent')";
				mysqli_query($conn, $sql);
				return array("success" => "User Created Successfully");
			}
			else {
				return array("error"=>"Username already taken");
			}
		}
		catch(Exception $e) {
			return array('error'=>'Unable to add agent');
		} 
	}

	public function getUser($conn, $data) {
		$username = strtolower($data['username']);
		$sql = "SELECT * FROM user WHERE role != 'admin' AND username REGEXP '^.*" . "$username" . ".*$'";
		$result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
		return $result;
	}

	public function confirmPayment ($conn, $data, $user_id) {
		try{
			$password = $data['password'];
			$bid_id = $data['bid_id'];
			$sql = "SELECT * FROM user WHERE user_id='$user_id' AND password='$password'";
			$result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			if(isset($result['user_id'])) {
				$newsql = "UPDATE `bids` SET `status` = 'confirmed' WHERE `bids`.`bid_id` = '$bid_id'";
				mysqli_query($conn, $newsql);
				$thirdsql = "SELECT property_id FROM bids WHERE bid_id = '$bid_id'";
				$newResult = mysqli_fetch_assoc(mysqli_query($conn, $thirdsql));
				$property_id = $newResult['property_id'];
				$fourthsql = "UPDATE `property` SET `status` = 'sold' WHERE `property`.`property_id` = '$property_id'";
				return array("success"=>"Payment Successful");
			}
			else {
				return array("error"=>"Password incorrect");
			}
		}
		catch(Exception $e) {
			return array('error'=>'Unable to Confirm Payment');
		} 
	}

	
	
}
// Starting an instance
$authenticate = new Authenticate();


