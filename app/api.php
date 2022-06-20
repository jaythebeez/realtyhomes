<?php 

session_start();

require_once('./config/init.php');

$conn = init_db();

require_once('./controllers/authenticate.php');
require_once('./controllers/property.php');
require_once('./controllers/admin.php');
require_once('./controllers/bids.php');
require_once('./controllers/settings.php');


// Endpoint to add properties
if(isset($_POST['add'])) {
    if (isset($_FILES['image'])){
        $fileName = $_FILES['image']['name'];
        @$extn = end(explode('.', $fileName));
        $targetPath = 'upload/' . uniqid() . '.' . $extn;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)){
            $user_id = $_SESSION['user_id'];   
            $status = $property -> addProperty($conn, $_POST, $targetPath);
            if ($status == 1) echo json_encode(array("success"=>"Everything successful"));
            else if ($status == 0) echo json_encode(array("error"=>"Soemthing Wrong"));
        }
        else {
            echo json_encode("error");
        }
    } 
    else {
        echo json_encode("error");
    }
}

if(isset($_POST['props'])) {
    $result = $property -> getProperties($conn);
    echo (json_encode($result)) ;
}

if(isset($_POST['search'])) {
    $result = $property -> customProperties($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['add_agent'])) {
    $result = $authenticate -> addAgent($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['manage_users'])) {
    $result = $authenticate -> getUser($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['deactivate'])) {
    $result = $admin -> deactivateUser($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['activate'])) {
    $result = $admin -> activateUser($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['add_news'])) {
    $result = $admin -> addNews($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['search_news'])) {
    $result = $admin -> searchNews($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['delete_news'])) {
    $result = $admin -> deleteNews($conn, $_POST);
    echo (json_encode($result));
}

if(isset($_POST['submit_bid'])) {
    $user_id = $_SESSION['user_id'];
    $result = $bids -> add_Bid($conn, $_POST, $user_id);
    echo(json_encode($result));
}

if(isset($_POST['search_bid'])) {
    $result = $bids -> searchBid($conn, $_POST);
    echo(json_encode($result));
}

if(isset($_POST['get_news'])) {
    $result = $admin -> getNews($conn);
    echo (json_encode($result));
}

if(isset($_POST['get_props'])) {
    $result = $property -> getPropertiesByUser($conn, $_POST);
    echo(json_encode($result));
}

if(isset($_POST['get_single_property'])) {
    $result = $property -> getSingleProperty($conn, $_POST);
    echo(json_encode($result));
}

if(isset($_POST['get_customer_bids'])) {
    $user_id = $_SESSION['user_id'];
    $result = $bids -> getCustomerBids($conn, $user_id);
    echo(json_encode($result));
}

if(isset($_POST['delete_property'])) {
    $result = $property -> removeProperties($conn, $_POST);
    echo(json_encode($result));
}

if(isset($_POST['delete_bid'])) {
    $result = $bids -> removeBid($conn, $_POST);
    echo(json_encode($result));
}

if(isset($_POST['update_bid'])) {
    $result = $bids -> updateBid($conn, $_POST);
    echo(json_encode($result));
}

if (isset($_POST['get_accepted_bids'])) {
    $result = $admin -> getAcceptedBids($conn);
    echo(json_encode($result));
}

if (isset($_POST['approve_bids'])) {
    $result = $bids -> approveBid($conn, $_POST);
    echo(json_encode($result));
}

if (isset($_POST['get_single_user'])) {
    $result = $admin -> getSingleUser($conn, $_POST);
    echo(json_encode($result));
}

if (isset($_POST['confirm_payment'])) {
    $user_id = $_SESSION['user_id'];
    $result = $authenticate -> confirmPayment($conn, $_POST, $user_id);
    echo(json_encode($result));
}

if (isset($_POST['change_password'])) {
    $user_id = $_SESSION['user_id'];
    $result = $settings -> changePassword($conn, $_POST, $user_id);
    echo(json_encode($result));
}

?>