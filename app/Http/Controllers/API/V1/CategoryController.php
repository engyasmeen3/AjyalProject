<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Api\AccessTokensController;


class CategoryController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:sanctum')->except('index', 'show');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        //$categories = Category::filter($request->query())->paginate();
        // return CategoryResource::collection($categories);
        
        // $categories = Category::all();
        // return $categories;
        return CategoryResource::collection(Category::all());

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
            'parent_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'is_parent' => 'in:true,false',
            'slug' => 'required|string|min:0',
            'image' => 'nullable',
        ]);

        $user = $request->user();
        // if (!$user->tokenCan('categories.create')) {
        //     abort(403, 'Not allowed');
        // }

        $category = Category::create($request->all());

        return Response::json($category, 201, [
            'Location' => route('categories.show', $category->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);

        return $category;
        //q
        // ->load('name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'parent_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'is_parent' => 'in:true,false',
            'slug' => 'required|string|min:0',
            'image' => 'nullable',
        ]);

        $user = $request->user();
        // if (!$user->tokenCan('categories.update')) {
        //     abort(403, 'Not allowed');
        // }

        $category->update($request->all());


        return Response::json($category);
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
        // if (!$user->tokenCan('categories.delete')) {
        //     return response([
        //         'message' => 'Not allowed'
        //     ], 403);
        // }

        Category::destroy($id);
        return [
            'message' => 'Category deleted successfully',
        ];
    }


}
