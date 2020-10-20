<?php
session_start();
?>
<html>
    <?php include_once 'head.php';?>    
    <?php require_once "database.php";?>
    <body>
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
    if (isset($_POST['signup'])) {
        
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
        if (isset($_POST["password"])) {
            $user["password"] = checkfun($_POST["password"]);
            $passwordError = valid_password($user["password"]);
        }  

        if ($db->emailExist($user)) {            
            $emailError[] = "email already exist";
        }
        if (!count($fnameError) && !count($lnameError) && !count($emailError) && !count($passwordError)) {       
            $detail = $db->add($user);
            if($detail){
                header('Location: index.php');
            }
        }
    }   
    
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Registration</h5>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <label>First Name</label><span class="error"> * </span>
                                <input type="text" name="firstname" value="<?php echo $user["firstname"]?>" id="inputEmail" class="form-control" placeholder="First name" required autofocus>
                                <span class="error"><?php echo errorshow($fnameError) ?></span>
                            </div>

                            <div class="form-label-group">
                                <label>Last Name</label><span class="error"> * </span>
                                <input type="text" name="lastname" value="<?php echo $user["lastname"]?>" id="inputEmail" class="form-control" placeholder="Last name" required autofocus>
                                <span class="error"><?php echo errorshow($lnameError) ?></span>
                            </div>

                            <div class="form-label-group">
                             <label>Email address</label><span class="error"> * </span>
                                <input type="email" name="email" value="<?php echo $user["email"]?>" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                <span class="error"><?php echo errorshow($emailError) ?></span>
                            </div>

                            <div class="form-label-group">
                                <label>Password</label><span class="error"> * </span> 
                                <input type="password" name="password" value="<?php echo $user["password"]?>" id="inputPassword" class="form-control" placeholder="Password" required>
                                <span class="error"><?php echo errorshow($passwordError) ?></span>
                            </div>
                            <hr class="my-4">
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="signup" type="submit">Sign in</button>
                                                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>