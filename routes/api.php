<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/* ----------   System   ----------     */
Route::group([
    'middleware' => ["CatchAllOptionsRequestsProvider"],
    ],
    function ($app) {
        Route::match(['get', 'post'],"status", "api\\v1\StatusController@status");
    });

//these are endpoints that required auth
Route::group([
    'middleware' => [
//        "CatchAllOptionsRequestsProvider", 
        'jwt.auth'],
    'prefix' => 'v1',
//    'namespace' => 'App\Http\Controllers'
    ],
        function ($app) {
    
    /* ----------   Users   ----------     */
    Route::match(['get', 'post'],"user", "api\\v1\UserController@index");
    Route::match(['get', 'post'],"user/create", "api\\v1\UserController@create");
    Route::match(['get', 'post'],"user/delete", "api\\v1\UserController@delete");
    Route::match(['get', 'post'],"user/update", "api\\v1\UserController@update");
    
    /* ----------   Roles   ----------     */
    Route::match(['get', 'post'],"roles"       , "api\\v1\RolesController@index");
    Route::match(['get', 'post'],"roles/create", "api\\v1\RolesController@create");
    Route::match(['get', 'post'],"roles/delete", "api\\v1\RolesController@delete");
    Route::match(['get', 'post'],"roles/update", "api\\v1\RolesController@update");
    
    /* ----------   Surveys ----------     */
    Route::match(['get', 'post'],"survey/"     , "api\\v1\SurveyController@index");
    Route::match(['get', 'post'],"survey/create", "api\\v1\SurveyController@create");
    Route::match(['get', 'post'],"survey/delete", "api\\v1\SurveyController@delete");
    Route::match(['get', 'post'],"survey/status", "api\\v1\SurveyController@status");
    Route::match(['get', 'post'],"survey/update", "api\\v1\SurveyController@update");
    
    Route::match(['get', 'post'],"surveyanswer/"     , "api\\v1\SurveyAnswerController@index");
    Route::match(['get', 'post'],"surveyanswer/store", "api\\v1\SurveyAnswerController@store");
    
    /* --------- cat surveys ---------     */
    Route::match(['get', 'post'],"surveyType/", "api\\v1\CatSurveyTypeController@index");
    Route::match(['get', 'post'],"surveyType/create", "api\\v1\CatSurveyTypeController@create");
    Route::match(['get', 'post'],"surveyType/update", "api\\v1\CatSurveyTypeController@update");
    Route::match(['get', 'post'],"surveyType/delete", "api\\v1\CatSurveyTypeController@delete");
    
    /* -------- SurveyApplied --------     */
    Route::match(['get', 'post'],"surveyapplied/"      , "api\\v1\SurveyAppliedController@index");
    Route::match(['get', 'post'],"surveyapplied/create", "api\\v1\SurveyAppliedController@create");
    Route::match(['get', 'post'],"surveyapplied/update", "api\\v1\SurveyAppliedController@update");
    Route::match(['get', 'post'],"surveyapplied/delete", "api\\v1\SurveyAppliedController@delete");
    
    /* --------- ServeySubject -------     */
    Route::match(['get', 'post'],"surveysubject/"      , "api\\v1\SurveySubjectController@index");
    Route::match(['get', 'post'],"surveysubject/create", "api\\v1\SurveySubjectController@create");
    Route::match(['get', 'post'],"surveysubject/update", "api\\v1\SurveySubjectController@update");
    Route::match(['get', 'post'],"surveysubject/delete", "api\\v1\SurveySubjectController@delete");
    
    /* --------- cat_QuestionType -------     */
    Route::match(['get', 'post'],"questionType/"      , "api\\v1\CatQuestionTypeController@index");
    Route::match(['get', 'post'],"questionType/create", "api\\v1\CatQuestionTypeController@create");
    Route::match(['get', 'post'],"questionType/update", "api\\v1\CatQuestionTypeController@update");
    Route::match(['get', 'post'],"questionType/delete", "api\\v1\CatQuestionTypeController@delete");
   
    /* ----------   Token   ----------     */
    $app->get('/auth/refresh', 'Auth\AuthController@getRefresh');
    Route::match(['get', 'post'],'/auth/invalidate', 'Auth\AuthController@deleteInvalidate');
    
    
    /* ----------   Sync   ----------     */
    Route::match(['get', 'post'],'/sync', "api\\v1\SyncController@index");
    
    /* ----------   Dashboard   ----------     */
    Route::match(['get', 'post'],"dashboard/survey/"     , "api\\v1\DashBoardController@index");
});
