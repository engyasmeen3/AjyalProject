<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Http\ProjectResource;
use App\Http\Controllers\Api\AccessTokensController;


class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $projects = project::filter($request->query())->paginate();

        return projectResource::collection($projects);
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
            'description' => 'nullable|string|max:255',

        ]);

        $user = $request->user();
        if (!$user->tokenCan('projects.create')) {
            abort(403, 'Not allowed');
        }

        $project = Project::create($request->all());


        return Response::json($project, 201, [
            'Location' => route('projects.show', $project->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(project $project)
    {
        return new ProjectResource($project);

        return $project;
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
  
        ]);

        $user = $request->user();
        if (!$user->tokenCan('projects.update')) {
            abort(403, 'Not allowed');
        }

        $project->update($request->all());
        return Response::json($project);
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
        if (!$user->tokenCan('projects.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        Project::destroy($id);
        return [
            'message' => 'project deleted successfully',
        ];
    }
}
