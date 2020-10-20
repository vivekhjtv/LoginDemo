<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: index.php');
}
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
        "password" => "",
        "newPassword" => "",
        "confirmPassword" => ""
    ];
    $passwordError = $newPasswordError = $confirmPasswordError = $matchPasswordError = $currentPasswordError = [];
    include_once 'validation.php';
    if (isset($_POST['save'])) {
        if (isset($_POST["id"])) {
            $user["id"] = checkfun($_POST["id"]);
        }
        if (isset($_POST["password"])) {
            $user["password"] = checkfun($_POST["password"]);
            $passwordError = valid_password($user["password"]);
        }         
        if (isset($_POST["new-password"])) {
            $user["newPassword"] = checkfun($_POST["new-password"]);
            $newPasswordError = valid_password($user["newPassword"]);
        } 
        if (isset($_POST["confirm-password"])) {
            $user["confirmPassword"] = checkfun($_POST["confirm-password"]);
            $confirmPasswordError = valid_password($user["confirmPassword"]);
        } 
        if ($db->isPasswordValid($user['id'], $user['password'])){
            if ($user['password'] !== $user['newPassword']) {
                if ( $user['newPassword'] !== $user['confirmPassword']){
                    $matchPasswordError[] = "new password and confirm password are not match!";
                }
            } else {
                $matchPasswordError[] = "new password and and current password are same";
            }
        } else {
            $currentPasswordError[] = "current password is invalid";
        }
        
        if (
            !count($passwordError) && 
            !count($newPasswordError) && 
            !count($confirmPasswordError) && 
            !count($matchPasswordError) &&
            !count($currentPasswordError)
        ) {
            $editDetail = $db->changePassword($user["id"], $user['newPassword']);
            if ($editDetail) {
                header('Location: profile.php');
            }
         }
    }
    ?>

    <body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Change Password</h5>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <label>Current Password</label><span class="error"> * </span>
                                <input type="hidden" name="id" value="<?php echo $user_detail['id']; ?>" />
                                <input type="password" name="password" value="" id="inputEmail" class="form-control" placeholder="Current password" required autofocus>
                                <span class="error"><?php echo errorshow($passwordError) ?></span>
                            </div>

                            <div class="form-label-group">
                                <label>New Password</label><span class="error"> * </span>
                                <input type="password" name="new-password" value="" id="inputEmail" class="form-control" placeholder="New password" required autofocus>
                                <span class="error"><?php echo errorshow($newPasswordError) ?></span>
                                <span class="error"><?php echo errorshow($currentPasswordError) ?></span>
                            </div> 
                            <div class="form-label-group">
                                <label>Confirm-Password</label><span class="error"> * </span> 
                                <input type="password" name="confirm-password" value="" id="inputPassword" class="form-control" placeholder="Confirm password" required>
                                <span class="error"><?php echo errorshow($confirmPasswordError) ?></span>
                                <span class="error"><?php echo errorshow($matchPasswordError) ?></span>
                            </div>                         

                            <hr class="my-4">
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="save" type="submit">Change</button>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>