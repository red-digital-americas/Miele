<?php
/**
 * Description of SurveyAppliedController
 *
 * @author danielunag
 */
namespace App\Http\Controllers\api\v1\app;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveyApplied;
use App\Http\Controllers\api\v1\Api;

class SurveyAppliedController extends Api{
    public function __construct() {
        $this->setArrayCreate([
            'idSurvey'        => 'integer|required|',
            'completed'       => 'integer|required|',
        ]);
        
        $this->setArrayUpdate([
            'idSurveySubject' => 'integer|required|',
            'idSurvey'        => 'integer|required|',
            'completed'       => 'integer|required|',
        ]);
        
        $this->setArrayDelete([
            'id'            => 'integer|required'
        ]);
        parent::__construct();
    }
    
    public function index(){
        $surveyAplied = mstSurveyApplied::all();
        return response()->json($surveyAplied);
    }
    
    public function create(Request $request){
        if(!($validate = $this->validateRequest($request, "create")) == true)
            return $validate;
        
        if(($newSurvey = mstSurveyApplied::create($request->all()))){
            $this->setValuesRestrictedOfCreate($newSurvey);
            return response ()->json (["status" => true, "message" => "survey appplied created"]);
        }
        else
            return response ()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION, 
            IlluminateResponse::HTTP_BAD_REQUEST]);
    }
    
    public function update(Request $request){
        if(!($validate = $this->validateRequest($request, "update")) == true)
            return $validate;
        
        if(($currentSurvey = $this->getSurveyById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey applied doesn't exists"]);
        
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
        
        if(($survey = $this->getSurveyAppliedById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "this element doesn't exists"]);
                
        if($survey->delete())
            return response ()->json (["status" => true, "message" => "deleted"]);
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }
    
    private function getSurveyAppliedById($id){
        return catSurveyType::find($id);
    }
    
}
