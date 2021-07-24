<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class LoginController extends Controller
{

     /**
     * index
     *
     * @param  mixed $request
     * @return void
     */

    public function index(Request $request)
    {
        $request->validate([
            'email'         => 'required|email',
            'password'      => 'required'
        ]);

        $data = User::where('email', $request->email)->first();

        if (!$data || !Hash::check($request->password, $data->password)) {
            return response([
                'success'   => false,
                'message'   => ['Invalid Email/ Password']
            ], 200);
        }

        $token = $data->createToken('ApiToken')->plainTextToken;

        $response = [
            'success'   => true,
            'user'      => $data,
            'token'     => $token
        ];

        return response($response, 200);
    }

    /**
     * logout
     *
     * @return void
     */

    public function logout()
    {   
        auth()->logout();

        return response()->json([
            'success'    => true
        ], 200);
    }
}
