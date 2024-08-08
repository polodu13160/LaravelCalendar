<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LdapRecord\Models\ActiveDirectory\User;
use Illuminate\Routing\Controller;

class LdapController extends Controller
{
    public function search($uid)
    {


        $user = User::where('uid', '=', $uid)->first();
        

        if ($user) {
           return dd([
                'status' => 'success',
                'data' => $user->getAttributes(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }
    }
}
