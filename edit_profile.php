<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
}
$pageTitle = "Edit Profile";
?>
<html>
    <?php include_once 'head.php';?>
    <?php require_once "database.php";?>
    <?php
        $db = new database();
        $db->connect();
        $user['id'] = $_SESSION['id'];
        $user_detail = $db->getByDetail($user['id']);
    ?>
    <?php
    $db = new database();
    $db->connect();
    $user = [
        "firstname" => "",
        "lastname" => "",
        "email" => "",
        "password" => ""
    ];
    $fnameError = $lnameError  = $emailError = $passwordError = [];
    include_once 'validation.php';
    if (isset($_POST['save'])) {
        if (isset($_POST["id"])) {
            $user["id"] = checkfun($_POST["id"]);
        }
        if (isset($_POST["firstname"])) {
            $user["firstname"] = checkfun($_POST["firstname"]);
            $fnameError = valid_firstname($user["firstname"]);
        }
        
        if (isset($_POST["lastname"])) {
            $user["lastname"] = checkfun($_POST["lastname"]);
            $lnameError = valid_lastname($user["lastname"]);
        }
        
        if (isset($_POST["email"])) {
            $user["email"] = checkfun($_POST["email"]);
            $emailError = valid_email($user["email"]);
        }
        
        if (!count($fnameError) && !count($lnameError) && !count($emailError)) {
            $editDetail = $db->update($user);
            if ($editDetail) {
                header('Location: profile.php');
            }
        }
    }
    ?>

    <body>
    <?php include_once 'header.php';?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Edit Profile</h5>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <label>First Name</label><span class="error"> * </span>
                                <input type="hidden" name="id" value="<?php echo $user_detail['id']; ?>" />
                                <input type="text" name="firstname" value="<?php echo $user_detail['firstname'];?>" id="inputEmail" class="form-control" placeholder="First name" required autofocus>
                                <span class="error"><?php echo errorshow($fnameError) ?></span>
                            </div>

                            <div class="form-label-group">
                                <label>Last Name</label><span class="error"> * </span>
                                <input type="text" name="lastname" value="<?php echo $user_detail['lastname'];?>" id="inputEmail" class="form-control" placeholder="Last name" required autofocus>
                                <span class="error"><?php echo errorshow($lnameError) ?></span>
                            </div>

                            <div class="form-label-group">
                             <label>Email address</label><span class="error"> * </span>
                                <input type="email" name="email" value="<?php echo $user_detail['email'];?>" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                <span class="error"><?php echo errorshow($emailError) ?></span>
                            </div>

                            <hr class="my-4">
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="save" type="submit">Save</button>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>