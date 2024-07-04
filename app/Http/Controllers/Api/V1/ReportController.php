<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Mail\ReportMail;
use App\Models\Member;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use PDF;

class ReportController extends Controller
{
/**
 * Display a list of report.
 *
 * @return \Illuminate\Http\Response
 */
    public function index()
    {
        if (auth()->user()->title == 'DG') {
            $reports = Report::all();
            return response([
                'reports' => ReportResource::collection($reports),
                'message' => 'Retrieved successfully',
            ], 200);
        }

        $reports = Report::all()->where('user_id', auth()->user()->id);
        return response([
            'reports' => ReportResource::collection($reports),
            'message' => 'Retrieved successfully',
        ], 200);
    }

    /**
     * Store a newly created report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            "goals" => "required|array|min:1",
            "goals.*" => "required|string",
            "achievements" => "required|array|min:1",
            "observations" => "required|array|min:1",
            "observations.*" => "required|string",
            "next_goals" => "required|array|min:1",
            "next_goals.*" => "required|string",
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        //dd($request['achievements']);
        $content = [];
        foreach ($request['achievements'] as $achievement) {
            foreach ($achievement['content'] as $ctn) {
                array_push($content, $ctn);
            }
        }
        $report = Report::create([
            'goals' => $request['goals'],
            'achievements' => $content,
            'observations' => $request['observations'],
            'next_goals' => $request['next_goals'],
            'user_id' => auth()->user()->id,
            'status' => $request['status'],
            'validated' => 0,
        ]);

        $report->achievements = $request['achievements'];

        $fileName = "RAPPORT_HEBDOMADAIRE_" . $report->user->firstname . "_" . $report->user->lastname . "_" . $report->id . /* "_" . $report->created_at . */".pdf";
        $path = 'storage/pdf'; //public_path('storage');
        $storePath = $path . '/' . $fileName;

        view()->share('pdf.report', $report);
        $pdf = PDF::loadView('pdf.report', compact('report'));

        $pdf->save(public_path($storePath));
        $report->update(['pdf' => $storePath]);

        return response([
            'request' => new ReportResource($report),
            'message' => 'Created successfully',
        ], 200);
    }

    public function ok(Request $request)
    {

        $report = Report::find(12);

        $fileName = "RAPPORT_HEBDOMADAIRE_" . $report->user->firstname . "_" . $report->user->lastname . "_" . $report->id . /* "_" . $report->created_at . */".pdf";
        $path = 'storage/pdf'; //public_path('storage');
        $storePath = $path . '/' . $fileName;

        view()->share('pdf.report', $report);
        $pdf = PDF::loadView('pdf.report', compact('report'));

        $pdf->save(public_path($storePath));
        $report->update(['pdf' => $storePath]);

        return view('pdf.report', compact('report'));

    }

    /**
     * Display the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        if (auth()->user()->id !== $report->user_id && auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'You cannot show this request'], 403);
        }

        return response([
            'report' => new ReportResource($report),
            'message' => 'Retrieved successfully',
        ], 200);
    }

    /**
     * Update the specified report in list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        if (auth()->user()->id !== $report->user_id) {
            return response()->json(['error' => "You cannot edit this report.
            You're  not the owner"], 403);
        }

        $report->update($request->all());
        $fileName = "RAPPORT_HEBDOMADAIRE_" . $report->user->firstname . "_" . $report->user->lastname . "_" . $report->id . /* "_" . $report->created_at . */".pdf";
        $path = 'storage/pdf'; //public_path('storage');
        $storePath = $path . '/' . $fileName;

        view()->share('pdf.report', $report);
        $pdf = PDF::loadView('pdf.report', compact('report'));

        $pdf->save(public_path($storePath));
        $report->update(['pdf' => $storePath]);

        return response(
            [
                'updatedReport' => new ReportResource($report),
                'message' => 'Updated successfully',
            ],
            200
        );
    }
    /**
     * Validate the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function checked(Report $report)
    {
        if (auth()->user()->id !== $report->user_id) {
            return response()->json(['error' => "You cannot send this report.
            You're  not the owner"], 403);
        }

        if (auth()->user()->title == 'STAGIAIRE') {
            $members = Member::all()->where('user_id', auth()->user()->id);
            $teamLeads = [];
            if ($members) {
                foreach ($members as $member) {
                    $teamMembers = Member::all()->where('team_id', $member->team_id);
                    foreach ($teamMembers as $teamMember) {
                        if ($teamMember->role == '1') {
                            array_push($teamLeads, $teamMember);
                        }
                    }
                }
                if (count($teamLeads) != 0) {
                    foreach ($teamLeads as $teamLead) {
                        if ($teamLead->user->title == 'STAGIAIRE') {
                            $boss = User::where('title', 'DG')->get();
                            Mail::to($boss[0]->email)->send(new ReportMail($report));
                        } else {
                            Mail::to($teamLead->user->email)->send(new ReportMail($report));
                        }
                    }
                } else {
                    $boss = User::where('title', 'DG')->get();
                    Mail::to($boss[0]->email)->send(new ReportMail($report));
                }
            } else {
                $boss = User::where('title', 'DG')->get();
                Mail::to($boss[0]->email)->send(new ReportMail($report));
            }
        } else {
            $boss = User::where('title', 'DG')->get();
            Mail::to($boss[0]->email)->send(new ReportMail($report));
        }

        $report->update(['validated' => 1]);

        return response(
            [
                'validatedReport' => $report,
                'message' => 'Validated successfully',
            ],
            200
        );
    }

    /**
     * Remove the specified report from list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {

        if (auth()->user()->id !== $report->user_id) {
            return response()->json(['error' => "You're not owner"], 403);
        }
        $report->delete();

        return response(['message' => 'Deleted Succesfully']);
    }
}