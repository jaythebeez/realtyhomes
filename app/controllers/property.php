<?php 

class Property {

    public function addProperty ($conn, $data, $path) {
        try {
			extract($data);
			if (isset($data)) {
				$id = uniqid();

				if(isset($data['rooms'])){
					$rooms = $data['rooms'];
					$furnished = $data['furnished'];
				}
				else{
					$rooms = NULL;
					$furnished = NULL;
				}

                $user_id = $_SESSION['user_id'];
				$sql = "INSERT INTO property (property_id, user_id, title, city, state, address, status, market_price, category_id, image_path, total_room, furnished) VALUES ( '$id', '$user_id', '$title', '$city', '$state', '$address', 'market', '$price', '$category', '$path', '$rooms', '$furnished')";
				mysqli_query($conn, $sql);
				return 1;
			}
			else {
				return 0;
			}
		} catch(Exception $e) {
			return 0;
		}
    }
	
	public function getProperties ($conn) {
		try {
			$sql = "SELECT * FROM property WHERE status='market'";
			$result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
			return $result;
		}
		catch(Exception $e) {
			return 0;
		}
	}

	public function customProperties ($conn, $result) {
		try {
			$price = $result['max'];
			$sql = "SELECT * FROM property WHERE market_price < '$price' AND status = 'market' ";

			if (isset($result['category_id'])) {
				$cid = $result['category_id'];
				$sql = $sql . ' AND ' . "category_id='$cid'";
			}

			if (isset($result['keyword']) and $result['keyword'] != '') {
				$keyword = $result['keyword'];
				$sql = $sql . ' AND title REGEXP ' . "'^.*" . "$keyword" . ".*$'";
			}

			if (isset($result['states']) and $result['states'] != 'none') {
				$states = $result['states'];
				$sql = $sql . ' AND ' . "state='$states'";
				if(isset($result['city']) and $result['city'] != 'none'){
					$city = $result['city'];
					$sql = $sql . ' AND ' . "city='$city'";
				}
			}
			$result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
			return $result;
		}
		catch(Exception $e) {
			return 0;
		}

	}

	public function getPropertiesByUser ($conn, $data) {
		try{
			$user_id = $_SESSION['user_id'];
			$sql = "SELECT * FROM property WHERE user_id='$user_id'";
			$result = mysqli_fetch_all(mysqli_query($conn, $sql),MYSQLI_ASSOC);
			return $result;
		} catch(Exception $e) {
			return array("error"=>"Cannot get properties");
		}
	}

	public function removeProperties ($conn, $data) {
		try {
			$property_id = $data['property_id'];
			$sql = "DELETE FROM property WHERE property_id='$property_id'";
			mysqli_query($conn, $sql);
			$sql = "DELETE FROM bids WHERE property_id='$property_id'";
			mysqli_query($conn, $sql);
			return array("success"=> "Property records deleted successfully");
		}
		catch(Exception $e) {
			return array("error"=>"Cannot delete properties");
		}
	}

	public function getSingleProperty ($conn, $data) {
		try{
			$property_id = $data['property_id'];
			$sql = "SELECT * FROM property WHERE property_id='$property_id'";
			$result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
			return $result;
		} catch(Exception $e) {
			return array("error"=>"Cannot get properties");
		}
	}

}

$property = new Property();
?>


