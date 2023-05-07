<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


Class UserController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function getUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
        
        //return $this->successResponse($users);
    }

    public function index()
    {
        $users = User::all();
        
        return $this->successResponse($users);
    }



    public function add(Request $request)
    {
        
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request,$rules);

        $user = User::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);
        //return response()->json($user, 200);
    }


    public function show($id)
    {
        //$user =  User::findOrFail($id);
        $user = User::where('id', $id)->first();

        if($user){
            return $this->successResponse($user);
        }
        else{
            return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        }
        
    }

}