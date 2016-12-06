<?php
//this is the endpoint of auth
$app->post('/auth/login', 'Auth\AuthController@postLogin');

//this is an endpoint without auth
$app->get('api/status', function (){
    return "v1.0";
});

//these are endpoints that required auth
$app->group([
    'middleware' => 'jwt.auth',
    'prefix' => 'api/v1',
//    'namespace' => 'App\Http\Controllers'
    ],
        function ($app) {
    //get all user 
    $app->post("user", "api\\v1\UserController@index");
    //create new user
    $app->post("user/create", "api\\v1\UserController@create");
    //delete user
    $app->post("user/delete", "api\\v1\UserController@delete");
    //update user
    $app->post("user/update", "api\\v1\UserController@update");
    
//    //Listar todos los productos
//    $app->get('producto','ProductoController@index');
//    //Listar un producto
//    $app->get('producto/{id}','ProductoController@obtProducto');
//    //Crear un producto
//    $app->post('producto','ProductoController@crearProducto');
//    //Actualizar un Producto
//    $app->put('producto/{id}','ProductoController@actualizarProducto');
//    //borrar un producto
//    $app->delete('producto/{id}','ProductoController@borrarProducto');
//    //Refresh token
//    $app->get('/auth/refresh', 'App\Http\Controllers\Auth\AuthController@getRefresh');
//    //close token
//    $app->delete('/auth/invalidate', 'App\Http\Controllers\Auth\AuthController@deleteInvalidate');
});





