<?php 

    namespace App\Http\Controller;
    
class AuthController{
    public static function userRegister($request){
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;

        echo $username;
    }
}