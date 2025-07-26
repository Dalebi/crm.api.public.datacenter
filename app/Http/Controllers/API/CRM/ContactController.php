<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Contact;
use App\Models\ContactCorporate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        return response()->json([
            'success' => 'create',
            'message' => '',
            'data'    => $request,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {

        $message = '';
        $success = false;
        $Contact = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'paternal' => 'required|string',
                'maternal' => 'required|string',
            ]
        );

        if ($validator->fails()) {

            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $Contact = Contact::create([
                'name' => $request->name,
                'paternal' => $request->paternal,
                'maternal' => $request->maternal,
                'phone' => $request->phone,
                'email' => $request->email,
            ]);

            if ($Contact) {
                $success = true;
                $message = 'Contact created successfully.';

                if ($request->has('corporate')) {
                    if ($request->corporate) {
                        ContactCorporate::create(
                                [
                                    'contact' => $Contact->id,
                                    'corporate' =>  $request->corporate,
                                ]
                            );
                    }
                }

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new client.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $Contact,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $Contact)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($Contact) {
            $Contact->corporate = $Contact_address = ContactCorporate::
                where('Contact', $Contact->id)
                ->where('active', true)
                ->corporate
                ->first();

            if(!$Contact->corporate){
                $Contact->corporate = '';
            }


            $success = true;
            $message = 'Contact founded successfully';
            $data = $Contact;
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $Contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact $Contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Contact $Contact): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $Contact->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'Contact updated successfully.';

            if ($request->has('corporate')) {
                if ($request->corporate) {
                    ContactCorporate::where('contact', $Contact->id)->delete();
                    ContactCorporate::create(
                        [
                            'contact' => $Contact->id,
                            'corporate' =>  $request->corporate,
                        ]
                    );
                }
            }

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Contact.';

            activity()->log($message);
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact  $Contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Contact $Contact): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $Contact->id;
/*
        if ($id) {
            $Contact->delete();
            $deleted = Contact::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Contact deleted successfully.';

                ContactCatalogData::where('Contact_id', $Contact->id)->delete();

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Contact.';

                activity()->log($message);
            }
        }*/

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Retrieve Contacts with query arguments
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $q
     * @param  int  $perPage
     * @param  int  $currentPage
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request): JsonResponse
    {
        $success = false;
        $message = '';

        $skip = $request->currentPage ? ($request->currentPage - 1) * $request->perPage : 0;
        $perPage = $request->perPage ? $request->perPage : 10;
        $totalPage = 0;
        $totalResults = 0;

        $select = [
            'cont.id',
            'cont.name',
            'cont.paternal',
            'cont.maternal',
            'cont.phone',
            'cont.email',
            'cont.active'
        ];

        $query = Contact::
            from('contacts as cont')
            ->leftjoin('contact_corporate as cc', "cc.contact", "=", "cont.id" )
            ->select($select);

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('cont.active', $request->active);
            }
        }

        if ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('cont.active', 1);
            }
        }

        if ($request->has('corporate_id')) {
            if ($request->corporate_id) {
                //$query->where('cc.corporate', '=',  $request->corporate_id );
            }
        }


        if ($request->has('sortBy')) {
            if ($request->sortBy) {
                foreach ($request->sortBy as $groupBy) {
                    $query->orderBy($groupBy['key'], $groupBy['order']);
                }
            }
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('cont.name', 'like', '%' . $request->q . '%')
                    ->orWhere('cont.paternal', 'like', '%' . $request->q . '%')
                    ->orWhere('cont.maternal', 'like', '%' . $request->q . '%')
                    ->orWhere('cont.phone', 'like', '%' . $request->q . '%')
                    ->orWhere('cont.email', 'like', '%' . $request->q . '%')
                    ;
            }
        }

        $totalResults = $query->count();

        if ($perPage > -1) {
            $query->skip($skip)->take($perPage);
        }

        $filteredResults = $query->get();

        if ($filteredResults) {
            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Contacts fetched correctly';
        }

        return response()->json([
            'data' => $filteredResults,
            'totalPage' => $totalPage,
            'totalResults' => $totalResults,
            'success' => $success,
            'message' => $message,
        ]);
    }




}
