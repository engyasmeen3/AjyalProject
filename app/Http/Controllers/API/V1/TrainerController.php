<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AccessTokensController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Trainer;
use App\Http\Resources\TrainerResource;


class TrainerController extends Controller
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
        
        // $trainers = Trainer::filter($request->query())->paginate();
        // return TrainerResource::collection($trainers);
        return TrainerResource::collection(Trainer::all());

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
            'ar_fname' => 'required|string|max:255',
            'ar_mname' => 'required|string|max:255',
            'ar_family' => 'required|string|max:255',
            'en_fname' => 'required|string|max:255',
            'en_mname' => 'required|string|max:255',
            'en_lname' => 'required|string|max:255',
            'card_id' => 'required|string|digits:9',
            'dob' => 'required|date',
            'mobile' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'specialization' => 'required|string|min:0',
            'country' => 'required|string',
            'user_id' => 'required|exists:users,id',

        ]);

        $user = $request->user();
        if (!$user->tokenCan('trainers.create')) {
            abort(403, 'Not allowed');
        }

        $trainer = Trainer::create($request->all());


        return Response::json($trainer, 201, [
            'Location' => route('trainers.show', $trainer->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(trainer $trainer)
    {
        return new trainerResource($trainer);

        return $trainer;
            // ->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'ar_fname' => 'required|string|max:255',
            'ar_mname' => 'required|string|max:255',
            'ar_family' => 'required|string|max:255',
            'en_fname' => 'required|string|max:255',
            'en_mname' => 'required|string|max:255',
            'en_lname' => 'required|string|max:255',
            'card_id' => 'required|string|digits:9',
            'dob' => 'required|date',
            'mobile' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'specialization' => 'required|string|min:0',
            'country' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('trainers.update')) {
            abort(403, 'Not allowed');
        }

        $trainer->update($request->all());


        return Response::json($trainer);
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
        if (!$user->tokenCan('trainers.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        Trainer::destroy($id);
        return [
            'message' => 'Trainer deleted successfully',
        ];
    }
}
