<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Resources\GroupResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;

class GroupController extends Controller
{

    public function __construct()
    {
       // $this->middleware('auth:sanctum')->except('index', 'show');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $group = Group::filter($request->query())->paginate();

        return GroupResource::collection($group);
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
        ]);

        $user = $request->user();
        if (!$user->tokenCan('groups.create')) {
            abort(403, 'Not allowed');
        }

        $group = Group::create($request->all());


        return Response::json($group, 201, [
            'Location' => route('groups.show', $group->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return new GroupResource($group);

        return $group;
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            

        ]);

        $user = $request->user();
        if (!$user->tokenCan('groups.update')) {
            abort(403, 'Not allowed');
        }

        $group->update($request->all());


        return Response::json($group);
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
        if (!$user->tokenCan('groups.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        Group::destroy($id);
        return [
            'message' => 'group deleted successfully',
        ];
    }
}
