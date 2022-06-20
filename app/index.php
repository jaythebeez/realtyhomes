<?php 

//start session again
session_start();

require_once('./controllers/authenticate.php');
require_once('./controllers/property.php');

// if session is not active set user page to landing page
if(!isset($_SESSION['user_id'])) {
    header("Location: /realtyhomes/");
}



?>


<?php include('./partials/header.php') ?>

<div class="body-container">
    <div class="controls">
        <?php include('./partials/controls.php') ?>
    </div>
    <div class="main">
        <?php
            if( isset( $_REQUEST['view'] ) == true ){
                switch( $_REQUEST['view'] ){
                    case "dashboard": require("view/dashboard/index.php"); break;
                    case "properties": require("view/properties.php"); break;
                    case "contact": require("view/contact.php"); break;
                    case "settings": require("view/settings.php"); break;
                    case "add": require("view/add.php"); break;
                    case "singleproperty": require("view/singleproperty.php"); break;
                    case "singleuser": require("view/singleuser.php"); break;
                    default: require("view/dashboard/index.php");
                }
            }else{
                require("view/dashboard/index.php");
            }
        ?>
        <div class="news-button">
            <img src="./assets/icons/news.svg" alt="">
        </div>
    </div>
    <div class="news">
        <?php include('./partials/news.php') ?>
    </div>
</div>

<?php include('./partials/footer.php') ?>