<?php

    include_once 'common.php';    

function valid_firstname($firstname){
    $fnameError = [];
    if (!preg_match("/^[a-zA-Z' ]*$/i", $firstname)) {
        $fnameError[] = "Only character are allowed.";
    }
    return $fnameError;
}
function valid_lastname($lastname){
    $lnameError = [];
    if (!preg_match("/^[a-zA-Z' ]*$/i", $lastname)) {
        $lnameError[] = "Only character are allowed.";
    }
    return $lnameError;
}
function valid_email($email){
    $emailError = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError[] = "Invalid email format.";
    }
    return $emailError;
}
function valid_password($password){
    $passwordError = [];
    if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/", $password)) {
        $passwordError[] = "Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters.";
    }
    return $passwordError;
}


?>