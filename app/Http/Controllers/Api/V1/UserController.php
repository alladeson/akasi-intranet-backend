<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\UserAddMail;
use App\Mail\UserDeletedMail;
use App\Mail\UserRestoredMail;
use App\Mail\UserUpdateMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => "Acces denied"], 403);
        }

        $users = User::all();
        return response([
            'users' => UserResource::collection($users),
            'message' => 'Retrieved successfully',
        ], 200);
    }

    /**
     * Display a listing of deactivated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function desactivatedIndex()
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => "Acces denied"], 403);
        }

        $users = User::onlyTrashed()->get();

        return response(
            [
                'users' => UserResource::collection($users),
                'message' => 'Retrieved successfully',
            ],
            200
        );
    }

    /**
     * Restore deactivated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function restoreUser($id)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => "Acces denied"], 403);
        }

        User::onlyTrashed()->where('id', $id)->restore();
        $user = User::find($id);

        Mail::to($user->email)->send(new UserRestoredMail($user));

        return response(
            [
                'message' => 'User successfully restored',
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => "Acces denied"], 403);
        }
        $validator = Validator::make($request->all(), [

            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
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

        Mail::to($user->email)->send(new UserAddMail($user, $request->password));

        return response([
            'message' => 'Successfully registered',
            'user' => $user,
        ], 201);
    }

    /**
     * Get current active user information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCurrentUser(Request $request)
    {
        return response()->json([
            'user' => auth()->user(),
            'message' => 'Retrieved successfully',
        ], 200);

    }

    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (auth()->user()->title !== 'DG' && auth()->user()->id !== $user->id) {
            return response()->json(['error' => "Acces denied"], 403);
        }

        return response([
            'user' => new UserResource($user),
            'message' => 'Retrieved successfully',
        ], 200);

    }

    /**
     * Update the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (auth()->user()->id !== $user->id && auth()->user()->title !== 'DG') {
            return response()->json(['error' => "Acces denied"], 403);
        }

        if ($request->file('cv')) {
            $cv = Storage::disk('local')->put('carrieres', $request->cv);
            $user->update(['cv' => $cv]);
        }

        if ($request->file('profil')) {
            $profil = Storage::disk('local')->put('profils', $request->profil);
            $user->update(['profil' => $profil]);
        }

        if (auth()->user()->title == 'DG') {
            $user->update($request->except(['cv', 'profil']));
            Mail::to($user->email)->send(new UserUpdateMail($user));

            return response(
                [
                    'updatedUser' => new UserResource($user),
                    'message' => 'Updated successfully',
                ],
                200
            );
        }

        $user->update($request->except(['title', 'email', 'cv', 'profil']));

        Mail::to($user->email)->send(new UserUpdateMail($user));

        return response(
            [
                'updatedUser' => new UserResource($user),
                'message' => 'Updated successfully',
            ],
            200
        );
    }

    /**
     * Remove the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => "Acces denied"], 403);
        }

        Mail::to($user->email)->send(new UserDeletedMail($user));

        $user->delete();

        return response(['message' => 'Deleted Succesfully']);
    }
}
