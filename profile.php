<?php
session_start();
if(!isset($_SESSION['id'])){   
    header('Location: index.php');
}
$pageTitle = "Profile"; 
?>
<html>
    <?php include_once 'head.php';?>
    <?php include_once 'database.php';?>
    <body>
    <?php
     $db = new database();
     $db->connect();
    $user['id'] = $_SESSION['id'];
    $user_detail = $db->getByDetail($user['id']);
    
    ?>
    <?php
    if (isset($_POST['editProfile'])) {
        header('Location: edit_profile.php');
    }
    ?>
     <?php include_once 'header.php';?>
    
    <div class="container-fluid">
        <div class="row">
        
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Profile</h5>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <label for="inputEmail">First Name</label>
                                <h4><?php echo  $user_detail['firstname'] ?></h4>
                            </div>

                            <div class="form-label-group">
                                <label for="inputEmail">Last Name</label>
                                <h4><?php echo  $user_detail['lastname'] ?></h4>
                            </div>

                            <div class="form-label-group">
                                <label for="inputEmail">Email address</label>
                                <h4><?php echo  $user_detail['email'] ?></h4>
                            </div>             
                            <hr class="my-4">
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="editProfile" type="submit">Edit</button>
                                                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>