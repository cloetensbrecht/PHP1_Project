<?php

    // om connectie te maken > $conn = Db::getInstance(); // DRY
    abstract class Db
    {
        private static $conn;

        public static function getInstance()
        {
            if (self::$conn != null) {
                //echo '🚫 NO CONNECTION TO DB';
                // connection found, return connection
                return self::$conn;
            } else {
                //echo '💃🏻 BINNEN';
                //$config = parse_ini_file('config/config.ini');
                //self::$conn = new PDO('mysql:host=localhost;dbname=' . $config['db_name'], $config['db_user'], $config['db_password'] );
                self::$conn = new PDO('mysql:host=localhost;dbname=travelinspiration', 'root', 'root');
                //self::$conn = new PDO('mysql:host=sql307.epizy.com;dbname=epiz_23910941_travelinspiration', 'epiz_23910941', 'dusjac-3duzzY-rebkef');

                return self::$conn;
            }
        }
    }
