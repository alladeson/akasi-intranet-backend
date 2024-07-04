<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Mail\ProjectDeletedMail;
use App\Mail\ProjectUpdatedMail;
use App\Models\Member;
use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->title !== 'DG') {
            $teams = [];
            $projects = [];
            $members = Member::all()->where('user_id', auth()->user()->id);
            if ($members) {
                foreach ($members as $member) {
                    $team = Team::find($member->team_id);
                    if ($team != null) {
                        array_push($teams, $team);
                    }
                }

                foreach ($teams as $team) {
                    $project = Project::find($team->project_id);
                    if ($project != null) {
                        array_push($projects, $project);
                    }
                }
            }

            return response(
                [
                    'projects' => ProjectResource::collection($projects),
                    'message' => 'Retrieved successfully',
                ],
                200
            );}
        $projects = Project::all();
        return response([
            'projects' => ProjectResource::collection($projects),
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
            'description' => ['required', 'string'],
            'starting_date' => ['required', 'string'],
            'estimated_time' => ['required', 'string'],
            'tools' => ['required', 'string'],
            'status' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $project = Project::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'starting_date' => $request['starting_date'],
            'estimated_time' => $request['estimated_time'],
            'tools' => $request['tools'],
            'status' => $request['status'],
        ]);

        return response([
            'message' => 'Successfully registered',
            'project' => $project,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        return response([
            'project' => new ProjectResource($project),
            'message' => 'Retrieved successfully',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        $oldName = $project->name;
        $project->update($request->all());
        $teams = Team::all()->where('project_id', $project->id);
        $allMembers = [];
        if ($teams) {
            foreach ($teams as $team) {
                $members = Member::all()->where('team_id', $team->id);
                foreach ($members as $member) {
                    array_push($allMembers, $member);
                }
            }}
        if (count($allMembers) != 0) {
            foreach ($allMembers as $singleMember) {
                Mail::to($singleMember->user->email)->send(new ProjectUpdatedMail($member, $oldName));
            }
        }

        return response(
            [
                'updatedProject' => new ProjectResource($project),
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
    public function destroy(Project $project)
    {

        if (auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'Permission denied'], 403);
        }
        $oldName = $project->name;
        $teams = Team::all()->where('project_id', $project->id);
        $allMembers = [];
        if ($teams) {
            foreach ($teams as $team) {
                $members = Member::all()->where('team_id', $team->id);
                foreach ($members as $member) {
                    array_push($allMembers, $member);
                }
            }}
        if (count($allMembers) != 0) {
            foreach ($allMembers as $singleMember) {
                Mail::to($singleMember->user->email)->send(new ProjectDeletedMail($member, $oldName));
            }
        }
        $project->delete();

        return response(['message' => 'Deleted Succesfully']);
    }
}
