<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Http\Resources\ContractResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;


class ContractController extends Controller
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
        
        $contract = Contract::filter($request->query())
            ->with('students:id,name', 'groups:id,name', 'platforms:id,name')
            ->paginate();

        return ContractResource::collection($contract);
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'student_id' => 'required|exists:students,id',
            'group_id' => 'required|exists:groups,id',
            'platform_id' => 'required|exists:platforms,id',
            'status' => 'in:active,inactive',
            'amount' => 'required|numeric|min:0',
            'contract_image' => 'nullable|image',
            'period'=>'required|date_format:H:i',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('contracts.create')) {
            abort(403, 'Not allowed');
        }

        $contract = Contract::create($request->all());


        return Response::json($contract, 201, [
            'Location' => route('contracts.show', $contract->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $product)
    {
        return new ContractResource($product);

        return $contract;
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
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'student_id' => 'required|exists:students,id',
            'group_id' => 'required|exists:groups,id',
            'platform_id' => 'required|exists:platforms,id',
            'status' => 'in:active,inactive',
            'amount' => 'required|numeric|min:0',
            'contract_image' => 'nullable|image',
            'period'=>'required|date_format:H:i',
        ]);

        $user = $request->user();
        if (!$user->tokenCan('contracts.update')) {
            abort(403, 'Not allowed');
        }

        $contract->update($request->all());


        return Response::json($contract);
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
        if (!$user->tokenCan('contracts.delete')) {
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

        Contract::destroy($id);
        return [
            'message' => 'Contract deleted successfully',
        ];
    }
}
