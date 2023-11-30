<?php

    namespace App\DB;

use Exception;
use PDO;

class DB{
    private static $host='localhost';
    private static $user = 'root';
    private static $password = '';
    private static $dbname = 'php_practice_2';


    public static function connect(){
        $host = self::$host;
        $user = self::$user;
        $password = self::$password;
        $dbname = self::$dbname;
        try{
            $sql = "mysql:host=$host;dbname=$dbname";
            if($conn = new PDO($sql,$user,$password)){
                return $conn;
            }else{
                throw new Exception($conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
            }
        }catch(Exception $e){
            echo json_encode($e->getMessage());
            exit();

        }
    }
}