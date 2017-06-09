<?php

/**
 * @author Daniel Luna    dluna@aper.net
 */

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\api\v1\Api;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserRequest;

class UserController extends Api {

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
    public function create(UserRequest $request) {
        try {
            if (!($validate = $this->validate($request, $request->rules())) == NULL)
                return $validate;

            $userData = $request->all();
            $password = app('hash')->make($request->get("password"));

            $userData["password"] = $password;

            User::create($userData);

            return response()->json(["status" => true, "message" => "Usuario creado con éxito"]);
        } catch (\Exception $ex) {
            return response()->json(['status' => false, 'message' => "Error al crear usuario. " . $ex->getMessage()]);
        }
    }

    /**
     * This method delete a user.
     * @return type
     */
    public function delete(UserRequest $request) {
        try {
            if (!($validate = $this->validate($request, $request->rules())) == NULL)
                return $validate;

            $id = $request->get('id');
            
            if (($user = User::find($id)) == NULL)
                return response()->json(["status" => false, "message" => "El usuario no existe."]);

            $user->delete();

            return response()->json(["status" => true, "message" => "Usuario eliminado con éxito"]);
        } catch (\Exception $ex) {
            return response()->json(["status" => false, "message" => "No fue posible eliminar el usuario. " . $ex->getMessage()]);
        }
    }

    /**
     * Update the information of the user
     */
    public function update(UserRequest $request) {
        try {
            if (!($validate = $this->validate($request, $request->rules())) == NULL)
                return $validate;
            
            $id = $request->get('id');
            
            if (($user = User::find($id)) == NULL)
                return response()->json(["status" => false, "message" => "El usuario no existe"]);
            
            $user->update($request->all());

            return response()->json(["status" => true, 'message' => 'Usuario actualizado con éxito']);
        } catch (\Exception $ex) {
            return response()->json(["status" => false, "message" => "No fue posible actualizar el usuario. " . $ex->getMessage()]);
        }
    }

}
