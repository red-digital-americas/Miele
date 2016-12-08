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
    
    /* ----------   Users   ----------     */
    $app->post("user"       , "api\\v1\UserController@index");
    $app->post("user/create", "api\\v1\UserController@create");
    $app->post("user/delete", "api\\v1\UserController@delete");
    $app->post("user/update", "api\\v1\UserController@update");
    
    /* ----------   Roles   ----------     */
    $app->post("roles"       , "api\\v1\RolesController@index");
    $app->post("roles/create", "api\\v1\RolesController@create");
    $app->post("roles/delete", "api\\v1\RolesController@delete");
    $app->post("roles/update", "api\\v1\RolesController@update");
    
    /* ----------   Surveys ----------     */
    $app->post("survey/"     , "api\\v1\SurveyController@index");
    $app->post("survey/create", "api\\v1\SurveyController@create");
    $app->post("survey/delete", "api\\v1\SurveyController@delete");
    $app->post("survey/update", "api\\v1\SurveyController@update");
    
    /* --------- cat surveys ---------     */
    $app->post("catsurveystype/", "api\\v1\CatSurveyTypeController@index");
    $app->post("catsurveystype/create", "api\\v1\CatSurveyTypeController@create");
    $app->post("catsurveystype/update", "api\\v1\CatSurveyTypeController@update");
    $app->post("catsurveystype/delete", "api\\v1\CatSurveyTypeController@delete");
    /* ----------   Token   ----------     */
    $app->get('/auth/refresh', 'App\Http\Controllers\Auth\AuthController@getRefresh');
    $app->delete('/auth/invalidate', 'App\Http\Controllers\Auth\AuthController@deleteInvalidate');
});





