<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function test(){
        $user = User::find(1);

        return $user->mother;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:users,nik',
            'name' => 'required', //name ga harus unique
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('Personal Access Token');
        $tokenResult = $token->token;
        $tokenResult->expires_at = Carbon::now()->addWeeks(1);
        $tokenResult->save();

        return response()->json([
            'success' => true,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->expires_at)->toDateTimeString(),
            'message' => "User Registered Successfully",
            "user" => $user
        ]);

        // return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Personal Access Token');
        $tokenResult = $token->token;
        $tokenResult->expires_at = Carbon::now()->addWeeks(1);
        $tokenResult->save();

        return response()->json([
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->expires_at)->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {

        $user = $request->user()->load(['mother', 'role', 'staff']);

        return response()->json(
            $user
        );
    }
}
