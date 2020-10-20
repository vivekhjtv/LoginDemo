
<?php
function checkfun($input_data)
{
    $input_data = trim($input_data);
    $input_data = stripslashes($input_data);
    $input_data = htmlspecialchars($input_data);
    return $input_data;
}
function errorshow(array $err):string
{
    $a = "";
    for ($i = 0; $i < count($err); $i++) {
        $a .= "<br>" . $err[$i];
    }
    return $a;
}
function isActive($link){
    $url = $_SERVER["REQUEST_URI"];
    $url_explode = explode("/" , $url);
    $currentURL = end($url_explode);
    switch ($link) {
        case 'Profile':
            return $currentURL === "profile.php" || $currentURL === "edit_profile.php";
        case 'Admin':
            return $currentURL === "admistration.php";
        default:
            return false;
    }
}
?>