<?php 

    namespace App\Http\Controller;

use App\DB\DB;
use Exception;
use PDO;
use App\Http\Controller\Controller;

class AuthController extends Controller{
    private static $tableName = 'auth';
    private static $table;

    public static function initialization(){
        $tableName = self::$tableName;
        $db = DB::connect();
        self::$table = $db;
        $sql = "CREATE TABLE IF NOT EXISTS $tableName(
            id INT AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role TINYINT(1) NOT NULL DEFAULT 0,
            verification TINYINT(1) DEFAULT 0,
            PRIMARY KEY(id)
        )";
        $table = self::$table->prepare($sql);
        $table->execute();

    }

    public static function userRegister($request){
        AuthController::class::initialization();
        $auth = self::$table;
        $tableName = self::$tableName;


        $username = $request->username;
        $email = $request->email;
        $password = $request->password;


        try{
            
            if($username == '' || $email == '' || $password == ''){
                throw new Exception(json_encode([
                    'status'    => 401,
                    'message'   => 'All Field is required'
                ]));
                exit();
            }else{
                $auth->beginTransaction();
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $checkUser = $auth->prepare("SELECT * FROM $tableName WHERE username=:username OR email=:email");
                    $checkUser->bindParam(':username',$username,PDO::PARAM_STR);
                    $checkUser->bindParam(':email',$email,PDO::PARAM_STR);
                    $checkUser->execute();
                    $fetchUser = $checkUser->fetchAll();
                    if(count($fetchUser) == 0){
                        $user = $auth->prepare("INSERT INTO $tableName(username, email, password) VALUES(:username,:email,:password)");
                        $user->bindParam(':username',$username,PDO::PARAM_STR);
                        $user->bindParam(':email',$email,PDO::PARAM_STR);
                        $user->bindParam(':password',$password,PDO::PARAM_STR);
                        if($user->execute()){
                            echo json_encode([
                                'status'    => 200,
                                'message'   => 'User Registration Successfully'
                            ]);
                            $auth->commit();
                            exit();

                        }else{
                            
                            $auth->rollback();
                            throw new Exception(json_encode([
                                'status'    => 401,
                                'message'   => 'User Registratoin Failed.'
                            ]));
                        }
                    }else{
                        throw new Exception(json_encode([
                            'status'    => 401,
                            'message'   => 'User allready exist.'
                        ]));
                    }
                }else{
                    throw new Exception(json_encode([
                        'status'    => 401,
                        'message'   => 'Invalid Email'
                    ]));
                }
                
                
            }


        }catch(Exception $e){
            
            echo $e->getMessage();
            exit();

        }
        
        
    }

    public static function userLogin($request){
        AuthController::todudu();
        exit();
        echo json_encode($request);
    }

    public static function partho(){
        echo 'Hello partho';
    }
    
}