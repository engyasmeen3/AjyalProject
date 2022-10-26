<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Http\Resources\AttendanceResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;


class AttendanceController extends Controller
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
            
            // $attendance = Attendance::filter($request->query())->paginate();
    
            // return AttendanceResource::collection($attendance);
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
                'date'            => 'required|date',
                'course_id'       => 'required|exists:courses,id',
            ]);
    
            $user = $request->user();
            if (!$user->tokenCan('attendances.create')) {
                abort(403, 'Not allowed');
            }
    
            $attendance = Attendance::create($request->all());
    
            return Response::json($attendance, 201, [
                'Location' => route('attendances.show', $attendance->id),
            ]);
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(Attendance $attendance)
        {
            return new AttendanceResource($attendance);
    
            return $attendance;
            }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Attendance $attendance)
        {
            $request->validate([
                'date'            => 'required|date',
                'course_id'       => 'required|exists:courses,id',

            ]);
    
            $user = $request->user();
            if (!$user->tokenCan('attendances.update')) {
                abort(403, 'Not allowed');
            }
    
            $attendance->update($request->all());
    
    
            return Response::json($attendance);
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
            if (!$user->tokenCan('attendances.delete')) {
                return response([
                    'message' => 'Not allowed'
                ], 403);
            }
    
            Attendance::destroy($id);
            return [
                'message' => 'attendance deleted successfully',
            ];
        }
    }
    

