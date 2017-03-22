<?php
/**
 * @copyright (c) 2017, Apernet 
 * @author Daniel Luna dluna@aper.net
 */
namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveys;
use App\mstQuestionAnswer;
use App\mstQuestion;
use App\Exceptions\SystemMessages;
use App\Http\Controllers\api\v1\Api;

class SurveyController extends Api{
    protected $arrayAnswerKey = array();
    public function __construct() {
        $this->setArrayUpdate([
            'id'                            => 'integer|required',
            'name'                          => 'string|max:100|min:3',
            "welcome_text"                  => "string|max:255",
            "finish_text"                   => "string|max:255",
            "anon"                          => "integer",
            "reactivate"                    => "integer"
        ]);
        
        $this->setArrayCreate([
            'name'                          => 'string|required|max:100|min:3',
            "welcome_text"                  => "string|max:255",
            "finish_text"                   => "string|max:255",
            "anon"                          => "integer|required|min:0|max:1",
            "questions"                     => "array|min:1|required",
            "questions.*.text"              => "string|required",
            "questions.*.idQuestionType"    => "integer|required",
            "questions.*.answers"           => "array",
            "questions.*.answers.*.text"    => "string|required",
            "questions.*.answers.*.id"      => "string|required",
        ]);
        
        $this->setArrayDelete([
            'id'                          => 'integer|required|'
        ]);
        parent::__construct();
    }
        
    public function index(Request $request){
        $idSurvey = $request->get("id");
        if((int) $idSurvey > 0){
            $surveys = mstSurveys::
                    where("id", $idSurvey)
                    ->with("surveyType")->with([
                        "mstQuestions" => function($subquery){
                        $subquery->where("status", 1);
                    }, 'mstQuestions.questionAnswers' => function($subquery){

                    }, 'mstQuestions.catQuestionType' => function($subquery){

                    },'mstQuestions.catQuestionType.answerType' => function($subquery){

                    }
                            
                    ])->get();
        }
        else
            $surveys = mstSurveys::with("surveyType")->with([
                        "mstQuestions" => function($subquery){
                        $subquery->where("status", 1);
                    }, 'mstQuestions.questionAnswers' => function($subquery){

                    }, 'mstQuestions.catQuestionType' => function($subquery){

                    },'mstQuestions.catQuestionType.answerType' => function($subquery){

                    }
                            
                    ])->get();
                    
        return response()->json($surveys);
    }
    
    public function create(Request $request){        
        if(!($validate = $this->validateRequest($request, "create")) == true)
            return $validate;
               
        return $this->createSurvey($request);
    }
    
