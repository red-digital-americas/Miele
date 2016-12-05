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
        
        if(!$this->checkIfExistsUser($dataRequest['email']) == NULL)
            return response ()->json ([
                    'status' => false, 
                    'message' => 'The user '.$dataRequest['email'].' is already registered'
                ]);
        
        if(($user = User::create($dataRequest)))
            return response ()->json ([
                    'status' => true, 
                    'message' => 'The user '.$dataRequest['email'].' has been registered'
                ]);
        else
            return response ()->json ([
                    'status' => false, 
                    'message' => 'it was not possible to register the user. Internal server error'
                ],
                IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR);   //Internal server error
    }
    
    private function checkIfExistsUser($email){
        return User::where('email', $email)->first();
    }
        
    private function buildNewUserArrayData($request){
        $userData                       = $this->getAuthenticatedUserData();
        $dataRequest                    = $request->all();
        $dataRequest['created_by']      = $userData->idUser;
        $dataRequest['password']        = app('hash')->make($dataRequest['password']);
        $dataRequest['remember_token']  = str_random(10);
        
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
                'idUser' => 'required|integer',
            ]);
            
        } catch (HttpResponseException $e) {
            return response()->json([
                    'status' => false,
                    'message' => 'invalid_parameters',
                ], 
                IlluminateResponse::HTTP_BAD_REQUEST);
        }
        
        return $this->deleteUser($request);
    }
    
    private function deleteUser(Request $request){
        $idUser             = $request->get('idUser');
        $userAuthenticated  = $this->getAuthenticatedUserData();
        
        if(($isSystemUser   = $this->ifIsUserOfSystem($idUser)))
            return $isSystemUser;
        
        $user = User::find($idUser);
        
        if($user == NULL)
            return response ()->json ([
                    'status' => false,
                    'message' => 'this user doesn\'t exist'
                ]);
        
        if((int) $user->status == 0)
            return response ()->json ([
                    'status' => true,
                    'message' => 'this user is desactivated'
                ]);
        
        $user->status = 0;
        $user->updated_by = $userAuthenticated->idUser;
        $user->save();
        $user->touch();  // update timestamps (updated_at)
        
        return response ()->json ([
                    'status' => true,
                    'message' => 'user desactivated'
                ]);
    }
    
    private function ifIsUserOfSystem($idUser){
        if((int)$idUser == 1)
            return response()->json ([
                    'status' => false,
                    'message' => "you can't delete this user"
                ]);
        else 
            return false;
    }
    
}
