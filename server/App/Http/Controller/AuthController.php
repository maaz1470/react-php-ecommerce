<?php 

    namespace App\Http\Controller;

use App\DB\DB;

class AuthController{
    private $tableName = 'auth';
    public static function initialization(){
        $tableName = self::$tableName;
        $db = DB::connect();
        $sql = "CREATE TABLE $tableName(
            id int 
        )";
    }
    public static function userRegister($request){
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;
        
    }
}