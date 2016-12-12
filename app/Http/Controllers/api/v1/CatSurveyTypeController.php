<?php
/**
 * Description of CatSurveyType
 *
 * @author danielunag
 */
namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\catSurveyType;
use App\Http\Controllers\api\v1\Api;

class CatSurveyTypeController extends Api{
    public function __construct() {
        $this->setArrayCreate([
            'name'          => 'string|required|max:100|min:3'
        ]);
        
        $this->setArrayUpdate([
            'id'            => 'integer|required',
            'name'          => 'string|max:100|min:3'
        ]);
        
        $this->setArraDelete([
            'name'          => 'string|required|max:100|min:3'
        ]);
        parent::__construct();
    }
    
    public function index(){
        $catSurveys = catSurveyType::all()->where("status", 1);
        return response()->json($catSurveys);
    }
    
    public function create(Request $request){
        if(!($validate = $this->validateRequest($request, "create")) == true)
            return $validate;
        
        if($this->getCatSurveyByName($request->get("name")) != NULL)
            return response()->json (["status" => false, "message" => "already exists this survey name"]);
        
        if(($newSurvey = catSurveyType::create($request->all()))){
            $this->setValuesRestrictedOfCreate($newSurvey);
            return response ()->json (["status" => true, "message" => "survey created"]);
        }
        else
            return response ()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION, 
            IlluminateResponse::HTTP_BAD_REQUEST]);
    }
    
    public function update(Request $request){
        if(!($validate = $this->validateRequest($request, "update")) == true)
            return $validate;
        
        if(($currentSurvey = $this->getSurveyById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey type doesn't exists"]);
        
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
                return response()->json (["status" => false, "message" => "the survey type doesn't exists"]);
        
        $survey->status = ((int) $request->get("reactivate") == 1) ? 1 : 0;
        
        if($this->setValuesRestrictedUpdate($survey))
            return ((int) $request->get("reactivate") == 1) ? 
                        response ()->json (["status" => true, "message" => "survey type reactivated"]) :
                        response ()->json (["status" => true, "message" => "survey type deactivated"]);
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }  
         
    private function getSurveyById($id){
        return catSurveyType::find($id);
    }
        
    private function setValuesRestrictedOfCreate($survey){
        $survey->created_by = $this->userLogged->id;
        return $survey->save();
    }
     
    private function setValuesRestrictedUpdate($survey){
        $survey->updated_by = $this->userLogged->id;
        return $survey->save();
    }
    
    private function getCatSurveyByName($name){
        return catSurveyType::where("name", $name)->first();
    }
    
    private function checkIfNewNameExists($newName){
        return ((catSurveyType::where("name", $newName)->first()) != NULL) ? true: false;
    }
}
