<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\Collaborator;
use App\Models\CollaboratorCatalogData;

class CollaboratorController extends Controller
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
    public function create()
    {
        //
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
        $collaborator = null;

        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|unique:collaborators',
                'corporate_id' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $collaborator = Collaborator::create([
                'email' => $request->email,
                'corporate_id' => $request->corporate_id,
                'description' => $request->description,
                'active' => $request->active,
            ]);

            if ($collaborator) {
                $success = true;
                $message = 'Collaborator created successfully.';

                if ($request->has('catalog')) {
                    if ($request->catalog) {
                        CollaboratorCatalogData::where('collaborator_id', $collaborator->id)->delete();
                        foreach ($request->catalog as $key => $value) {
                            if ($value !== null) {
                                CollaboratorCatalogData::create(
                                    [
                                        'collaborator_id' => $collaborator->id,
                                        'collaborator_catalog_id' =>  $key,
                                        'value' => $value
                                    ]
                                );
                            }
                        }
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
            'data'    => $collaborator,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Collaborator $collaborator)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($collaborator) {
            $collaborator->catalog = CollaboratorCatalogData::where('collaborator_id', $collaborator->id)->get();
            $success = true;
            $message = 'Collaborator founded successfully';
            $data = $collaborator;
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
    public function edit(Collaborator $collaborator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collaborator $collaborator
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Collaborator $collaborator): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $collaborator->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'Collaborator updated successfully.';

            if ($request->has('catalog')) {
                if ($request->catalog) {
                    CollaboratorCatalogData::where('collaborator_id', $collaborator->id)->delete();
                    foreach ($request->catalog as $key => $value) {
                        if ($value !== null) {
                            CollaboratorCatalogData::create(
                                [
                                    'collaborator_id' => $collaborator->id,
                                    'collaborator_catalog_id' =>  $key,
                                    'value' => $value
                                ]
                            );
                        }
                    }
                }
            }

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Collaborator.';

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
     * @param  Collaborator  $collaborator
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Collaborator $collaborator): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $collaborator->id;

        if ($id) {
            $collaborator->delete();
            $deleted = Collaborator::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Collaborator deleted successfully.';

                CollaboratorCatalogData::where('collaborator_id', $collaborator->id)->delete();

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Collaborator.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Retrieve Clients with query arguments
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

        $select = ['collaborators.id', 'email', 'corporate_id', 'collaborators.active', 'collaborators.description', 'corporates.name AS corporate'];

        $query = Collaborator::select($select)
            ->leftJoin('corporates', 'corporates.id', 'collaborators.corporate_id', 'corporates.name');

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('collaborators.active', $request->active);
            }
        }

        if ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('collaborators.active', 1);
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
                $query->where('email', 'like', '%' . $request->q . '%')
                    ->orWhere('collaborators.description', 'like', '%' . $request->q . '%')
                    ->orWhere('corporates.name', 'like', '%' . $request->q . '%')
                    ->orWhere('corporates.rfc', 'like', '%' . $request->q . '%')
                    ->orWhere('corporates.cp', 'like', '%' . $request->q . '%')
                    ->orWhere('corporates.description', 'like', '%' . $request->q . '%');
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
            $message = 'Clients fetched correctly';
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
