<?php
namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveys;
use App\catAnswerType;
use App\mstQuestionAnswer;
use App\mstQuestion;
use App\Exceptions\SystemMessages;
use App\Http\Controllers\api\v1\Api;

/**
 * Description of SurveyController
 *
 * @author danielunag
 */
class SurveyController extends Api{
    
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
            "anon"                          => "integer",
            "questions"                     => "array|min:1|required",
            "questions.*.text"              => "string|required",
            "questions.*.idQuestionType"    => "integer|required",
            "answers"                       => "array",
            "answers.*.text"                => "string|required",
            "answers.*.idQuestion"          => "integer|required",
        ]);
        
        $this->setArrayDelete([
            'name'                          => 'string|required|max:100|min:3',
            "welcome_text"                  => "string|max:255",
            "finish_text"                   => "string|max:255",
            "anon"                          => "integer",
        ]);
        parent::__construct();
    }
        
    public function index(Request $request){
//        $surveys = null;
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
    
    private function saveQuestion($newSurvey, $questions){
        foreach ($questions as $q){
            $q['idSurvey'] = $newSurvey->id;
            $question = mstQuestion::create($q);
            $this->setValuesRestrictedOfCreate($question);
            $this->saveQuestionAnswers($q, $question);
        }
    }
    
    private function saveQuestionAnswers($questionArray,$question){
        if(isset($questionArray['answers'])){
            foreach ($questionArray['answers'] as $ans){
                $ans['idQuestion'] = $question->id;
                $answer = mstQuestionAnswer::create($ans);
                $this->setValuesRestrictedOfCreate($answer);
            }
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
                return response()->json (["status" => false, "message" => "the survey doesn't exists"]);
        
        $survey->status = ((int) $request->get("reactivate") == 1) ? 1 : 0;
        
        if($this->setValuesRestrictedUpdate($survey))
            return ((int) $request->get("reactivate") == 1) ? 
                        response ()->json (["status" => true, "message" => "survey reactivated"]) :
                        response ()->json (["status" => true, "message" => "survey deactivated"]);
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
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
