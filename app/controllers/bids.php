<?php 

class Bid {
    public function add_Bid($conn, $data, $user_id) {
        try{
            $bid_id = uniqid();
            $property_id = $data['property_id'];
            $price = $data['price'];
            $checksql = "SELECT * FROM bids WHERE property_id='$property_id' AND user_id='$user_id' AND status!='rejected'";
            $checkResult = mysqli_fetch_assoc(mysqli_query($conn, $checksql));
            if(isset($checkResult)) {
                return array("error"=>"You have already submitted a bid for this");
            }

            $sql = "INSERT INTO bids (bid_id, property_id,	bid_price, user_id	) VALUES ('$bid_id','$property_id', '$price', '$user_id')";
            if(mysqli_query($conn, $sql)){
                return array("success"=>"Added bids Successfully");      
            }
            else {
                return array("error"=>"Unable to add Bids");
            }
        }catch (Exception $e) {
            return array("error"=>"Unable to add Bids");
        }
    } 


    public function searchBid($conn, $data) {
        try{
            $user_id = $_SESSION['user_id'];
            $props = $data['property'];
            $status = $data['status'];
            if ($status == "all") {
                $sql = "SELECT bids.*, property.title, user.username
                FROM ((bids
                INNER JOIN property ON property.property_id=bids.property_id)
                INNER JOIN user ON user.user_id=bids.user_id)
                WHERE property.property_id REGEXP '^.*" . "$props" . ".*$' AND
                property.user_id='$user_id'
                ";
            }
            else {
                $sql = "SELECT bids.*, property.title, user.username
                FROM ((bids
                INNER JOIN property ON property.property_id=bids.property_id)
                INNER JOIN user ON user.user_id=bids.user_id)
                WHERE property.property_id REGEXP '^.*" . "$props" . ".*$' AND
                property.user_id='$user_id' AND
                bids.status='$status'
                ";
            }
            return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
        }catch (Exception $e) {
            return array("error"=>"Unable to Fetch Bids");
        }
    } 

    public function getCustomerBids($conn, $user_id) {
        try {
            $sql = "SELECT bids.*, property.title, user.username
            FROM ((bids
            INNER JOIN property ON property.property_id=bids.property_id)
            INNER JOIN user ON user.user_id=bids.user_id)
            WHERE bids.user_id='$user_id'
            ";
            return mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
        }
        catch(Exception $e) {
            return array("error"=>"Unable to fetch bids");
        }
    }

    public function removeBid($conn, $data) {
        try {
            $bid_id = $data['bid_id'];
            $sql = "
            DELETE FROM `bids` WHERE `bids`.`bid_id` = '$bid_id'
            ";
            mysqli_query($conn, $sql);
            return  array("success"=>"Deleted bids");
        }
        catch(Exception $e) {
            return array("error"=>"Unable to delete bids");
        }
    }

    public function updateBid($conn, $data) {
        try {
            $bid_id = $data['bid_id'];
            $user_id = $data['user_id'];
            $status = $data['status'];
            $sql = "UPDATE `bids` SET `status` = '$status'  WHERE `bids`.`user_id` = '$user_id' AND `bids`.`bid_id` = '$bid_id' ";
            mysqli_query($conn, $sql);
            $sql = "SELECT * FROM bids WHERE user_id='$user_id' AND bid_id='$bid_id'";
            return  mysqli_fetch_assoc(mysqli_query($conn, $sql));
        }
        catch(Exception $e) {
            return array("error"=>"Unable to update bids");
        }
    }

    public function approveBid($conn, $data) {
        try {
            $bid_id = $data['bid_id'];
            $sql = "UPDATE `bids` SET `status` = 'approved'  WHERE `bids`.`bid_id` = '$bid_id' ";
            mysqli_query($conn, $sql);
            $sql = "SELECT property_id FROM bids WHERE bid_id='$bid_id'";
            $result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
            $property_id = $result['property_id'];
            $sql = "UPDATE `bids` SET `status`=`rejected` WHERE property_id='$property_id' AND bid_id != '$bid_id'";
            mysqli_query($conn, $sql);
            return array("success"=>"Update Successful");
        }
        catch(Exception $e) {
            return array("error"=>"Unable to update bids");
        }
    }

}

$bids = new Bid();

?>