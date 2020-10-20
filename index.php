<?php
session_start();
if (isset($_SESSION['id'])) {
    header('Location: profile.php');
}
?>
<html>
    <?php include_once 'head.php';?>
    <?php require_once "database.php";?>
<body>
<?php
    $db = new database();
    $db->connect();
    $user = [
        "email" => "",
        "password" => ""
    ];    
    $emailError = $passwordError = $loginError = [];
    include_once 'validation.php'; 
    if (isset($_POST['submit'])) {
        header('Location: signup.php');
    }    
    if (isset($_POST['login'])) {
        if (isset($_POST["email"])) {
            $user["email"] = checkfun($_POST["email"]);
            $emailError = valid_email($user["email"]);
        }
        
        if (isset($_POST["password"])) {
            $user["password"] = checkfun($_POST["password"]);
            $passwordError = valid_password($user["password"]);
        }
        
        if (!count($emailError) && !count($passwordError)) {       
            $userDetails = $db->login($user);
            if($userDetails){
                $_SESSION['id'] = $userDetails['id'];
                $_SESSION['firstname'] = $userDetails['firstname'];
                $_SESSION['isAdmin'] = $userDetails['isAdmin'];                             
                header('Location: profile.php');
            } else {
                $loginError[] = "Invalid email and password.";
            }
        }
    }
               
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Login</h5>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <span class="error"><?php echo errorshow($loginError) ?></span><br>
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
                                <button class="btn btn-lg btn-primary btn-block text-uppercase" name="login" type="submit">Login</button>
                                <hr class="my-4">
                                <a class="btn btn-lg btn-primary btn-block text-uppercase" href="signup.php">Sign in</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>