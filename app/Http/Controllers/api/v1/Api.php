<?php

/**
 * Description of Apiv1
 *
 * @author danielunag
 */

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Http\Exception\HttpResponseException;

class Api extends Controller {

    protected $userLogged;
    protected $arrayCreate = array();
    protected $arrayUpdate = array();
    protected $arrayIndex = array();
    protected $arraDelete = array();

    public function __construct() {
        $this->userLogged = AuthController::getAuthenticatedUser();
    }

    function getArrayType($action) {
        switch ($action) {
            case "index": return $this->arrayIndex;
            case "create": return $this->arrayCreate;
            case "update": return $this->arrayUpdate;
            case "delete": return $this->arrayUpdate;
            default: return [];
        }
    }

    function setUserLogged($userLogged) {
        $this->userLogged = $userLogged;
    }

    function setArrayCreate($arrayCreate) {
        $this->arrayCreate = $arrayCreate;
    }

    function setArrayUpdate($arrayUpdate) {
        $this->arrayUpdate = $arrayUpdate;
    }

    function setArrayIndex($arrayIndex) {
        $this->arrayIndex = $arrayIndex;
    }
    
    function setArraDelete($arraDelete) {
        $this->arraDelete = $arraDelete;
    }

    
    function validateRequest(Request $request, $action) {
        try {
            $this->validate($request, $this->getArrayType($action));
        } catch (HttpResponseException $e) {
            return response()->json(['status' => false, 'message' => 'invalid_parameters',], IlluminateResponse::HTTP_BAD_REQUEST);
        }

        return true;
    }
    
    function setValuesRestrictedUpdate($object){
        $object->updated_by = $this->userLogged->id;
        return $object->save();
    }
    
    function setValuesRestrictedOfCreate($object){
        $object->created_by = $this->userLogged->id;
        return $object->save();
    }

}
