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
            "surveyAnswer"                                          => "array|min:1|required",
            "surveyAnswer.*.questionData"                           => "array|min:1|required",
            "surveyAnswer.*.questionData.*.answer"                  => "string|required",
            "surveyAnswer.*.question.*.idQuestion"                  => "integer|min:1",
            "surveyAnswer.*.surveySubjectData"                      => "array",
            "surveyAnswer.*.surveySubjectData.newsletter"           => "integer|required",
            "surveyAnswer.*.surveySubjectData.eventSubscription"    => "integer|required",
            "surveySubjectData.gender"                              => "string|min:1|max:1",
            "surveyAnswer.*.questionData"                           => "array|required|min:1"
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
    
    public function store(Request $request) {
        if (!($validate = $this->validateRequest($request, "create")) == true)
                return $validate;
        
        try {
                $surveyAnswers = $request->input("surveyAnswer");
                foreach ($surveyAnswers as $surveyAnswer){
                    $idSurvey = $surveyAnswer['id'];
                    $survey = mstSurveys::find($idSurvey);

                    $surveyAppliedData = array("idSurvey" => $idSurvey, "completed" => 1);

                    if (!($surveyApplied = mstSurveyApplied::create($surveyAppliedData)))
                        return response()->json(["status" => 0, "message" => "Error al registrar encuesta contestada"]);

                    $this->setValuesRestrictedOfCreate($surveyApplied);

                    $surveySubjetc = ((int)$survey->anon == 1) ? null : mstSurveySubject::create($surveyAnswer["surveySubjectData"]);

                    foreach ($surveyAnswer["questionData"] as $key => $answerQuestion){
                        $answerQuestion['idSurveyApplied'] = $surveyApplied->id;
                        $answerQuestion['idSurveyApplied'] = ((int)$survey->anon == 1) ? null : $surveySubjetc->id;

                        if(!($surveyAnswer = mstSurveyAnswer::create($answerQuestion)))
                                return response ()->json (["status" => false, "message" => "Error al registrar una de las respuestas."]);
                    }
                }
            
            
            return response()->json(["status" => true, "message" => "Datos almacenados"]);
        } catch (\Exception $e) {
            return response()->json(["status" => 0, "message" => $e->getMessage()]);
        }

    }

}
