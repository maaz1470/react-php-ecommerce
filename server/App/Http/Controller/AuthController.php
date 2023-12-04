<?php 

    namespace App\Http\Controller;

use App\Config;
use App\DB\DB;
use Exception;
use PDO;
use App\Http\Controller\Controller;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller{
    
    private static $tableName = 'auth';
    private static $table;

    public static function initialization(){
        new Controller();
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
        $password = password_hash($request->password,PASSWORD_BCRYPT);


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
        AuthController::class::initialization();
        $tableName = self::$tableName;
        $table = self::$table;
        $username = $request->username;
        $password = $request->password;

        try{
            if(($username && $password) != ''){
                $user = $table->prepare("SELECT * FROM $tableName WHERE username=:username");
                $user->bindParam(':username',$username, PDO::PARAM_STR);
                $user->execute();
                $fetchUser = $user->fetch(PDO::FETCH_OBJ);
                if($user->rowCount() > 0){
                    if(password_verify($password,$fetchUser->password)){
                        $secret_key = 'Rahat Hossain';
                        $time = time();
                        $expire_at = time() + 31104000;
                        $domain_name = 'http://localhost:3000';
                        $setUser = [
                            'username'  => $fetchUser->username,
                            'id'        => $fetchUser->id
                        ];

                        $request_data = [
                            'iat'       => $time,
                            'iss'       => $domain_name,
                            'nbf'       => $time,
                            'exp'       => $expire_at,
                            'userName'  => $setUser
                        ];
                        $token = JWT::encode($request_data,$secret_key,'HS256');

                        if($token){
                            echo json_encode([
                                'status'    => 200,
                                'message'   => 'You are successfully login.',
                                'token'     => $token
                            ]);
                            exit();
                        }

                    }else{
                        throw new Exception('Username or Password not matched.');
                    }
                }else{
                    throw new Exception('Username or Password not matched.');
                }
            }else{
                throw new Exception('All Field is Required.');
            }
        }catch(Exception $e){
            echo json_encode([
                'status'    => 401,
                'message'   => $e->getMessage()
            ]);
            exit();
        }
    }

    public static function checkUser(){
        if($_SERVER['HTTP_AUTHORIZATION'] != ''){
            preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches);
            $jwt = $matches[1];
            if(!$jwt){
                echo json_encode([
                    'status'    => 402,
                    'url'   => '/auth/user-login'
                ]);
            }else{
                try{
                    $secret_key = 'Rahat Hossain';
                    $token = JWT::decode($jwt, new Key($secret_key, 'HS256'));
                    $now = time();
                    $server_name = Config::$front_url;
                    if(isset($token)){
                        if($token->iss != $server_name || $token->nbf > $now || $token->exp < $now){
                            throw new Exception(json_encode([
                                'status'    => 401,
                                'user'  => false
                            ]));
                        }else{
                            echo json_encode([
                                'status'    => 200,
                                'user'  => true
                            ]);
                            exit();
                        }
                    }
                }catch(Exception $e){
                    echo json_encode([
                        'status'    => 401,
                        'message'   => 'Unauthorized user.',
                        'user'  => false
                    ]);
                    exit();
                }
            }
        }
    }

    
}