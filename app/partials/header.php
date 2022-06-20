<?php

if(isset($_REQUEST['logout'])) {
    $authenticate -> logout($conn); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realty Homes</title>
    <link rel="stylesheet" href="./assets/styles/normalize.css">
    <link rel="stylesheet" href="./assets/styles/style.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo-container">
                <img src="./assets/images/home-logo.webp" alt="">
            </div>
            <div class="auth-container">
                <a href="?logout=true" class="auth-button">Logout</a>
            </div>
        </div>
    </header>

    <script>
        const logoContainer = document.querySelector(".logo-container");
        logoContainer.addEventListener('click', (e)=>{
            window.location.reload();
        })
    </script>