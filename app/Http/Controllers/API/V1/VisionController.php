<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vision;
use App\Http\Resources\VisionResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;


class VisionController extends Controller
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
            
            // $vision = Vision::filter($request->query())->paginate();
    
            // return VisionResource::collection($vision);
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
                'name'              => 'required|string|max:255',
                'description'       => 'required',
                'vision'            => 'required',
                'letter'            => 'required'
            ]);
    
            $user = $request->user();
            // if (!$user->tokenCan('Visions.create')) {
            //     abort(403, 'Not allowed');
            // }
    
            $vision = Vision::create($request->all());
    
            return Response::json($vision, 201, [
                'Location' => route('visions.show', $vision->id),
            ]);
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(Vision $vision)
        {
            return new VisionResource($vision);
    
            return $vision;
            }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Vision $vision)
        {
            $request->validate([
                'name'              => 'required|string|max:255',
                'description'       => 'required',
                'vision'            => 'required',
                'letter'            => 'required'

            ]);
    
            $user = $request->user();
            // if (!$user->tokenCan('Visions.update')) {
            //     abort(403, 'Not allowed');
            // }
    
            $vision->update($request->all());
    
    
            return Response::json($vision);
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
            // if (!$user->tokenCan('Visions.delete')) {
            //     return response([
            //         'message' => 'Not allowed'
            //     ], 403);
            // }
    
            Vision::destroy($id);
            return [
                'message' => 'Vision deleted successfully',
            ];
        }
    }
    

