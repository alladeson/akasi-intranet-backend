<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Mail\TeamDeletedMail;
use App\Mail\TeamUpdateMail;
use App\Models\Member;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the team.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->title !== 'DG') {
            $teams = [];
            $members = Member::all()->where('user_id', auth()->user()->id);
            if ($members) {
                foreach ($members as $member) {
                    $team = Team::find($member->team_id);
                    if ($team != null) {
                        array_push($teams, $team);
                    }
                }

            }

            return response(
                [
                    'teams' => TeamResource::collection($teams),
                    'message' => 'Retrieved successfully',
                ],
                200
            );
        }
        $teams = Team::all();
        return response([
            'teams' => TeamResource::collection($teams),
            'message' => 'Retrieved successfully',
        ], 200);
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
            return response()->json(['error' => 'Permission denied'], 403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'project_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $team = Team::create([
            'name' => $request['name'],
            'project_id' => $request['project_id'],
        ]);

        return response([
            'message' => 'Successfully registered',
            'team' => $team,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        return response([
            'team' => new TeamResource($team),
            'message' => 'Retrieved successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showTeams($id)
    {

        $teams = Team::all()->where('project_id', $id);

        return response(
            [
                'teams' => TeamResource::collection($teams),
                'message' => 'Retrieved successfully',
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        $oldName = $team->name;
        $team->update([
            'name' => $request->name,
            'project_id' => $request->project_id,
        ]);

        $members = Member::all()->where('team_id', $team->id);

        if (count($members) != 0) {
            foreach ($members as $member) {
                Mail::to($member->user->email)->send(new TeamUpdateMail($member, $oldName));
            }
        }

        return response(
            [
                'updatedTeam' => new TeamResource($team),
                'message' => 'Updated successfully',
            ],
            200
        );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        $oldName = $team->name;
        $members = Member::all()->where('team_id', $team->id);
        if ($members) {
            foreach ($members as $member) {
                Mail::to($member->user->email)->send(new TeamDeletedMail($member, $oldName));
            }
        }
        $team->delete();
        return response(['message' => 'Deleted Succesfully']);
    }
}
