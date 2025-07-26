<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\AddonService;
use App\Models\AddonType;
use App\Models\Price;
use App\Models\TypeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AddonController extends Controller
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
        $addon = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:55',
                'price_monthly' => 'required|numeric',
                'price_annual' => 'required|numeric',
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

            $addon = Addon::create([
                'name' => $request->addon,
                'price_monthly' => $request->price_monthly,
                'price_annual' => $request->price_annual,
                'id_data_center' => $request->id_data_center,
                'id_type_service' => $request->id_type_service,
                'type_id' => $request->type_id,
                'active' => $request->active
            ]);

            if ($addon) {
                $success = true;
                $message = 'Addon created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new Addon.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $addon,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Addon $addon)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($addon) {
            $success = true;
            $message = 'Addon founded successfully';
            $data = $addon;
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
    public function edit(Addon $addon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addon $addon)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $addon->fill($input)->save();

        if ($data) {
            if ($request->has('prices')) {
                if ($request->prices) {
                    $where = [
                        'id_service' => $request->id,
                        'table' => 'addons'
                    ];

                    Price::where($where)
                        ->delete();

                    foreach ($request->prices as $price) {
                        Price::create(
                            [
                                'table' => 'addons',
                                'id_service' => $request->id,
                                'label' => $price['label'],
                                'price' => $price['price']
                            ]
                        );
                    }
                }
            }

            $success = true;
            $message = 'Addon updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Addon.';

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
    public function destroy(Addon $addon)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $addon->id;

        if ($id) {
            $addon->delete();
            $deleted = Addon::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Addon deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Addon.';

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
     * Retrieve Addons with query arguments
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
            'addons.id',
            'addons.name',
            'addons.id_data_center',
            'addons.id_type_service',
            'addons.type_id',
            'addons.active',
            'data_centers.prefix AS dc',
            'addon_types.name AS type',
            'type_services.name AS service'
        ];

        $query = Addon::select($select)
            ->leftJoin('data_centers', 'data_centers.id', 'addons.id_data_center')
            ->leftJoin('addon_types', 'addon_types.id', 'addons.type_id')
            ->leftJoin('type_services', 'type_services.id', 'addons.id_type_service');

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('addons.active', $request->active);
            }
        }

        if ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('addons.active', 1);
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
                $query->where('addons.name', 'like', '%' . $request->q . '%')
                    ->orWhere('addon_types.name', 'like', '%' . $request->q . '%')
                    ->orWhere('type_services.name', 'like', '%' . $request->q . '%');
            }
        }

        if ($request->has('id_type_service')) {
            if ($request->id_type_service) {
                $query->where('addons.id_type_service', $request->id_type_service);
            }
        }

        if ($request->has('id_data_center')) {
            if ($request->id_data_center) {
                $query->where('addons.id_data_center', $request->id_data_center);
            }
        }

        $totalResults = $query->count();

        if ($perPage > -1) {
            $query->skip($skip)->take($perPage);
        }

        $filteredResults = $query->get();

        if ($filteredResults) {
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

                        $where = [
                            'id_service' => $result->id,
                            'table' => 'addons'
                        ];

                        $result->prices = Price::select($select)
                            ->where($where)
                            ->get();
                    }
                }
            }

            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Addons fetched correctly';
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
     * Retrieve Addons Types
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function types(Request $request): JsonResponse
    {
        $success = false;
        $message = '';

        $skip = $request->currentPage ? ($request->currentPage - 1) * $request->perPage : 0;
        $perPage = $request->perPage ? $request->perPage : 10;
        $totalPage = 0;
        $totalResults = 0;

        $select = ['id', 'key', 'name'];

        $query = AddonType::select($select);

        if ($request->has('sortBy')) {
            if ($request->sortBy) {
                foreach ($request->sortBy as $groupBy) {
                    $query->orderBy($groupBy['key'], $groupBy['order']);
                }
            }
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('key', 'like', '%' . $request->q . '%')
                    ->orWhere('name', 'like', '%' . $request->q . '%');
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
            $message = 'Addons Types fetched correctly';
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
    public function type($id): JsonResponse
    {
        $success = false;
        $message = '';

        $select = ['id', 'key', 'name'];

        $type = AddonType::select($select)
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
