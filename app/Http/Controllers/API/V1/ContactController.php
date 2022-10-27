<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AccessTokensController;

class ContactController extends Controller
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
        
        // $groups = Group::filter($request->query())->paginate();
        // return GroupResource::collection($groups);
        return ContactResource::collection(Contact::all());

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
            'email' => 'required',
            'mobile' => 'nullable',
            'body' =>'required'
        ]);

        $user = $request->user();
        // if (!$user->tokenCan('groups.create')) {
        //     abort(403, 'Not allowed');
        // }

        $contact = Contact::create($request->all());


        return Response::json($contact, 201, [
            'Location' => route('contacts.show', $contact->id),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);

        return $contact;
        }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'required',
            'mobile' => 'nullable',
            'body' =>'required'

        ]);

        $user = $request->user();
        // if (!$user->tokenCan('groups.update')) {
        //     abort(403, 'Not allowed');
        // }

        $contact->update($request->all());


        return Response::json($contact);
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
        // if (!$user->tokenCan('groups.delete')) {
        //     return response([
        //         'message' => 'Not allowed'
        //     ], 403);
        // }

        Contact::destroy($id);
        return [
            'message' => 'contact deleted successfully',
        ];
    }
}
