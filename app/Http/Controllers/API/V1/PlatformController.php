<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use App\Http\Resources\PlatformResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;

class PlatformController extends Controller
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
        
        // $platform = Platform::filter($request->query())->paginate();

        // return PlatformResource::collection($platform);
        return PlatformResource::collection(Platform::all());

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
        if (!$user->tokenCan('platforms.create')) {
            abort(403, 'Not allowed');
        }

        $platform = Platform::create($request->all());


        return Response::json($platform, 201, [
            'Location' => route('platforms.show', $platform->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Platform $platform)
    {
        return new PlatformResource($platform);

        return $platform
            ->load('category:id,name', 'store:id,name', 'tags:id,name');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Platform $platform)
    {
        $request->validate([
            'name' => 'required|string|max:255',


        ]);

        $user = $request->user();
        if (!$user->tokenCan('platforms.update')) {
            abort(403, 'Not allowed');
        }

        $platform->update($request->all());


        return Response::json($platform);
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
        if (!$user->tokenCan('platforms.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        platform::destroy($id);
        return [
            'message' => 'platform deleted successfully',
        ];
    }
}
