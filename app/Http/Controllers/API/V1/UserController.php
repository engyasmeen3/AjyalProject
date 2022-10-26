<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AccessTokensController;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
 
    public function __construct()
    {
      //  $this->middleware('auth:sanctum')->except('index', 'show');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $users = User::filter($request->query())->paginate();

        // return UserResource::collection($users);
        return UserResource::collection(User::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique',
            'password' => 'required',

        ]);

        $user = $request->user();
        if (!$user->tokenCan('users.create')) {
            abort(403, 'Not allowed');
        }

        $user = User::create($request->all());

        return Response::json($user, 201, [
            'Location' => route('users.show', $user->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique',
            'password' => 'required',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('users.update')) {
            abort(403, 'Not allowed');
        }
        $user->update($request->all());
        return Response::json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user->tokenCan('users.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        User::destroy($id);
        return [
            'message' => 'User deleted successfully',
        ];
    }
}
