<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveyApplied;
use App\mstSurveys;
use App\mstQuestionAnswer;
use App\mstQuestion;
use App\mstSurveyAnswer;
use App\mstSurveySubject;
use App\Exceptions\SystemMessages;
use App\Http\Controllers\api\v1\Api;

class SurveyAnswerController extends Api {
    public function __construct() {
        $this->setArrayCreate([
            "questionData"                          => "array|min:1|required",
            "questionData.*.answer"                 => "string|required",
            "question.*.idQuestion"                 => "integer|min:1",
            "question.*.idQuestionAnswer"           => "integer|min:1",
            "surveySubjectData"                     => "array",
            "surveySubjectData.newsletter"          => "integer|required",
            "surveySubjectData.eventSubscription"   => "integer|required",
            "surveySubjectData.gender"              => "string|min:1|max:1"
        ]);        
        
        $this->setArrayUpdate([

        ]);        
        
        $this->setArrayDelete([
            'id'                          => 'integer|required|'
        ]);
        parent::__construct();
    }
    
    
    public function index(Request $request){
        
    }
    
    public function create(Request $request) {
        if (!($validate = $this->validateRequest($request, "create")) == true)
                return $validate;
        
        try {
            
            $idSurvey = $request->input("id");
            $survey = mstSurveys::find($idSurvey);
                    
            $surveyAppliedData = array("idSurvey" => $idSurvey, "completed" => 1);
            
            if (!($surveyApplied = mstSurveyApplied::create($surveyAppliedData)))
                return response()->json(["status" => 0, "message" => "Error al registrar encuesta contestada"]);
            
            $this->setValuesRestrictedOfCreate($surveyApplied);
            
            $surveySubjetc = ((int)$survey->anon == 1) ? null : mstSurveySubject::create($request->input("surveySubjectData"));
            
            foreach ($request->input("questionData") as $key => $answerQuestion){
                $answerQuestion['idSurveyApplied'] = $surveyApplied->id;
                $answerQuestion['idSurveyApplied'] = ((int)$survey->anon == 1) ? null : $surveySubjetc->id;
                
                if(!($surveyAnswer = mstSurveyAnswer::create($answerQuestion)))
                        return response ()->json (["status" => false, "message" => "Error al registrar una de las respuestas."]);
            }
            
            return response()->json(["status" => true, "message" => "Datos almacenados"]);
        } catch (\Exception $e) {
            return response()->json(["status" => 0, "message" => $e->getMessage()]);
        }

    }

}