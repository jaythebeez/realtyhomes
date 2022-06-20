<?php

require_once('./app/config/init.php');

// initialize database connection
$conn = init_db();

$error;

// initialize session
session_start();

// check if user is stored in session if he is then login
if(isset($_SESSION['user_id'])) {
    header("Location: /realtyhomes/app/");
}

// add application controllers
require_once("./app/controllers/authenticate.php");

if(isset($_POST['login'])) {
    $result = $authenticate -> login($conn, strtolower($_POST['username']), $_POST['password']);
    if(isset($result['user_id'])) {
        $_SESSION = $result;
        header("Location: /realtyhomes/app/");
    }
    else if (isset($result['error'])) {
        $error = $result['error'];
    }
}

if (isset($_POST['signup'])) {
    $result = $authenticate -> signup($conn, $_POST);
    if (isset($result['error'])) {
        $error = $result['error'];
    }
    else {
        header("Location: /realtyhomes/");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./app/assets/styles/landingpage.css">
    <link rel="stylesheet" href="./app/assets/styles/normalize.css" >
</head>
<body>  
    <div class="body-container">
        <div class="modal_container">
            <div class="modal_content">
                <?php if((isset($_REQUEST['auth']) and $_REQUEST['auth']=='login') or !isset($_REQUEST['auth'])) { ?>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'];?>" role="signin" method="POST">
                        <div class="form_container">
                            <span class="form_header">Login</span>
                            <label class="form_label">Username:</label>
                            <input class="form_input" type="text" name="username" required pattern="[a-zA-Z0-9]{8,}$" title="At least 8 characters" />
                            <label class="form_label">Password:</label>
                            <input class="form_input" type="password" name="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must be atleast 8 letter contain a number and a letter"/>
                            <input type="hidden" name="login">
                            <button class="form_button" >Log In</button>
                            <span class="tagline">Haven't registered yet? <a href="?auth=signup">Sign Up</a></span>
                        </div>
                    </form>
                <?php } else { ?>
                    <form class="form" action="<?php echo '/realtyhomes/index.php?auth=signup';?>" role="signup" method="POST">
                        <div class="form_container">
                            <span class="form_header">Sign Up</span>
                            <label class="form_label">Full Name:</label>
                            <input class="form_input" type="text" name="name" required pattern="^[a-zA-Z].*[\s\.]*$" />
                            <label class="form_label">Email:</label>
                            <input class="form_input" type="email" name="email" required  />
                            <label class="form_label">Phone:</label>
                            <input class="form_input" type="tel" name="phone" required />
                            <label class="form_label">Gender:</label>
                            <select class="form_input" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <label class="form_label">Username:</label>
                            <input class="form_input" type="text" name="username" title="At least 8 characters" required pattern="[a-zA-Z0-9]{8,}$" />
                            <label class="form_label">Password:</label>
                            <input class="form_input" type="password" name="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Password must be atleast 8 letter contain a number and a letter"  />
                            <input type="hidden" name="signup">
                            <button class="form_button" >Sign Up</button>
                            <span class="tagline">Already Registered? <a href="?auth=login">Login here</a></span>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- The actual snackbar -->
    <div id="snackbar" class="<?php if(isset($error)) echo 'show';?>"> <?php if(isset($error)) echo $error; ?></div>
</body>
</html>