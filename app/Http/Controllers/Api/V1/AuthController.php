<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Mail\UserUpdateMail;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
/**
 * Create a new user.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::defaults()],
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), "message" => 'Validation Error']);
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'title' => $request->title,
        ]);

/*         $accessToken = $user->createToken('authToken')->accessToken;
 */
        return response([
            'message' => 'Successfully registered',
            'user' => $user,
        ], 201);
    }

    /**
     * Log the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response([
            'message' => 'Successfully logged',
            'user' => auth()->user(),
            'access_token' => $accessToken,
        ], 200);
    }

    /**
     * Update password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request, User $user)
    {
        if (auth()->user()->id !== $user->id) {
            return response()->json(['error' => "Acces denied"], 403);
        }
        $validator = Validator::make($request->all(), [
            'oldPassword' => ['required'],
            'newPassword' => ['required', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), "message" => 'Validation Error']);
        }
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->update(['password' => Hash::make($request->newPassword)]);
            Mail::to($user->email)->send(new UserUpdateMail($user));

            return response([
                'message' => 'Password Successfully Updated',
                'user' => $user,
            ], 200);
        } else {
            return response([
                'error' => 'Bad old password',
            ], 200);
        }

        if ($user->password) {
            return 'ok';
        }

        return response([
            'message' => 'Successfully registered',
            'user' => $user,
            'access_token' => $accessToken,

        ], 200);
    }

    /**
     * Reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request, User $user)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        $user = User::where('email', $request->email)->get();
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), "message" => 'Validation Error']);
        }
        if (count($user) != 0) {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
           $newPass =  implode($pass); //turn the array into a string

            $user[0]->update(['password' => Hash::make($newPass)]);
            Mail::to($user[0]->email)->send(new PasswordResetMail($user[0], $newPass));

            return response([
                'message' => 'Password Successfully Reset',
            ], 200);
        } else {
            return response(['message' => 'This User does not exist, check your details'], 400);
        }

        if ($user->password) {
            return 'ok';
        }

        return response([
            'message' => 'Successfully registered',
            'user' => $user,
            'access_token' => $accessToken,

        ], 200);
    }

    /**
     * Logout the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth()->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
        ], 200);
    }
}
