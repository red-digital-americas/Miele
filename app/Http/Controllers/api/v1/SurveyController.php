<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;
use App\mstSurveys;
use App\Exceptions\SystemMessages;
/**
 * Description of SurveyController
 *
 * @author danielunag
 */
class SurveyController extends Controller{
    private $userLogged;
    public function __construct() {
        $this->userLogged = AuthController::getAuthenticatedUser();
    }
    
    public function index(){
        $surveys = mstSurveys::all()->where("status", 1);
        return response()->json($surveys);
    }
    
    public function create(Request $request){
        if(!($validate = $this->validateRequest($request)) == true)
            return $validate;
        
        return $this->createSurvey($request);
    }
    
    private function createSurvey(Request $request){
        if($this->getSurveyByName($request->get("name")) != NULL)
            return response()->json (["status" => false, "message" => "already exists this survey name"]);
        
        if(($newSurvey = mstSurveys::create($request->all()))){
            $this->setValuesRestrictedOfCreate($newSurvey);
            return response ()->json (["status" => true, "message" => "survey created"]);
        }
        else
            return response ()->json (["status" => false, "message" => SystemMessages::$SYSTEM_ERROR_ACTION, 
            IlluminateResponse::HTTP_BAD_REQUEST]);
    }
    
    private function setValuesRestrictedOfCreate($survey){
        $survey->created_by = $this->userLogged->id;
        return $survey->save();
    }
    
    private function getSurveyByName($name){
        return mstSurveys::where("name", $name)->first();
    }
    
    public function update(Request $request){
        if(!($validate = $this->validateRequest($request, true)) == true)
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
            return response()->json (["status" => false, "message" => SystemMessages::$SYSTEM_ERROR_ACTION]);
    }
    
    public function delete(Request $request){
        if(!($validate = $this->validateRequest($request, true)) == true)
            return $validate;
        
        if(($survey = $this->getSurveyById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey doesn't exists"]);
        
        $survey->status = ((int) $request->get("reactivate") == 1) ? 1 : 0;
        
        if($this->setValuesRestrictedUpdate($survey))
            return ((int) $request->get("reactivate") == 1) ? 
                        response ()->json (["status" => true, "message" => "survey reactivated"]) :
                        response ()->json (["status" => true, "message" => "survey deactivated"]);
        else
            return response()->json (["status" => false, "message" => SystemMessages::$SYSTEM_ERROR_ACTION]);
    }
    
    private function setValuesRestrictedUpdate($survey){
        $survey->updated_by = $this->userLogged->id;
        return $survey->save();
    }
    
    private function getSurveyById($id){
        return mstSurveys::find($id);
    }
    
    private function checkIfNewNameExists($newName){
        return ((mstSurveys::where("name", $newName)->first()) != NULL) ? true: false;
    }
    
    private function validateRequest(Request $request, $update = false){
        $params = [
                    'name'          => 'string|required|max:100|min:3',
                    "welcome_text"  => "string|max:255",
                    "finish_text"   => "string|max:255",
                    "anon"          => "integer",
                ];
        
        if($update){
            $params['id']   = 'integer|required';
            $params['name'] = 'string|max:100|min:3';
            $params['reactivate'] = 'integer';
        }
        
        try {
            $this->validate($request, $params);
        } catch (HttpResponseException $e) {
            return response()->json(['status' => false,  'message' => 'invalid_parameters',], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        return true;
    }
}
