<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\api\v1;

/**
 * Description of DashBoardController
 *
 * @author danielunag
 */
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveys;
use App\Http\Controllers\api\v1\Api;

class DashBoardController extends Api {

    public function index(Request $request) {
        try {
            $id = $request->get("id");

            $survey = mstSurveys::find($id)->where("status", 1)
                    ->with("surveyType")->with([
                        "mstQuestions" => function($subquery) {
                            $subquery->where("status", 1);
                        }, 'mstQuestions.questionAnswers' => function($subquery) {
                            
                        }, 'mstQuestions.catQuestionType' => function($subquery) {
                            
                        }, 'mstQuestions.catQuestionType.answerType' => function($subquery) {
                            
                        }, 'mstQuestions.surveyAnswer' => function($subquery) {
                            
                        }, 'mstQuestions.surveyAnswer.surveyApplied' => function($subquery) {
                            
                        }, 'mstQuestions.surveyAnswer.surveyApplied.surveySubject' => function($subquery) {
                            
                        }    
                                
                    ])
                    ->get();

            return $survey;
        } catch (\Exception $e) {
            return response()->json(["status" => false, "message" => "No fue posible obtener las estadísticas de la encuesta seleccionada " . $e->getMessage()]);
        }
    }

}
