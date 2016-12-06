<?php
/**
 * @author Daniel Luna    dluna@aper.net
 */

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;
use App\User;

class UserController extends Controller {
    /**
     * This method return the list of users registered in the system.
     * @return type
     */
    public function index() {
        $users = User::all()->where("status", "==", 1);
        return response()->json($users);
    }

    /**
     * This method creates a new user.
     * @param Request $request
     * @return type
     */
    public function create(Request $request) {
        try {
            $this->validate($request, [
                'name'              => 'required|max:45',
                'last_name'         => 'required|max:45',
                'mothers_last_name' => 'max:45',
                'email'             => 'required|email|max:255',
                'password'          => 'required|min:5',
                'email'             => 'required'
            ]);
        } catch (HttpResponseException $e) {
            return response()->json([
                    'status' => false,  
                    'message' => 'invalid_parameters',
                ], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        return $this->registerUser($request);
    }
    
    private function registerUser(Request $request){
        $dataRequest = $this->buildNewUserArrayData($request);
        
        if(($isUserEnable = $this->isUserReadyToRegister($dataRequest)))
                return $isUserEnable;
        
        if(($newUser = User::create($dataRequest))){
            $this->setRememberToken($newUser);
            return response ()->json ([
                    'status' => true, 
                    'message' => 'The user '.$dataRequest['email'].' has been registered'
                ]);
        }
        else
            return response ()->json ([
                    'status' => false, 
                    'message' => 'it was not possible to register the user. Internal server error'
                ],
                IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);   //Internal server error
    }
    
    private function setRememberToken($user){
        $user->remember_token = str_random(10);
        $user->save();
    }
    
    /**
     * 
     * @param type $dataRequest
     * @return boolean true: if the user exists | false if the user doen's exists
     */
    private function isUserReadyToRegister($dataRequest){
        if(($oldUser = $this->getUser('email',$dataRequest['email'])) != NULL){
            if((int) $oldUser->status == 1)
                return response ()->json ([
                        'status' => false, 
                        'message' => 'The user '.$dataRequest['email'].' is already registered'
                    ]);
            else
                return response ()->json ([
                        'status' => false, 
                        'message' => 'The user '.$dataRequest['email'].' is already registered but disabled'
                    ]);
        }
        
        return false;
    }
    
    public function getUser($column, $value){
        return User::where($column, $value)->first();
    }
            
    private function buildNewUserArrayData($request){
        $userData                       = $this->getAuthenticatedUserData();
        $dataRequest                    = $request->all();
        $dataRequest['created_by']      = $userData->idUser;
        $dataRequest['password']        = app('hash')->make($dataRequest['password']);
        
        return $dataRequest;
    }
    
    private function getAuthenticatedUserData(){
        return $this->getAuthenticatedUser()->getData();
    }
    
    private function getAuthenticatedUser(){
        return AuthController::getAuthenticatedUser();
    }
    
    /**
     * This method delete a user.
     * @return type
     */    
    public function delete(Request $request){
        try {
            $this->validate($request, [
                'idUser'        => 'required|integer',
                'reactivate'    => 'integer'
            ]);
            
        } catch (HttpResponseException $e) {
            return response()->json([
                    'status' => false,
                    'message' => 'invalid_parameters',
                ], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        if(($userToDelete = $this->getUser("id", $request->get("idUser"))) == NULL)
            return response ()->json ([
                    'status' => false,
                    'message' => 'this user doesn\'t exist'
                ]);        
            
        if((int) $request->get('reactivate') == 1)
            return $this->reactivateUser ($userToDelete);
        else
            return $this->deleteUser($request, $userToDelete);
    }
    
    private function reactivateUser($userToReactivate){
        $userAuthenticated  = $this->getAuthenticatedUserData();
        if(($isSystemUser   = $this->ifIsUserOfSystem($userToReactivate->id)))
            return $isSystemUser;
        
        if((int) $userToReactivate->status == 1)
            return response ()->json ([
                    'status' => true,
                    'message' => 'this user is activated'
                ]);
        
        $userToReactivate->status = 1;
        $userToReactivate->updated_by = $userAuthenticated->idUser;
        $userToReactivate->save();
        
        return response ()->json ([
                    'status' => true,
                    'message' => 'user reactivated'
                ]);
    }
    
    private function deleteUser(Request $request, $userToDelete){
        $idUser             = $request->get('idUser');
        $userAuthenticated  = $this->getAuthenticatedUserData();
        
        if((int) $idUser == (int) $userAuthenticated->idUser)
            return response ()->json ([
                "status"    => false,
                "message"   => "you cannot delete yourself"
            ]);
        
        if(($isSystemUser   = $this->ifIsUserOfSystem($idUser)))
            return $isSystemUser;
               
        if((int) $userToDelete->status == 0)
            return response ()->json ([
                    'status' => true,
                    'message' => 'this user is desactivated'
                ]);
        
        $userToDelete->status = 0;
        $userToDelete->updated_by = $userAuthenticated->idUser;
        $userToDelete->save();
        $userToDelete->touch();  // update timestamps (updated_at)
        
        return response ()->json ([
                    'status' => true,
                    'message' => 'user desactivated'
                ]);
    }
    
    /**
     * Check if the user selected is a system user
     * @param type $idUser
     * @return boolean
     */
    private function ifIsUserOfSystem($idUser){
        if((int)$idUser == 1)
            return response()->json ([
                    'status' => false,
                    'message' => "you can't modify this user"
                ]);
        else 
            return false;
    }
    
    /**
     * Update the information of the user
     */
    public function update(Request $request){
        try {
            $this->validate($request, [
                'idUser'            => 'required|integer',
                'password'          => 'string|max:45|min:5',
                'name'              => 'string|max:45|min:3',
                'last_name'         => 'string|max:45|min:3',
                'mothers_last_name' => 'string|max:45|min:3'                
            ]);
            
        } catch (HttpResponseException $e) {
            return response()->json([
                    'status'    => false,
                    'message'   => 'invalid_parameters',
                ], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        return $this->updateUser($request);
    }
    
    /**
     * Method that update the information of user
     * @param Request $request
     * @return type
     */
    private function updateUser(Request $request){
        $idUserToUpdate = $request->get('idUser');
        $data = $request->all();
        if(($user = User::find($idUserToUpdate)) == NULL)
            return response ()->json ([
                "status"    => false,
                "message"   => "user doesn't exists"
            ]);
        
        unset($data['email']);
        
        if($user->update($data))
                return response()->json([
                    "status" => true,
                    'message' => 'user updated'
                ]);
        else
            return response()->json([
                    "status" => false,
                    'message' => 'it was not possible to update the user information'
                ]);
    }
    
}
