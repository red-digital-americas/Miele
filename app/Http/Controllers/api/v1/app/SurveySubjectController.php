<?php
/**
 * Description of SurveySubjectController
 *
 * @author danielunag
 */

namespace App\Http\Controllers\api\v1\app;

use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use App\mstSurveySubject;
use App\Http\Controllers\api\v1\Api;

class SurveySubjectController extends Api{
    public function __construct() {
        $this->setArrayCreate([
            'name'              => 'string|required|max:45|min:3',
            "last_name"         => 'string|required|max:45|min:3',
            "mothers_last_name" => 'string|max:45|min:2',
            "birthday"          => 'required|date_format:"d/m/Y"',
            "address"           => 'string|required|max:255|min:3',
            "telephone"         => 'string|required',
            "email"             => 'string|max:45|min:3|required'
        ]);
        
        $this->setArrayUpdate([
            'name'              => 'string|max:45|min:3',
            "last_name"         => 'string|max:45|min:3',
            "mothers_last_name" => 'string|max:45|min:2',
            "birthday"          => 'required|date_format:"d/m/Y"',
            "address"           => 'string|max:255|min:3',
            "telephone"         => 'string',
            "email"             => 'string|max:45|min:3|required'
        ]);
        
        $this->setArrayDelete([
            'id'          => 'integer|required'
        ]);
        parent::__construct();
    }
    
    
    public function index(){
        $catSurveys = mstSurveySubject::all();
        return response()->json($catSurveys);
    }
    
    public function create(Request $request){
        if(!($validate = $this->validateRequest($request, "create")) == true)
            return $validate;
        
        if(($newSurveySubject = mstSurveySubject::create($request->all()))){
            $this->setValuesRestrictedOfCreate($newSurveySubject);
            return $newSurveySubject;
        }
        else
            return response ()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION, 
            IlluminateResponse::HTTP_BAD_REQUEST]);
    }
    
    public function update(Request $request){
        if(!($validate = $this->validateRequest($request, "update")) == true)
            return $validate;
        
        if(($currentSurvey = $this->getSurveySubjectById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey type doesn't exists"]);
        
        if($currentSurvey->update($request->all())){
            $this->setValuesRestrictedUpdate($currentSurvey);
            return response ()->json (["status" => true, "message" => "survey subject updated"]);
        }
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }
    
    public function delete(Request $request){
        if(!($validate = $this->validateRequest($request, "delete")) == true)
            return $validate;
        
        if(($survey = $this->getSurveySubjectById($request->get("id"))) == NULL)
                return response()->json (["status" => false, "message" => "the survey type doesn't exists"]);
                
        if($survey->delete())
            return response ()->json (["status" => true, "message" => "survey subject deleted"]);
        else
            return response()->json (["status" => false, "message" => SystemMessages::SYSTEM_ERROR_ACTION]);
    }
    
    private function getSurveySubjectById($id){
        return mstSurveySubject::find($id);
    }
}
