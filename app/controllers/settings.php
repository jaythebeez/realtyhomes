<?php

class Settings {

    public function changePassword($conn, $data, $user_id){
        try{
            $password = $data['password'];
            $sql = "UPDATE `user` SET `user.`password`='$password' WHERE `user`.`user_id`='$user_id'";
            mysqli_query($conn, $sql);
            return array("success"=> "Passwords updated successfully");       
        }
        catch(Exception $e) {
            return array("error" => "Could not update passwords");
        }
    }

}

$settings = new Settings();

?>