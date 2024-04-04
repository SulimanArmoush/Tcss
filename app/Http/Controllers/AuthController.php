<?php
namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function login(Request $request) {

        $validator = validator::make($request->all(), [
            'name' => ['required', 'string', 'max:15' , 'min:3'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 422);
        }
 
        if (! Auth::attempt($request->only('name', 'password'))) {
            return response()->json(['message' => 'this Account does not exist'], 401);
        }

        $user = $request->user();
        //add token to user
        $tokenResult = $user->createToken('personal Access Token'); //->accessToken;


        $user = User::where('id', '=', auth()->id())->first();
        $role = Role::where('id', '=', $user->role_id)->first();

        $data['user'] = $user;
        $data['token_type'] = 'Bearer';
        $data['access_token'] = $tokenResult->accessToken;
        $data['role'] = $role;

        return response()->json(['data' => $data, 'status' => 200, 'message' => 'logedd In successfully']);
    }


    public function logout(Request $request) {

        $request->user()->token()->revoke();

        return response()->json(['message' => 'logged out ', 'status' => 200]);
    }
}
