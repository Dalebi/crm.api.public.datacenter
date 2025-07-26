<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\TypeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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
     */
    public function store(Request $request)
    {
        $message = '';
        $success = false;
        $service = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:55',
                'id_data_center' => 'required|numeric',
                'id_type_service' => 'required|numeric',
                'type_id' => 'required|numeric',
                'active' =>  'required|numeric'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $service = Service::create([
                'name' => $request->service,
                'id_data_center' => $request->id_data_center,
                'id_type_service' => $request->id_type_service,
                'type_id' => $request->type_id,
                'active' => $request->active
            ]);

            if ($service) {
                $success = true;
                $message = 'Service created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new Service.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $service,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($service) {
            $success = true;
            $message = 'Service founded successfully';
            $data = $service;
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
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $service->fill($input)->save();

        if ($data) {
            if ($request->has('features')) {
                if ($request->features) {
                    ServiceFeature::where('id_service', $request->id)
                        ->delete();

                    foreach ($request->features as $feature) {
                        ServiceFeature::create(
                            [
                                'name' => $feature['name'],
                                'id_service' => $request->id
                            ]
                        );
                    }
                }
            }

            if ($request->has('prices')) {
                if ($request->prices) {
                    Price::where('id_service', $request->id)
                        ->delete();

                    foreach ($request->prices as $price) {
                        Price::create(
                            [
                                'table' => $price['table'],
                                'id_service' => $request->id,
                                'label' => $price['label'],
                                'price' => $price['price']
                            ]
                        );
                    }
                }
            }

            $success = true;
            $message = 'Service updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Service.';

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
     */
    public function destroy(Service $service)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $service->id;

        if ($id) {
            $service->delete();
            $deleted = Service::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Service deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Service.';

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
     * Retrieve Services with query arguments
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
            'services.id',
            'services.name',
            'services.id_type_service',
            'services.id_data_center',
            'services.active',
            'data_centers.prefix AS dc',
            'type_services.name AS service'
        ];

        $query = Service::select($select)
            ->leftJoin('data_centers', 'data_centers.id', 'services.id_data_center')
            ->leftJoin('type_services', 'type_services.id', 'services.id_type_service');

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('services.active', $request->active);
            }
        } elseif ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('services.active', 1);
            }
        }

        if ($request->has('id_type_service')) {
            if ($request->id_type_service) {
                $query->where('services.id_type_service', $request->id_type_service);
            }
        }

        if ($request->has('id_data_center')) {
            if ($request->id_data_center) {
                $query->where('services.id_data_center', $request->id_data_center);
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
                $query->where('services.name', 'like', '%' . $request->q . '%')
                    ->orWhere('type_services.name', 'like', '%' . $request->q . '%');
            }
        }

        $totalResults = $query->count();

        if ($perPage > -1) {
            $query->skip($skip)->take($perPage);
        }

        $filteredResults = $query->get();

        if ($filteredResults) {
            if ($request->has('features')) {
                if ($request->features) {
                    foreach ($filteredResults as $result) {
                        $select = [
                            'id',
                            'id_service',
                            'name'
                        ];
                        $result->features = ServiceFeature::select($select)->where('id_service', $result->id)->get();
                    }
                }
            }

            if ($request->has('prices')) {
                if ($request->prices) {
                    foreach ($filteredResults as $result) {
                        $select = [
                            'id',
                            'table',
                            'id_service',
                            'label',
                            'price'
                        ];
                        $result->prices = Price::select($select)
                            ->where('id_service', $result->id)
                            ->get();
                    }
                }
            }

            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Services fetched correctly';
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
     * Retrieve Addons Services
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function services(Request $request): JsonResponse
    {
        $success = false;
        $message = '';

        $skip = $request->currentPage ? ($request->currentPage - 1) * $request->perPage : 0;
        $perPage = $request->perPage ? $request->perPage : 10;
        $totalPage = 0;
        $totalResults = 0;

        $select = ['id', 'name'];

        $query = TypeService::select($select);

        if ($request->has('sortBy')) {
            if ($request->sortBy) {
                foreach ($request->sortBy as $groupBy) {
                    $query->orderBy($groupBy['key'], $groupBy['order']);
                }
            }
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('name', 'like', '%' . $request->q . '%');
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
            $message = 'Addons Services fetched correctly';
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
     * Retrieve Addons Type
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function service($id): JsonResponse
    {
        $success = false;
        $message = '';

        $select = ['id', 'name'];

        $type = TypeService::select($select)
            ->where('id', $id)
            ->first();

        if ($type) {
            $success = true;
            $message = 'Type retrived successfully';
        }

        return response()->json([
            'data' => $type,
            'success' => $success,
            'message' => $message,
        ]);
    }
}
