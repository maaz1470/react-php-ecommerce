<?php 

    use Package\Routes\Routes as Route;

    use App\App;
use App\Http\Controller\AuthController;
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