<?php 
    class Security {
        public static function hash($password) {
            $options = [
                'cost' => 12
            ];

            // HASH password
            $hash = password_hash($password, PASSWORD_DEFAULT, $options);

            // RETURN password
            return $hash;
        }
    }