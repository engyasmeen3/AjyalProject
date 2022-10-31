<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Student;
use App\Http\Resources\MessageResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;

class MessageController extends Controller
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

        return MessageResource::collection(Message::all());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = Student::where('id', $request->student_id)->exists();;
        // dd($student);
        if(!$student)
        {
            abort(404, 'الطالب الذي تحاول الوصول اليه غير موجود');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'subject'=> 'required|string',
            'student_id'=>'required|exists:students,id'
        ]);

        $user = $request->user();
        // if (!$user->tokenCan('messages.create')) {
        //     abort(403, 'Not allowed');
        // }

        $message = Message::create($request->all());


        return Response::json($message, 201, [
            'Location' => route('messages.show', $message->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return new MessageResource($message);

        return $message;
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject'=> 'required|string',
            'student_id'=>'required|exists:students,id'
            
        ]);

        $user = $request->user();
        // if (!$user->tokenCan('messages.update')) {
        //     abort(403, 'Not allowed');
        // }

        $message->update($request->all());


        return Response::json($message);
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
        // if (!$user->tokenCan('messages.delete')) {
        //     return response([
        //         'message' => 'Not allowed'
        //     ], 403);
        // }

        Message::destroy($id);
        return [
            'message' => 'Message deleted successfully',
        ];
    }
}
