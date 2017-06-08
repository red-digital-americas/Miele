<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\api\v1\app;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveySubject;
use App\Http\Controllers\api\v1\Api;
use App\User;
use App\mstSurveys;
use App\catQuestionType;
use JWTAuth;

class SyncController extends Api{
    public function __construct() {
       
        parent::__construct();
    }
    
    public function index(Request $request){
//        $payload = JWTAuth::parseToken()->getPayload();
//$expires_at = date('d M Y h:i', $payload->get('exp')); 
//return $expires_at;
        $users = User::all();
        $surveys = mstSurveys::with("surveyType")->with([
                        "mstQuestions" => function($subquery){
                        $subquery->where("status", 1);
                    }, 'mstQuestions.questionAnswers' => function($subquery){

                    }, 'mstQuestions.catQuestionType' => function($subquery){

                    },'mstQuestions.catQuestionType.answerType' => function($subquery){

                    }
                            
                    ])->get();
                    
        $questionsType = catQuestionType::with("answerType")->get();
                    
        return response()->json(["status" => 1, "message" => "usted se esta sincronizando", "data" => array("users" => $users, "surveys" => $surveys, "questionsType" => $questionsType)]);
    }
}
