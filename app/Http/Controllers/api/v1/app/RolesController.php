<?php
/**
 *
 * @author Daniel Luna     dluna@aper.net
 */

namespace App\Http\Controllers\api\v1\app;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;
use App\mstRoles;


class RolesController extends Controller{
    private $userLogged;
    public function __construct() {
        $this->userLogged = AuthController::getAuthenticatedUser();
    }
    public function index(){
        $users = mstRoles::all()->where("status", 1);
        return response()->json($users);
    }
    
    public function create(Request $request){
        try {
            $this->validate($request, [
                'name' => 'string|required|max:45|min:3',
            ]);
        } catch (HttpResponseException $e) {
            return response()->json(['status' => false,  'message' => 'invalid_parameters',], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        return $this->createRole($request);
    }
    
    private function createRole(Request $request){
        $newRolName = $request->get('name');
        
        if($this->getRolByName($newRolName) != NULL)
            return response ()->json (["status" => false,"message" => "the role $newRolName is already exists"]);
        
        if(($newRol = mstRoles::create($request->all()))){
            $this->setValuesRestricted($newRol->id);
            return response ()->json (["status" => true,"message" => "role created"]);
        }
        else
            return response ()->json (["status" => false,"message" => "it was not possible to create the role"],
            IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
    
    private function setValuesRestricted($id){
        if(mstRoles::find($id)->update(['created_by' => $this->userLogged->id]))
            return true;
        else
            return false;
    }
    
    /**
     * method that deactivate a Role
     * @param Request $request
     */
    public function delete(Request $request){
        try {
            $this->validate($request, [
                'id' => 'integer|required',
            ]);
        } catch (HttpResponseException $e) {
            return response()->json(['status' => false,  'message' => 'invalid_parameters',], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        if($this->isSystemElement($request->get('id')))
            return $this->getSystemAlertModify ();
        
        if(($role = $this->getRoleById($request->get('id'))) == NULL)
                return response ()->json (["status" => false, "message" => "the role doen's exists"]);
        
        return $this->deleteRole($role, $request->get('reactivate'));
    }
    
    private function deleteRole($role, $status_ = 0){      
        $status = $this->getNewStatusOfRole($status_);
    
        $role->status = $status;
        $role->updated_by = $this->userLogged->id;
        
        if($role->save())
            return response ()->json (["status" => true, "message" => $this->getMessageOfDeactivated($status)]);
        else
            return $this->getInternalServerErrorMessage ();
    }
    
    public function update(Request $request){
        try {
            $this->validate($request, [
                'id' => 'integer|required',
                'name' => 'string|required|max:45|min:3'
            ]);
        } catch (HttpResponseException $e) {
            return response()->json(['status' => false,  'message' => 'invalid_parameters',], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        if(($role = $this->getRoleById($request->get('id'))) == NULL)
                return response ()->json (["status" => false, "message" => "the role doen's exists"]);
        
        return $this->updateRole($request, $role);
    }
    
    private function updateRole(Request $request, $role){
        if($this->checkIfNewNameExists($request->get("name")))
                return response ()->json (["status" => false, "message" => "the new name of role is already registered"]);
        
        if(mstRoles::find($role->id)->update($request->all()))
            return response()->json (["status" => true, "message" => "the role has been updated"]);
        else
            return $this->getInternalServerErrorMessage ();
    }
    
    private function getInternalServerErrorMessage(){
        return response ()->json (["status" => false, "message" => "it was not possible to do this action",],
            IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
    
    /**
     * check if the new name of role exists
     * @param type $id
     * @param type $newName
     */
    private function checkIfNewNameExists($newName){
        return ((mstRoles::where("name", $newName)->first()) != NULL) ? true: false;
    }
    
    private function getNewStatusOfRole($status){
        return ($status == 1) ? 1 : 0;
    }
    
    private function getMessageOfDeactivated($status){
        return ($status == 1) ? "role reactivated" : "role deactivated";
    }
    
    private function getSystemAlertModify(){
        return response ()->json (["status" => false,"message" => "you can't modify this role"]);
    }
    
    private function isSystemElement($id){
        return ((int) $id == 1) ? true : false;
    }
    
    private function getRoleById($id){
        return mstRoles::find($id);
    }
            
    private function getRolByName($name){
        return mstRoles::where('name',$name)->first();
    }
}
