<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class IssueController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $raised = Issue::with(['user', 'service'])->where('status', 'raised')->get();
        $resolved = Issue::with(['user', 'service'])->where('status', 'resolved')->get();
        $unresolved = Issue::with(['user', 'service'])->where('status', 'unresolved')->get();
        $issues = Issue::with(['user', 'service'])->latest()->get();
        return response()->json(['success' => true, 'message' => 'issues fetched successfull', 'issues' => $issues, 'raised' => $raised, 'resolved' => $resolved, 'unresolved' => $unresolved], 200);
    }


    public function set_issue_state(Request $request)
    {
        $resolved = Issue::find($request->input('id'))
            ->update([
                'status' => $request->input('status'),
            ]);

        return response()->json(['success' => true, 'message' => 'issues fetched successfull','resolved' => $resolved, 'resolved' => $resolved], 200);
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
            'issue' => 'required',
            'service_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'There was errors with your submission', 'errors' => $validator->errors()], 400);
        }
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $issue = Issue::create($data);
        return response()->json(["success" => true, "message" => "Issue Created Successfully", "service" => $issue], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $issue = Issue::find($request->input('id'));

        $issue->update([
            'status' => "resolved",
        ]);
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
