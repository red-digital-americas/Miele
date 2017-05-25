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
use App\mstSurveyApplied;
use App\Http\Controllers\api\v1\Api;
use \Maatwebsite\Excel\Facades\Excel;

class DashBoardController extends Api {

    public function index(Request $request) {
        try {
            $id = $request->get("id");

            $survey = mstSurveys::
                    where("id", $id)
                    ->with([
                        "mstQuestions" => function($subquery) use ($id) {
                            $subquery->where("status", 1);
                        },
                        "mstQuestions" => function($subquery) use ($id) {
                            $subquery->where("status", 1);
                        },
                        'mstQuestions.questionAnswers' => function($subquery) {
                            
                        },
                        'mstQuestions.catQuestionType' => function($subquery) {
                            
                        },
                        'mstQuestions.catQuestionType.answerType' => function($subquery) {
                            
                        },
                        'mstQuestions.surveyAnswer' => function($subquery) {
                            
                        },
                        'mstQuestions.surveyAnswer.surveyApplied' => function($subquery) {
                            
                        },
                        'mstQuestions.surveyAnswer.surveyApplied.surveySubject' => function($subquery) {
                            
                        }
                    ])
                    ->with("surveyType")
                    ->first()
            ;

            return $survey;
        } catch (\Exception $e) {
            return response()->json(["status" => false, "message" => "No fue posible obtener las estadísticas de la encuesta seleccionada " . $e->getMessage()]);
        }
    }

    public function downloadExcel(Request $request) {
        try {
            $id = $request->get("id");

            $survey = $this->getSurveyBySubject($id);
            
            $raws = $this->getExcelRows($survey);

            Excel::create('Miele Dashboard', function($excel) use($raws) {
                $excel->sheet('Encuesta', function($sheet) use($raws) {
                    $sheet->fromArray($raws);
                });
            })->download('xls');

            return $survey;
        } catch (\Exception $e) {
            return response()->json(["status" => false, "message" => "No fue posible crear el excel " . $e->getMessage()]);
        }
    }

    private function getExcelRows($survey) {
        $rows = array();
        
        foreach ($survey as $surveyApplied) {
            $row = array("Fecha" => $surveyApplied["created_at"], "Nombre" => "Anónimo", "email" => "", "Recibe noticias" => "", "Suscripción Eventos" => "");

            $answersCollection = array();

            if ($surveyApplied["survey_subject"] !== null) {
                $row["Nombre"] = $surveyApplied["survey_subject"]["name"] . " " . $surveyApplied["survey_subject"]["last_name"] . " " . $surveyApplied["survey_subject"]["mothers_last_name"];
                $row["email"] = $surveyApplied["survey_subject"]["email"];
                $row["Recibe noticias"] = ((int) $surveyApplied["survey_subject"]["newsletter"] == 1) ? "Si" : "No";
                $row["Suscripción Eventos"] = ((int) $surveyApplied["survey_subject"]["eventSubscription"] == 1) ? "Si" : "No";
            }
            //concat each question / answer in rows separeted
            foreach ($surveyApplied["survey_answer"] as $answer) {
                $idQuestion = $answer["question"]["id"];
                $question = $answer["question"];

                if (!isset($answersCollection[$idQuestion]))
                    $answersCollection[$idQuestion] = array("question" => $question["text"], "answer" => $answer["answer"]);
                else
                    $answersCollection[$answer["question"]["id"]]["answer"] .= ", " . $answer["answer"];    // concat answer in the same cell
            }

            foreach ($answersCollection as $value) {
                $row[] = $value["question"];
                $row[] = $value["answer"];
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function getSurveyBySubject($id) {

        return mstSurveyApplied::
                        where("idSurvey", $id)
                        ->with([
                            "survey" => function($subquery) {
                                
                            },
                            "surveySubject" => function($subquery) {
                                
                            },
                            "surveyAnswer" => function($subquery) {
                                
                            },
                            "surveyAnswer.question" => function($subquery) {
                                
                            }
                        ])
                        ->get()->toArray();
    }

}
