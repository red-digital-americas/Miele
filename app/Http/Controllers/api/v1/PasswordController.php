<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\api\v1\Api;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\User;
class PasswordController extends Api {

    public function forgotPassword(PasswordRequest $request) {
        try {   
            if (!($validate = $this->validate($request, $request->rules())) == NULL)
                return $validate;
                        
            $email = $request->get("email");
            
            if (($user = User::where("email", $email)->first()) == NULL)
                return response()->json(["status" => true]);
            
            $newPassword = $this->getNewPassword();

            $user->password = app('hash')->make($newPassword);
            $user->save();
                        
            Mail::send("email.forgotPassword", ["username" => $user->name, "user" => $user->toJson(), "password" => $newPassword], function($m) use ($user){
                $m->from('system@miele.com.mx', 'Recuperación de contraseña');
                $m->to($user->email, $user->name)->subject('Equipo Miele');
            });

            return response()->json(["status" => true, "message" => ""]);
        } catch (Exception $ex) {
            return response()->json(["status" => false,"message" => "Error al reestablecer contraseña. ".$ex->getMessage()]);
        }
    }

    private function getNewPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
