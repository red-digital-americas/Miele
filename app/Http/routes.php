<?php
//this is the endpoint of auth
$app->post('/auth/login', ['middleware' => 'CorsMiddleware', 'uses' => 'Auth\AuthController@postLogin']);

//this is an endpoint without auth
$app->get('api/status', function (){
    return "v1.0";
});

/* ----------   System   ----------     */
$app->group([
    'middleware' => ["CatchAllOptionsRequestsProvider"],
    ],
    function ($app) {
        $app->post("status", "api\\v1\StatusController@status");
    });

//these are endpoints that required auth
$app->group([
    'middleware' => ["CatchAllOptionsRequestsProvider", 'jwt.auth'],
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
    $app->post("survey/status", "api\\v1\SurveyController@status");
    $app->post("survey/update", "api\\v1\SurveyController@update");
    
    $app->post("surveyanswer/"     , "api\\v1\SurveyAnswerController@index");
    $app->post("surveyanswer/store", "api\\v1\SurveyAnswerController@store");
    
    /* --------- cat surveys ---------     */
    $app->post("surveyType/", "api\\v1\CatSurveyTypeController@index");
    $app->post("surveyType/create", "api\\v1\CatSurveyTypeController@create");
    $app->post("surveyType/update", "api\\v1\CatSurveyTypeController@update");
    $app->post("surveyType/delete", "api\\v1\CatSurveyTypeController@delete");
    
    /* -------- SurveyApplied --------     */
    $app->post("surveyapplied/"      , "api\\v1\SurveyAppliedController@index");
    $app->post("surveyapplied/create", "api\\v1\SurveyAppliedController@create");
    $app->post("surveyapplied/update", "api\\v1\SurveyAppliedController@update");
    $app->post("surveyapplied/delete", "api\\v1\SurveyAppliedController@delete");
    
    /* --------- ServeySubject -------     */
    $app->post("surveysubject/"      , "api\\v1\SurveySubjectController@index");
    $app->post("surveysubject/create", "api\\v1\SurveySubjectController@create");
    $app->post("surveysubject/update", "api\\v1\SurveySubjectController@update");
    $app->post("surveysubject/delete", "api\\v1\SurveySubjectController@delete");
    
    /* --------- cat_QuestionType -------     */
    $app->post("questionType/"      , "api\\v1\CatQuestionTypeController@index");
    $app->post("questionType/create", "api\\v1\CatQuestionTypeController@create");
    $app->post("questionType/update", "api\\v1\CatQuestionTypeController@update");
    $app->post("questionType/delete", "api\\v1\CatQuestionTypeController@delete");
   
    /* ----------   Token   ----------     */
    $app->get('/auth/refresh', 'Auth\AuthController@getRefresh');
    $app->post('/auth/invalidate', 'Auth\AuthController@deleteInvalidate');
    
    
    /* ----------   Sync   ----------     */
    $app->post('/sync', "api\\v1\SyncController@index");
    
    /* ----------   Dashboard   ----------     */
    $app->post("dashboard/survey/"     , "api\\v1\DashboardController@index");
});