<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller{

    public function createUser(Request $request){

        $validator = validator::make($request->all(), [
            'name' => ['required','unique:users,name', 'string', 'max:15', 'min:3'],
            'password' => ['required', 'string', 'min:4'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }

        User::create([
            'name' => $request->name,
            'password' => $request->password,
            'role_id' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'User created successfully'], 200);
    }

    public function showUsers(){

        $users = User::Get();

        return response()->json($users, 200);
    }

    public function getUser($Id){

        $user = User::Where('id',$Id)->get();

        if ($user->isEmpty())
        {
           return response()->json(['message' => 'no User added'], 404);
        }

        return response()->json($user, 200);
    }

    public function editUser(Request $request, $id) {

        $validator = validator::make($request->all(), [
            'name' => ['sometimes','string', 'max:15', 'min:3'],
            'password' => ['sometimes','string', 'min:4'],
            'updated_at' => now(),

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), status: 400);
        }
        
        $user = User::find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->all());

        return response()->json(['message' => 'User Updated successfully'], 200);
    }

    public function deleteUser($id) {

        $user = User::find($id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User Deleted successfully'], 200);

    }
}
