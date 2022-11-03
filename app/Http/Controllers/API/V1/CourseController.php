<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;


class CourseController extends Controller
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
        
        // $courses = Course::filter($request->query())
        //     ->with('categories:id,name', 'trainers:id,name', 'groups:id,name')
        //     ->paginate();

        // return CourseResource::collection($courses);
        return CourseResource::collection(Course::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string|max:255',
            'trainer_id'       => 'required|exists:trainers,id',
            'group_id'         => 'required|exists:groups,id',
            'category_id'      => 'required|exists:categories,id',
            'status'           => 'in:active,inactive',
            'course_time'      => 'required|numeric|min:0',
            'short_description'=> 'required|string|max:255',
            'starts_at'        => 'required|date',
            'ends_at'          => 'required|date',
            'image'            =>  'nullable|image'
            // 'course_code'      => 'required'
        ]);
        $course = Course::create([
            'name'             => $request->name,
            'description'      => $request->description,
            'trainer_id'       => $request->trainer_id,
            'group_id'         => $request->group_id,
            'category_id'      => $request->category_id,
            'status'           => $request->status,
            'course_time'      => $request->course_time,
            'short_description'=> $request->short_description,
            'starts_at'        => $request->starts_at,
            'ends_at'          => $request->ends_at,
           
        ]);
        // if ($request->hasFile('image')) {
        //       $image_path = $request->file('image')->store('image', 'https://competition.aajyal.org/api/public/images/');
        //      $course->image = $image_path;
        // }
        if ($request->hasFile('image')) {
           
            $file = $request->file('image');
          //  $fileName = microtime(true) . '.' . $file->getClientOriginalExtension();
            $fileName =$request->file('image')->getClientOriginalName();
            // $file->move(public_path('images'), $fileName);
            $file->move(public_path('images'), $fileName);

            $course->image = $fileName;
    
        }

        $user = $request->user();
        // if (!$user->tokenCan('courses.create')) {
        //     abort(403, 'Not allowed');
        // }

        $course->save();
        // $course = Course::create($request->all());

        return Response::json($course, 201, [
            'Location' => route('courses.show', $course->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return new CourseResource($course);

        return $course;
        //
            // ->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string|max:255',
            'trainer_id'       => 'required|exists:trainers,id',
            'group_id'         => 'required|exists:groups,id',
            'category_id'      => 'required|exists:categories,id',
            'status'           => 'in:active,inactive',
            'course_time'      => 'required|numeric|min:0',
            'short_description'=> 'required|string|max:255',
            'starts_at'        => 'required|date',
            'ends_at'          => 'required|date'
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = microtime(true) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);

            $course->image = $fileName;
        }
        $user = $request->user();
        // if (!$user->tokenCan('courses.update')) {
        //     abort(403, 'Not allowed');
        // }

        $course->update($request->all());

        return Response::json($course);
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
        // if (!$user->tokenCan('courses.delete')) {
        //     return response([
        //         'message' => 'Not allowed'
        //     ], 403);
        // }

        Course::destroy($id);
        return [
            'message' => 'Course deleted successfully',
        ];
    }
}
