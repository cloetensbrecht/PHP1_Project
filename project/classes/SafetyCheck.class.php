<?php 
    class SafetyCheck{
        // check email - isValidEmail
        public static function isValidEmail($email){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){ 
                return true;
            }
            return false;
        }

    }   