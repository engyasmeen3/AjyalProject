<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;


class PostController extends Controller
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
        
        $posts = Post::filter($request->query())->paginate();

        return PostResource::collection($posts);
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
            'short_description' => 'required|string',
            'status' => 'in:active,archived',
            'url' => 'required',
            'image' => 'nullable|image',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('posts.create')) {
            abort(403, 'Not allowed');
        }

        $post = Post::create($request->all());


        return Response::json($post, 201, [
            'Location' => route('posts.show', $post->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);

        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'short_description' => 'required|string',
            'status' => 'in:active,archived',
            'url' => 'required',
            'image' => 'nullable|image',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('posts.update')) {
            abort(403, 'Not allowed');
        }

        $post->update($request->all());


        return Response::json($post);
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
        if (!$user->tokenCan('posts.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        Post::destroy($id);
        return [
            'message' => 'Post deleted successfully',
        ];
    }
}
