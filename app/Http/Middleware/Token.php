<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

/**
 * Description of Token
 *
 * @author danielunag
 */
class Token {

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->input('token') == NULL) {
            return redirect('index');
        }

        try {
            if (!$user = JWTAuth::parseToken()->authenticate())
                return view('login', ['exceptions' => 'user_not_found']);
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return view('login', ['exceptions' => 'token_expired']);
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return view('login', ['exceptions' => 'token_invalid']);
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return view('login', ['exceptions' => 'token_absent']);
        } catch (Tymon\JWTAuth\Exceptions\InvalidClaimException $e) {
            return \redirect('login', ['exceptions' => 'token_absent'], $e->getStatusCode());
        } catch (\Exception $e) {
            return view('login', ["exceptions" => "invalid token"]);
        }

        return $next($request);
    }

}
