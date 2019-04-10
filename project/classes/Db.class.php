<?php 
    // om connectie te maken > $conn = Db::getInstance(); // DRY 
    abstract class Db {
        private static $conn;
        public static function getInstance(){
            if(self::$conn != null){
                echo "🚫";
                // connection found, return connection
                return self::$conn;
            } else{
                //$config = parse_ini_file('config/config.ini');
                //self::$conn = new PDO('mysql:host=localhost;dbname=' . $config['db_name'], $config['db_user'], $config['db_password'] );
                
                self::$conn = new PDO("mysql:host=localhost;dbname=InspirationHunter", "root", "root");
                return self::$conn;
            }
        }
    }

    
