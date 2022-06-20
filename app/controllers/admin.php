<?php

class Admin {

    public function deactivateUser ($conn, $data) {
        try{
            $user_id = $data['id'];
            $sql = "UPDATE `user` SET `status` = 'inactive' WHERE `user`.`user_id` = '$user_id'";
            mysqli_query($conn, $sql);
            return array("success" => "Everything successful");

        }
        catch (Exception $e) {
            return array("error" => "could not delete user");
        }
    }

    public function activateUser ($conn, $data) {
        try{
            $user_id = $data['id'];
            $sql = "UPDATE `user` SET `status` = 'active' WHERE `user`.`user_id` = '$user_id'";
            mysqli_query($conn, $sql);
            return array("success" => "Everything successful");
        }
        catch (Exception $e) {
            return array("error" => "could not Activate user");
        }
    }

    public function getSingleUser ($conn, $data) {
        try{
            $user_id = $data['user_id'];
            $sql = "SELECT * FROM user WHERE user_id='$user_id'";
            $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            if($result['role'] == "customer") {
                $newsql = "SELECT `user`.*, `customer`.*
                FROM `user`
                INNER JOIN `customer` ON `user`.`user_id`=`customer`.`user_id`
                WHERE `user`.`user_id`='$user_id'
                ";
                return $result = mysqli_fetch_assoc(mysqli_query($conn, $newsql));
            }
            return $result;
            
        }
        catch (Exception $e) {
            return array("error" => "could not Activate user");
        }
    }

    public function addNews($conn, $data) {
        try{
            $id = uniqid();
            $news = $data['news'];
            $sql = "INSERT INTO news (news_id, title) VALUES ('$id','$news')";
            mysqli_query($conn, $sql);
            return array("success" => "News Posted Successfully");
        }
        catch(Exception $e) {
            return array("error" => "Could not post news, please try again");
        }
    }

    public function searchNews($conn, $data) {
        try{
            $news = $data['news'];
            $sql = "SELECT * FROM news WHERE title REGEXP '^.*" . "$news" . ".*$' ORDER BY date DESC";
            $result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
            return $result;
        }
        catch(Exception $e) {
            return array("error" => "Could not post news, please try again");
        }
    }

    public function getNews($conn) {
        try{
            $sql = "SELECT * FROM `news`  ORDER BY `news`.`date` DESC LIMIT 10";
            $result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
            return $result;
        } catch (Exception $e) {
            return array("error" => "Could not get news");
        }
    }

    public function deleteNews($conn, $data) {
        try{
            $news_id = $data['id'];
            $sql = "DELETE FROM `news` WHERE `news`.`news_id` = '$news_id'";
            mysqli_query($conn, $sql);
            return array("success" => "Everything successful");

        }
        catch (Exception $e) {
            return array("error" => "could not delete user");
        }
    }

    public function getAcceptedBids($conn){
        try{
            $sql = "SELECT bids.*, property.title, property.market_price, property.user_id AS agent_id, user.username
            FROM ((bids
            INNER JOIN property ON property.property_id=bids.property_id)
            INNER JOIN user ON user.user_id=bids.user_id)
            WHERE bids.status='accepted';
            ";
            $result = mysqli_fetch_all(mysqli_query($conn, $sql), MYSQLI_ASSOC);
            return $result;
        }
        catch(Exception $e) {
            return array("error" => "Could not post news, please try again");
        }
    }

}

$admin = new Admin();

?>