<div class="controls-content">
    <div class="nav-links">
        <a class="nav-link <?php if((!isset($_REQUEST['view'])) or ($_REQUEST['view'] == 'dashboard')) echo 'active'; ?>" href="?view=dashboard">
            <span class="img-container">
                <img src="./assets/icons/dashboard.svg" alt="dashboard">
            </span>
            <span class="nav-title">Dashboard</span>
        </a>
        <?php if($_SESSION['role'] == 'customer') { ?>
            <a class="nav-link <?php if((isset($_REQUEST['view'])) and ($_REQUEST['view'] == 'properties')) echo 'active'; ?>" href="?view=properties"  >
                <span class="img-container">
                    <img src="./assets/icons/home.svg" alt="dashboard">
                </span>
                <span class="nav-title">Properties</span>
            </a>
        <?php } ?>  
        <?php if($_SESSION['role'] == 'agent') { ?>
            <a class="nav-link  <?php if((isset($_REQUEST['view'])) and ($_REQUEST['view'] == 'add')) echo 'active'; ?>" href="?view=add" >
                <span class="img-container">
                    <img src="./assets/icons/add.svg" alt="add">
                </span>
                <span class="nav-title">Add</span>
            </a>
        <?php } ?>   
        <a class="nav-link <?php if((isset($_REQUEST['view'])) and ($_REQUEST['view'] == 'settings')) echo 'active'; ?>" href="?view=settings" >
            <span class="img-container">
                <img src="./assets/icons/settings.svg" alt="dashboard">
            </span>
            <span class="nav-title">Settings</span>
        </a>

    </div>
</div>