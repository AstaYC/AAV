<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
   /**
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = 'user';
        $user->save();

        if($user){
            
            return redirect('/login')->with('status', 'lajoutage est bien faite');
        }else{
            return redirect('/register')->with('status', 'Une probleme dans la registration');
        }
    }



   public function login()
   {
      $validator = Validator::make(request()->all(), [
          'email' => 'required|string|email|max:255',
          'password' => 'required|string|min:8|max:255'
      ]);

      if ($validator->fails()) {
          return response()->json(['errors' => $validator->errors()], 422);
      }
       
      $check = request(['email', 'password']);
    if (! $token = auth()->attempt($check)) {
          return response()->json(['error' => 'Unauthorized'], 401);
      }
      return $this->respondWithToken($token);
}

public function updateUser(string $id, Request $request)
{
    $validated = $request->validate([
        'name' => ['string', 'min:3', 'unique:users'],
        'email' => ['string', 'email', 'lowercase', 'unique:users'],
        'password' => ['string'],
        'role' => ['string'],
    ]);
    $user = User::find($id);

    if ($user) {
        $user->update($validated);
        return response()->json(["success" => "User updated successfuly", "data" => $user], 202);
    }

    return response()->json(["error" => "User not found"], 404);
}

public function deleteUser(string $id){
      $user = User::find($id);
      if($user){
        $user->delete();
        return response()->json(["success" => "Avec success"]);
      }else{
        return response()->json(["erreur" => "avec echoue"]);
      }
}




    /**
     * Log the user out (Invalidate the token).
     *

     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => JWTFactory::getTTL() * 60
    ]);
}
}