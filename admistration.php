<html>
<?php
session_start();
$pageTitle = "Administration";
?>
    <?php 
      include_once 'head.php';
      require_once "database.php";
      require_once("common.php");
    
     $user = [
        "firstname" => "",
        "lastname" => ""        
    ];
    $fnameError = $lnameError  = [];
    include_once 'validation.php';
        $db = new database();
        $db->connect();
        $data = $db->fileList();
       
        if (isset($_POST["edit"])) {
            $id = $_POST["id"];
            $user = $db->getUserById($id);
        }
        
        if (isset($_POST["delete"])) {
            $id = $_POST["id"];
            $db->deleteList($id);
            header('Location: '.$_SERVER['REQUEST_URI']);
        }

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

            if (!count($fnameError) && !count($lnameError)) {
                $editDetail = $db->admistrationUpdate($user);
                if ($editDetail) {
                    header('Location: admistration.php');
                }
            }
        }
    ?> 
    <?php include_once 'header.php';?>
    <div class="container-fluid">    
        <div class="row">        
            <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <h5 class="card-title text-center">Admistration</h5> 
                        <?php
                        if(isset($_POST["edit"])) { ?>
                        <form class="form-signin" method="post">
                            <div class="form-label-group">
                                <label>First Name</label><span class="error"> * </span>
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                                <input type="text" name="firstname" value="<?php echo $user['firstname'];?>" id="inputEmail" class="form-control" placeholder="First name" required autofocus>
                                <span class="error"><?php echo errorshow($fnameError) ?></span>
                            </div>

                            <div class="form-label-group">
                                <label>Last Name</label><span class="error"> * </span>
                                <input type="text" name="lastname" value="<?php echo $user['lastname'];?>" id="inputEmail" class="form-control" placeholder="Last name" required autofocus>
                                <span class="error"><?php echo errorshow($lnameError) ?></span>
                            </div>
                            <hr class="my-4">
                            <button class="btn btn-lg btn-primary btn-block text-uppercase" name="save" type="submit">Save</button>                            
                        </form> 
                       <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="row">
    <table align="center" border='1' class="table table-dark table-striped">
    <?php
    $data = $db->fileList();
        echo "<thead>";
        echo "<tr>";
            echo "<th>";
                echo "id";
            echo "</th>";
            echo "<th>";
                echo "Firstname";
            echo "</th>";
            echo "<th>";
                echo "Lastname";
            echo "</th>";
            echo "<th>";
                echo "Email";
            echo "</th>";
            echo "<th>";
                echo "Edit";
            echo "</th>";
            echo "<th>";
                echo "Delete";
            echo "</th>";
        echo "</tr>";
        echo "</thead>";
        foreach ($data as $key => $value) {
            if($value["id"] !== $_SESSION["id"]){
                ?><tr><td><?php
                echo $value["id"]; ?></td><td><?php
                echo $value["firstname"]; ?></td><td><?php
                echo $value["lastname"]; ?></td><td><?php
                echo $value["email"]; ?></td>
                <td>
                    <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $data[$key]["id"] ?>">
                    <input type="submit" name="edit" value="Edit"/>
                </form>
                </td>   
                <td>
                    <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $data[$key]["id"] ?>">
                    <input type="submit" name="delete" value="Delete"/>
                </form>
                </td>
              </tr> <?php     
            echo "</tr>";
                echo "</tbody>";
            }
        }
    ?>
        </table>
    </div>
    
    </div>
</html>