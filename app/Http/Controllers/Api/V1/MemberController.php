<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MemberResource;
use App\Mail\TeamMemberAddMail;
use App\Mail\TeamMemberDeletedMail;
use App\Mail\TeamMemberUpdateMail;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->title == 'DG') {
            $members = Member::all();
            return response([
                'members' => MemberResource::collection($members),
                'message' => 'Retrieved successfully',
            ], 200);
        }

        $members = Member::all()->where('user_id', auth()->user()->id);

        return response(
            [
                'members' => MemberResource::collection($members),
                'message' => 'Retrieved successfully',
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
        if (auth()->user()->title == 'DG') {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'integer'],
                'role' => ['required', 'string', 'max:255'],
                'team_id' => ['required', 'integer'],
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors(),
                    'message' => 'Validation Error',
                ]);
            }

            $member = Member::create([
                'user_id' => $request['user_id'],
                'role' => $request['role'],
                'team_id' => $request['team_id'],
            ]);
            Mail::to($member->user->email)->send(new TeamMemberAddMail($member));

            return response([
                'member' => new MemberResource($member),
                'message' => 'Successfully created',
            ], 200);
        }

        return response()->json(['error' => 'Access denied'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        if (auth()->user()->title == 'DG') {
            return response(
                [
                    'member' => new MemberResource($member),
                    'message' => 'Retrieved successfully',
                ],
                200
            );
        }
        return response()->json(['error' => 'Access denied'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTeamMember($id)
    {
/*         if (auth()->user()->title == 'DG') {
 */
        $members = Member::all()->where('team_id', $id);

        return response(
            [
                'members' => MemberResource::collection($members),
                'message' => 'Retrieved successfully',
            ],
            200
        );
        /* }
    return response()->json(['error' => 'Access denied'], 403); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        if (auth()->user()->title == 'DG') {
            $member->update(['role' => $request->role]);
            Mail::to($member->user->email)->send(new TeamMemberUpdateMail($member));
            return response(
                [
                    'updatedMember' => new MemberResource($member),
                    'message' => 'Updated successfully',
                ],
                200
            );
        }

        return response()->json(['error' => 'Access denied'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        Mail::to($member->user->email)->send(new TeamMemberDeletedMail($member));

        $member->delete();
        return response(['message' => 'Deleted Succesfully']);
    }
}
