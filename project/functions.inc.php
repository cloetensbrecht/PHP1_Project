<?php

session_start();

function isPasswordStrongEnough ($password){
    if(strlen($password) < 8 ){
        return false;
    }
    return true;
}

function isEqual($item1, $item2){
    if($item1 != $item2){
        return false;
    }
    return true;
}

function canRegister ($email, $password, $passwordConfirmation){
    if(!isEqual($password1, $password2)){
        return false;
    }

    if(!isPasswordStrongEnough($password1)){
        return false;
    }

    if(empty($email)){
        return false;
    }
    return true;
}
?>