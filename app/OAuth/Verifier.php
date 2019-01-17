<?php
/**
 * Created by PhpStorm.
 * User: contr
 * Date: 17/01/2019
 * Time: 15:26
 */

namespace CodeProject\OAuth;


use Illuminate\Support\Facades\Auth;

class Verifier
{

    public function verify($username, $password)
    {
        $credentials = [
            'email' => $username,
            'password' => $password
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }

}