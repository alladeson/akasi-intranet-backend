<?php

namespace App\Http\Controllers\Api\V1;

use PDF;
use App\Models\User;
use App\Models\Permission;
use App\Mail\PermissionMail;
use Illuminate\Http\Request;
use App\Mail\CancelPermissionMail;
use App\Mail\RejectPermissionMail;
use App\Mail\ApprovePermissionMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PermissionResource;

class PermissionController extends Controller
{
    /**
     * Display a list of requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->title == 'DG') {
            $requests = Permission::all();
            return response([
                'requests' => PermissionResource::collection($requests),
                'message' => 'Retrieved successfully',
            ], 200);
        }

        $requests = Permission::all()->where('user_id', auth()->user()->id);
        return response([
            'requests' => PermissionResource::collection($requests),
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
        $validator = Validator::make($request->all(), [

            'object' => ['required', 'string', 'max:255'],
            'reasons' => ['required', 'string'],
            'starting_date' => ['required', 'string', 'max:255'],
            'ending_date' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        
        $piece = null;
        if ($request->file('piece')) {
            $piece = Storage::disk('local')->put('pieces', $request->piece);
        }

        $permission = Permission::create([
            'object' => $request['object'],
            'reasons' => $request['reasons'],
            'starting_date' => $request['starting_date'],
            'ending_date' => $request['ending_date'],
            'duration' => $request['duration'],
            'piece' => $piece,
            'status' => $request['status'],
            'user_id' => auth()->user()->id,
        ]);
/*         $fileName = "DEMANDE_DE_PERMISSION_" . $permission->user->firstname . "_" . $permission->user->lastname . "_" . $permission->id . "_" . $permission->created_at  . ".pdf";
        $path = 'storage/pdf'; public_path('storage');
        $storePath = $path . '/' . $fileName;

        view()->share('pdf.permission', $permission);
        $pdf = PDF::loadView('pdf.permission', compact('permission'));

        $pdf->save(public_path($storePath)); */
        
        $boss = User::where('title', 'DG')->get();
        Mail::to($boss[0]->email)->send(new PermissionMail($permission));

/*         $permission->update(['pdf' => $storePath]);
 */
        return response([
            'request' => new PermissionResource($permission),
            'message' => 'Created successfully',
        ], 200);
    }

/**
 * Display the specified request.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function show(Permission $permission)
    {
        if (auth()->user()->id !== $permission->user_id && auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'You cannot show this request'], 403);
        }
        return response([
            'request' => new PermissionResource($permission),
            'message' => 'Retrieved successfully',
        ], 200);
    }

/**
 * Update the specified permission request .
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function update(Request $request, Permission $permission)
    {

        if (auth()->user()->id !== $permission->user_id && auth()->user()->title !== 'DG') {
            return response()->json(['error' => 'You cannot edit this request'], 403);
        }

        if ($request->file('piece')) {
            $piece = Storage::disk('local')->put('pieces', $request->piece);
            $permission->update(['piece' => $piece]);
        }

        $permission->update($request->except(['piece']));

        if (auth()->user()->title == 'DG') {

            if ($permission->status == 0) {
                Mail::to($permission->user->email)->send(new RejectPermissionMail($permission));
            } else {
                Mail::to($permission->user->email)->send(new ApprovePermissionMail($permission));
            }
            return response()->json([
                'updatedRequest' => new PermissionResource($permission),
                'message' => 'Updated successfully',
            ],
                200);
        }
        
        $boss = User::where('title', 'DG')->get();

        Mail::to($boss[0]->email)->send(new PermissionMail($permission));
        return response(
            [
                'updatedRequest' => new PermissionResource($permission),
                'message' => 'Updated successfully',
            ],
            200
        );
    }

    /**
     * Cancel the specified report in list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(Permission $permission)
    {
        if (auth()->user()->id !== $permission->user_id) {
            return response()->json([
                'error' => "You cannot cancel this permission. You're  not the owner",
                "ok" => $permission,
            ], 403);
        }

        $permission->update(['status' => 2]);
        $boss = User::where('title', 'DG')->get();
        Mail::to($boss[0]->email)->send(new CancelPermissionMail($permission));

        return response(
            [
                'canceledPermission' => new PermissionResource($permission),
                'message' => 'Canceled successfully',
            ],
            200
        );
    }

/**
 * Remove the specified permission request.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function destroy(Permission $permission)
    {

        if (auth()->user()->id !== $permission->user_id) {
            return response()->json(['error' => "You're not owner"], 403);
        }

        $permission->delete();

        return response(['message' => 'Deleted Succesfully']);
    }
}