<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display all roles of a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserRoles(User $user)
    {
        $roles = $user->roles;

        return response(
            [
                'roles' => RoleResource::collection($roles),
                'message' => 'Retrieved successfully',
            ],
            200
        );
    }



    /**
     * Add a role to a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function attachRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), "message" => 'Validation Error']);
        }
        //Find user
        $user = User::find($request->user_id);

        //Add a role to user
        $user->roles()->attach($request->role_id, ['status' => 1]);

        return response([
            'message' => 'Role Successfully attached',
        ], 201);
    }

    /**
     * Remove a role from a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function detachRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'role_id' => 'required|integer',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), "message" => 'Validation Error']);
        }

        // find user
        $user = User::find($request->user_id);


        //remove a role from a user
        $user->roles()->detach($request->role_id);

        return response([
            'message' => 'Role Successfully detached',
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}