<div class="dashboard-content">
    <?php
    if (isset($_SESSION['user_id'])){
        switch($_SESSION['role']){
            case "admin": require("admin.php"); break;
            case "agent": require("agent.php"); break;
            case "customer": require("customer.php"); break;
            default: require("view/dashboard/index.php");
        }
    }
    else {
        header("Location: /realtyhomes/");
    }
    ?>
</div>
