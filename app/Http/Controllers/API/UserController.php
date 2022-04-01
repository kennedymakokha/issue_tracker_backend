<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Validator;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();
        return response()->json(["success" => true, "message" => " Users fetched successfully", 'users' => $users], 200);
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
            'name' => 'required|unique:users',
            // 'email' => 'required|unique:users',
            'password' => 'required',

        ]);

        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => 'There was errors with your submission', 'errors' => $validator->errors()], 400);
        }
        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->all());
        return response()->json(["success" => true, "message" => "User Created Successfully", "user" => $user], 200);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',

            'password' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json(['success' => false, 'message' => 'There was errors with your submission', 'errors' => $validator->errors()], 400);
        }
        if (Auth::attempt(['name' => request('name'), 'password' => request('password')])) {

            $user = Auth::user();
            // Generating User Token Unique To The User
            $token = $user->createToken($user->name)->accessToken;

            return response()->json(['success' => true, 'message' => 'Logged In Successfully', 'token' => $token], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'There was an error with your submission', 'error' => 'Invalid Credentials'], 400);
        }
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
