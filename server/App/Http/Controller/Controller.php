<?php 
    namespace App\Http\Controller;

class Controller{
    private static function hello(){
        echo "Hello World";
    }

    public static function todudu(){
        self::hello();
    }
}