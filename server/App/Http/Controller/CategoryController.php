<?php 

    namespace App\Http\Controller;

use App\DB\DB;
use Exception;
use PDO;

class CategoryController{
    protected static $tableName = 'categories';
    protected static $table;
    protected static function initialization(){
        $db = DB::connect();
        self::$table = $db;
        $tableName = self::$tableName;

        $sql = "CREATE TABLE IF NOT EXISTS $tableName(
            id int AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            url varchar(255) NOT NULL UNIQUE,
            status TINYINT DEFAULT 0,
            PRIMARY KEY(id)
        )";
        $table = self::$table->prepare($sql);
        $table->execute();
    }

    protected static function createCategoryURL($url){
        CategoryController::class::initialization();
        $url = str_replace(' ','-',$url);
        $tableName = self::$tableName;
        $table = self::$table;
        $check_url = $table->prepare("SELECT * FROM $tableName WHERE url=:url");
        $check_url->bindParam(':url',$url,PDO::PARAM_STR);
        $check_url->execute();
        if($check_url->rowCount() > 0){
            $url = $url . '-' . $check_url->rowCount();
        }else{
            $url = $url;
        }

        return $url;
    }

    public static function addCategory($request){
        echo self::createCategoryURL($request->name);
        exit();
        CategoryController::class::initialization();
        $tableName = self::$tableName;
        $table = self::$table;
        
        try{

            $name = $request->name;
            $status = $request->status;

            $url = self::createCategoryURL($name);

            $category = $table->prepare("INSERT INTO $tableName(name,url,status) VALUES(:name, :url, :status)");
            $category->bindParam(':name',$name,PDO::PARAM_STR);
            $category->bindParam(':url',$url,PDO::PARAM_STR);
            $category->bindParam(':status',$status,PDO::PARAM_INT);
            if($category->execute()){
                echo json_encode([
                    'status'    => 200,
                    'message'   => 'Category saved successfully'
                ]);
            }else{
                throw new Exception('Something went wrong. Please try again');
            }

        }catch(Exception $e){
            echo json_encode([
                'status'    => 401,
                'message'   => $e->getMessage()
            ]);
        }

    }
}