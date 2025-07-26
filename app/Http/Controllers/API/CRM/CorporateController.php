<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\Corporate;
use App\Models\CorporateCatalogData;
use App\Models\CorporateAddressData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CorporateController extends Controller
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
        $corporate = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'rfc' => 'required|string|min:5|max:13|unique:corporates',
                //'cp' => 'required|string|min:5|max:5',
            ]
        );


        if ($validator->fails()) {

            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $corporate = Corporate::create([
                'name' => $request->name,
                'rfc' => $request->rfc,
                //'cp' => $request->cp,
                'description' => $request->description,
                'active' => $request->active,
            ]);

            if ($corporate) {
                $success = true;
                $message = 'Corporate created successfully.';

                if ($request->has('catalog')) {
                    if ($request->catalog) {
                        //CorporateCatalogData::where('collaborator_id', $corporate->id)->delete(); //porque se quiere eliminar el catalogo?
                        foreach ($request->catalog as $key => $value) {
                            if ($value !== null) {
                                CorporateCatalogData::create(
                                    [
                                        'collaborator_id' => $corporate->id,
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
            'data'    => $corporate,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Corporate $corporate)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($corporate) {
            $select = [
                'id',
                'value',
                'corporate_id',
                'corporate_catalog_id'
            ];

            $corporate->address = $corporate_address = CorporateAddressData::
                where('corporate_id', $corporate->id)
                ->first();

            if(!$corporate->address){
                $corporate->address = [
                    'id' => 0,
                    'street' => '',
                    'country' => 0,
                    'state' => 0,
                ];
            }

/*
            $select = [
                            'id',
                            'value',
                            'corporate_id',
                            'corporate_catalog_id'
                        ];

            $corporate->catalog = CorporateCatalogData::select($select)
                ->where('corporate_id', $corporate->id)
                ->get();
*/

            $success = true;
            $message = 'Corporate founded successfully';
            $data = $corporate;
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
    public function edit(Corporate $corporate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Corporate $corporate
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Corporate $corporate): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $corporate->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'Empresa actualizada correctamente.';

            /*
            $address_data = CorporateAddressData::where('corporate_id', $corporate->id)->first();
            if(!$address_data){
                $address_data = CorporateAddressData::create([
                        'corporate_id' => $corporate->id,
                        'active' => $request->name,
                    ]);
            }*/

            //Recuerda hacer los campos fillables en el modelo para que se puedan guardar
            $address_data = CorporateAddressData::firstOrCreate([
                'corporate_id' => $corporate->id
            ]);
            $res_address = $address_data->fill($input)->save();

            if(!$res_address){
                $message = 'Error, no se pudieron actualizar todos los datos.';
                $success = false;
            }

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Corporate.';

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
     * @param  Corporate  $corporate
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Corporate $corporate): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $corporate->id;

        if ($id) {
            $corporate->delete();
            $deleted = Corporate::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Corporate deleted successfully.';

                CorporateCatalogData::where('corporate_id', $corporate->id)->delete();

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Corporate.';

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
     * Retrieve Corporates with query arguments
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
            'corp.id',
            'corp.rfc',
            'corp.name as corporate',
            'corp.description',
            'corp.active',
            'cont.id as contact',
            'cont.name',
            'cont.paternal',
            'cont.maternal',
            'cont.phone',
            'cont.email',
        /*     'addr.street',
            'addr.country',
            'addr.state', */
        ];


        $query = Corporate::from('corporates as corp')
            // ->leftJoin('corporate_address_data as addr', 'addr.corporate_id', '=', 'corp.id')
            ->leftJoin('contact_corporate as cc', function($join) {
                $join->on('cc.corporate', '=', 'corp.id')
                    ->where('cc.main', '=', 1);
            })
            ->leftJoin('contacts as cont', 'cont.id', '=', 'cc.contact')
            ->select($select);

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('corp.active', $request->active);
            }
        }

        if ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('corp.active', 1);
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
                $query->where('rfc', 'like', '%' . $request->q . '%')
                    ->orWhere('name', 'like', '%' . $request->q . '%')
                    ->orWhere('cp', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            }
        }


/*        $searchTerm = $request->q;
        $query->where(function($subQuery) use ($searchTerm) {
            $subQuery->where('rfc', 'like', '%' . $searchTerm . '%')
                     ->orWhere('name', 'like', '%' . $searchTerm . '%')
                     ->orWhere('cp', 'like', '%' . $searchTerm . '%')
                     ->orWhere('description', 'like', '%' . $searchTerm . '%');
  */


        $totalResults = $query->count();

        if ($perPage > -1) {
            $query->skip($skip)->take($perPage);
        }

        $filteredResults = $query->get();

        if ($filteredResults) {
            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Corporates fetched correctly';
        }

        return response()->json([
            'data' => $filteredResults,
            'totalPage' => $totalPage,
            'totalResults' => $totalResults,
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Retrieve Collaborators for a Corporate Id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $corporateId
     * @return \Illuminate\Http\JsonResponse
     */
    public function collaborators(Request $request): JsonResponse
    {
        $success = false;
        $message = '';
        $result = [];

        if ($request->has('corporateId')) {

            $select = ['collaborators.id', 'email', 'collaborators.description', 'corporate_id'];

            $result   = Collaborator::select($select)
            ->where('collaborators.corporate_id', $request->corporateId)
            ->get();


            if ($result) {
                $success = true;
                $message = 'Collaborators retrieved successfully';
            } else {
                $success = false;
                $message = 'Corporate not founded';
            }
        }

        return response()->json([
            'data' => $result,
            'success' => $success,
            'message' => $message,
        ]);
    }


    public function address(Request $request): JsonResponse
    {
        $success = false;
        $message = '';
        $result = [];

        if ($request->has('corporateId')) {

            $select = ['collaborators.id', 'email', 'collaborators.description', 'corporate_id'];


            $corporate->address = $corporate_address = CorporateAddressData::
                where('corporate_id', $corporate->id)
                ->get();



            if ($result) {
                $success = true;
                $message = 'Collaborators retrieved successfully';
            } else {
                $success = false;
                $message = 'Corporate not founded';
            }
        }

        return response()->json([
            'data' => $result,
            'success' => $success,
            'message' => $message,
        ]);
    }//public function address(Request $request..

}
