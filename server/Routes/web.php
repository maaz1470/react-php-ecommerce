<?php 

    use Package\Routes\Routes as Route;

    use App\App;
use App\Http\Controller\AuthController;
use App\Http\Controller\CategoryController;

    Route::initialization();
    Route::get('/',function(){
        App::class::home();
    });

    Route::post('/auth/register-user',function($data){
        AuthController::class::userRegister($data);
    });

    Route::post('/auth/user-login',function($data){
        AuthController::class::userLogin($data);
    });

    Route::get('/authCheck',function(){
        AuthController::class::checkUser();
    });

    Route::post('/category/add',function($data){
        CategoryController::class::addCategory($data);
    });