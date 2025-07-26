<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opportunity;
use App\Models\OpportunityDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class OpportunityController extends Controller
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
        $Opportunity = null;
        $userId = Auth::id();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
            ]
        );

        if ($validator->fails()) {

            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $quote_file_route = '';
            if ($request->file('quote_file')) {
                $filename = $request->corporate_id . date('Ymd_His'); //$request->file('quote_file')->hashName(); // Generate a unique, random name...
                $extension = $request->file('quote_file')->extension(); // Determine the file's extension based on the file's MIME type...
                $dir = "quotes/".date('Y')."/".date('m');

                $request->file('quote_file')->storeAs('public/'.$dir, $filename.'.'.$extension);
                $quote_file_route = $dir.'/'.$filename.'.'.$extension;
            }

/*            return response()->json([
                'success' => 'success',
                'message' => $quote_file_route,
                'data'    => '',
            ]);*/

            $Opportunity = Opportunity::create([
                'name' => $request->name,
                'corporate_id' => $request->corporate_id,
                'contact_id' => $request->contact_id,
                'consultant_id' => $userId,
                'quote_file' => $quote_file_route,
                'active' => '1',
            ]);

            if ($Opportunity) {
                $success = true;
                $message = 'Opportunity created successfully.';

                if ($request->has('description')) {
                    if ($request->description) {

                        OpportunityDetail::create(
                                [
                                    'folio' => 1,
                                    'opportunity_id' => $Opportunity->id,
                                    'description' => $request->description,
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
            'data'    => $Opportunity,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Opportunity $Opportunity)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($Opportunity) {
            $Opportunity->crono =  OpportunityDetail::
                where('opportunity_id', $Opportunity->id)
                ->where('active', true)
                ->get();



            $success = true;
            $message = 'Opportunity founded successfully';
            $data = $Opportunity;
            $data->quote_file_src = 'http://localhost:8000/storage/'. $data->quote_file;//env('APP_URL')
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
    public function edit(Opportunity $Opportunity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Opportunity $Opportunity
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Opportunity $Opportunity): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $quote_file_route = '';
        if ($request->file('quote_file')) {
            $filename = $request->corporate_id . date('Ymd_His'); //$request->file('quote_file')->hashName(); // Generate a unique, random name...
            $extension = $request->file('quote_file')->extension(); // Determine the file's extension based on the file's MIME type...
            $dir = "quotes/".date('Y')."/".date('m');

            $request->file('quote_file')->storeAs('public/'.$dir, $filename.'.'.$extension);
            $quote_file_route = $dir.'/'.$filename.'.'.$extension;
        }

        $data = $Opportunity->fill($input);
        $data->quote_file = $quote_file_route;
        $result = $data->save();

        //por ultimo enviamos la ubicacion desde el controlador pero fuera de la instruccion de guardado
        $data->quote_file_src = 'http://localhost:8000/storage/'. $data->quote_file;//env('APP_URL')

        if ($result) {
            $success = true;
            $message = 'Opportunity updated successfully.';


            if ($request->has('description')) {
                if ($request->description) {
                    $folio = OpportunityDetail::where('opportunity_id', $Opportunity->id)->max('Folio');
                    $folio ++;
                    $creado = OpportunityDetail::create(
                        [
                            'opportunity_id' => $Opportunity->id,
                            'folio' =>  $folio,
                            'description' =>  $request->description,
                        ]
                    );

                }
            }//if ($request->has('detail..

            $data->crono =  OpportunityDetail::
                where('opportunity_id', $Opportunity->id)
                ->where('active', true)
                ->get();

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Opportunity.';

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
     * @param  Opportunity  $Opportunity
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Opportunity $Opportunity): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $Opportunity->id;
/*
        if ($id) {
            $Opportunity->delete();
            $deleted = Opportunity::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Opportunity deleted successfully.';

                OpportunityCatalogData::where('Opportunity_id', $Opportunity->id)->delete();

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Opportunity.';

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
     * Retrieve Opportunitys with query arguments
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

        $user_id = Auth::id();
        $user = User::find($user_id);

        //$roles = $user->getRoleNames();
        //$permissions = $user->getAllPermissions();
        /*return response()->json([ //debug
            'agent' => $user->hasRole('agent'),
            'administrator' => $user->hasRole('administrator'),

        ]);*/

        $select = [
            'op.id',
            'opd.created_at',
            'corp.name as corporate',
            'cont.name',
            'op.corporate_id',
            'op.contact_id',
            'op.consultant_id',
            'op.quote_file',
            'op.status',
            'op.active',
        ];

        $query = Opportunity::from('opportunities as op')
            ->leftJoin('opportunities_detail as opd', function($join) {
                $join->on('opd.opportunity_id', '=', 'op.id')
                     ->whereRaw('opd.folio = (select max(folio) from opportunities_detail where opportunity_id = op.id)');
            })
            ->leftJoin('contacts as cont', 'cont.id', '=', 'op.contact_id')
            ->leftJoin('corporates as corp', 'corp.id', '=', 'op.corporate_id')
            ->select($select);

        if(!$user->hasRole('administrator')){
            $query->where('op.consultant_id', $user_id);

        }

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('op.active', $request->active);
            }
        }


        //Cuando se realizan busquedas desde el buscador muestra todas las cotizaciones sin importar uqe pageType se este viendo
        if ($request->has('pageType') && $request->q=='' ) {
            switch($request->pageType){
                case 'opened':
                    $query->whereIn('op.status', ['Nuevo', 'Interesado', 'Cotizacion Enviada']);
                    break;
                case 'closed':
                    $query->whereIn('op.status', ['Contratado', 'No Contratado']);
                break;
                case 'discarted':
                    $query->whereIn('op.status', ['Descartado']);
                break;
                default:
                //todas
                break;
            }
        }

        if ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('op.active', 1);
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
                $query->where('op.name', 'like', '%' . $request->q . '%')
                    ->orWhere('cont.paternal', 'like', '%' . $request->q . '%')
                    ->orWhere('cont.maternal', 'like', '%' . $request->q . '%')
                    ->orWhere('corp.name', 'like', '%' . $request->q . '%')
                    //->orWhere('email', 'like', '%' . $request->q . '%')
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
            $message = 'Opportunitys fetched correctly';
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
