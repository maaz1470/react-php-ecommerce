<?php 

    use Package\Routes\Routes as Route;

    use App\App;

    Route::get('/',function(){
        App::class::home();
    });