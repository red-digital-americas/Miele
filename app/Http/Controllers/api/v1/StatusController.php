<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\api\v1;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
/**
 * Description of StatusController
 *
 * @author danielunag
 */
class StatusController extends Controller{
    public function status(Request $request){
        return response()->json(["status" => 1, "message" => "system ok"], 200);
    }
}
