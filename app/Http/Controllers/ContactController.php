<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactResource::collection(
            Contact::paginate(5)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateContactRequest $request)
    {
        try {
            Contact::create([
                'name' => strtolower($request->name),
                'company' => strtolower($request->company),
                'phone' => strtolower($request->email),
                'email' => strtolower($request->email)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Contact successfully created.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = Contact::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'No contact found!'
            ], 400);
        }
        return $user;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        try {
            $contact->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Contact successfully updated.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Contact successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function restore(Contact $contact)
    {
        try {
            $contact->restore();
            return response()->json([
                'status' => 'success',
                'message' => 'Contact successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function search(Request $request)
    {
        return ContactResource::collection(
            Contact::where('name', 'like', '%' . $request->key . '%')
                ->orWhere('email', 'like', '%' . $request->key . '%')
                ->orWhere('contact_no', 'like', '%' . $request->key . '%')
                ->orWhere('company', 'like', '%' . $request->key . '%')
                ->orWhere('username', 'like', '%' . $request->key . '%')
                ->paginate(5)
        );
    }
}