    private function createSurvey(Request $request){
//        if($this->getSurveyByName($request->get("name")) != NULL)
//            return response()->json (["status" => false, "message" => "already exists this survey name"]);
        
        if(($newSurvey = mstSurveys::create($request->all()))){
            $this->setValuesRestrictedOfCreate($newSurvey);
            $questions = $request->get("questions");
            $this->saveQuestion($newSurvey, $questions);
            
            return response ()->json (["status" => true, "message" => "survey created", $newSurvey]);
        }
        else
            return response ()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION, 
            IlluminateResponse::HTTP_BAD_REQUEST]);
    }
    
    private function saveQuestion($newSurvey, $questions_){
        $questions = $this->sortQuestions($questions_);

        foreach ($questions as $index => $q){
            $q['idSurvey'] = $newSurvey->id;
            $question = mstQuestion::create($q);
            
            $this->arrayAnswerKey[$index]['id'] = $question->id;
            
            $this->setValuesRestrictedOfCreate($question);
            $this->saveQuestionAnswers($q, $question);
            
            if(strcasecmp($q['idParent'], 0) !== 0 ){
                 $question->idParent = $this->arrayAnswerKey[$q['idParent']]['id'];
                 if(isset($this->arrayAnswerKey[$q['idParent']][$q['conditionalAnswer']]))
                    $question->answer = $this->arrayAnswerKey[$q['idParent']][$q['conditionalAnswer']];
                 else{
//                     echo "  ---- solicitando ".$q['idParent']." ---- ";
                     if(isset($this->arrayAnswerKey[$q['id']]['answer']))
                        $question->answer = $this->arrayAnswerKey[$q['id']]['answer'];
                 }
                 
                 $question->save();
            }
        }
                
        return 0;
    }
    
    private function sortQuestions($questions_){
        $master = $this->getMasterQuestions($questions_);
        $conditional = $this->getConditionalQuestions($questions_);
        
        return array_merge($master, $conditional);
    }
    
    private function getMasterQuestions($questions){
        $master = [];
        foreach ($questions as $key => $value){
            if(strcasecmp(0, $value['idParent']) === 0){
                $master[$value['id']] = $value;
            }
        }
        return $master;
    }
    
    private function getConditionalQuestions($questions){
        $conditional = [];
        foreach ($questions as $key => $value){
            if(strcasecmp(0, $value['idParent']) !== 0)
                $conditional[$value['id']] = $value;
        }
        return $conditional;
    }
    
    private function saveQuestionAnswers($questionArray, $question) {
        if (strcasecmp($questionArray['conditionalAnswer'], "si") === 0 or strcasecmp($questionArray['conditionalAnswer'], "no") === 0){
//            echo "<br> -----   SI/NO a entrada ".$questionArray['text']."     ".$questionArray['id']." -----   ";
                $this->arrayAnswerKey[$questionArray['id']]['answer'] =  $questionArray['conditionalAnswer'];                
        }
        
        if (!isset($questionArray['answers']))
            return true;

        foreach ($questionArray['answers'] as $ans) {
//            echo "<br>insertando answer ".$ans['text']." ---> ".$questionArray['text'];
            $ans['idQuestion'] = $question->id;
            $answer = mstQuestionAnswer::create($ans);
            
            if(isset($ans['id'])){
                $this->arrayAnswerKey[$questionArray['id']][$ans['id']] =  $answer->id;
//                echo "idAnswer: ".$this->arrayAnswerKey[$questionArray['id']][$ans['id']]."    ---  ";
            }

            $this->arrayAnswerKey[$question->id][$questionArray['id']] = $answer->id;
            $this->setValuesRestrictedOfCreate($answer);
        }
        
    }

    function setValuesRestrictedOfCreate($survey){
        $survey->created_by = $this->userLogged->id;
        return $survey->save();
    }
    
    private function getSurveyByName($name){
        return mstSurveys::where("name", $name)->first();
    }
    
    public function update(Request $request){
        
        if(!($validate = $this->validateRequest($request, "update")) == true)
            return $validate;
        
        if(($currentSurvey = $this->getSurveyById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey doesn't exists"]);
        
        if(strcasecmp($currentSurvey->name, $request->get("name")) != 0)
            if($this->checkIfNewNameExists($request->get("name")))
                return response()->json (["status" => false, "message" => "already exists this survey name"]);
        
        if($currentSurvey->update($request->all())){
            $this->setValuesRestrictedUpdate($currentSurvey);
            return response ()->json (["status" => true, "message" => "survey updated"]);
        }
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }
    
    public function delete(Request $request){
        if(!($validate = $this->validateRequest($request, "update")) == true)
            return $validate;
        
        if(($survey = $this->getSurveyById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey does not exists"]);
        
        $survey->status = ((int) $request->get("reactivate") == 1) ? 1 : 0;
        
        if($this->setValuesRestrictedUpdate($survey))
            return ((int) $request->get("reactivate") == 1) ? 
                        response ()->json (["status" => true, "message" => "survey reactivated"]) :
                        response ()->json (["status" => true, "message" => "survey deactivated"]);
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }
    
    public function status(Request $request){
         try {
            $this->validate($request, array("id" => "integer|required", "status" => "integer|required|max:1|min:0"));
        } catch (HttpResponseException $e) {
            return response()->json(['status' => false, 'message' => 'invalid_parameters',], IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        $newstatus = $request->input("status");
        
        if(!($survey = mstSurveys::find($request->input("id"))))
            return response ()->json (["status" => false, "message" => "survey not found"]);    
        
        $survey->status = $newstatus;
        $survey->save();
        
        return response ()->json (["status" => true, "message" => ((int)$newstatus == 0) ? "survey disabled" : "survey enabled"]);    
    }
    
    function setValuesRestrictedUpdate($survey){
        $survey->updated_by = $this->userLogged->id;
        return $survey->save();
    }
    
    function getSurveyById($id){
        return mstSurveys::find($id);
    }
    
    private function checkIfNewNameExists($newName){
        return ((mstSurveys::where("name", $newName)->first()) != NULL) ? true: false;
    }
}
