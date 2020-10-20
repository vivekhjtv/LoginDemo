<?php
$user_detail['firstname'] = $_SESSION['firstname'];
$user_detail['isAdmin'] = $_SESSION['isAdmin'];
require_once("common.php");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#">Welcome <b><?php echo  $user_detail['firstname'] ?></b></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <li class="nav-item <?php echo isActive("Profile") ? "active" : "" ?>">
            <a class="nav-link" href="profile.php">Profile</a>
        </li>    
    <?php
    if(isset($user_detail['isAdmin']) && $user_detail['isAdmin']){?>
        <li class="nav-item <?php echo isActive("Admin") ? "active" : "" ?>">
            <a class="nav-link" href="admistration.php">Admistration</a>
        </li><?php         
    } ?>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
</div>
</nav>

