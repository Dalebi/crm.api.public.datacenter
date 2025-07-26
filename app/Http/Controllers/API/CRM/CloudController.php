<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Cloud;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CloudController extends Controller
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
        $cloud = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:55',
                'price' => 'required|numeric',
                'id_data_center' => 'required|numeric',
                'active' => 'required|numeric'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $cloud = Cloud::create([
                'name' => $request->name,
                'price' => $request->price,
                'id_data_center' => $request->id_data_center,
                'active' => $request->active,
            ]);

            if ($cloud) {
                $success = true;
                $message = 'Cloud created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new Cloud.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $cloud,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cloud $cloud)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($cloud) {
            $success = true;
            $message = 'Cloud founded successfully';
            $data = $cloud;
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
    public function edit(Cloud $cloud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cloud $cloud)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $cloud->fill($input)->save();

        if ($data) {
            if ($request->has('prices')) {
                if ($request->prices) {
                    $where = [
                        'id_service' => $request->id,
                        'table' => 'clouds'
                    ];

                    Price::where($where)
                        ->delete();

                    foreach ($request->prices as $price) {
                        Price::create(
                            [
                                'table' => 'clouds',
                                'id_service' => $request->id,
                                'label' => $price['label'],
                                'price' => $price['price']
                            ]
                        );
                    }
                }
            }

            $success = true;
            $message = 'Cloud updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Cloud.';

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
    public function destroy(Cloud $cloud)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $cloud->id;

        if ($id) {
            $cloud->delete();
            $deleted = Cloud::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Cloud deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Cloud.';

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
     * Retrieve Clouds with query arguments
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
            'clouds.id',
            'clouds.key',
            'clouds.name',
            'clouds.unit',
            'clouds.included',
            'clouds.id_data_center',
            'clouds.active',
            'data_centers.prefix AS dc'
        ];

        $query = Cloud::select($select)
            ->leftJoin('data_centers', 'data_centers.id', 'clouds.id_data_center');

        if ($request->has('active')) {
            if ($request->active === 0 || $request->active === 1) {
                $query->where('active', $request->active);
            }
        }

        if ($request->has('includeInactive')) {
            if ($request->includeInactive == 0) {
                $query->where('active', 1);
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
                $query->where('name', 'like', '%' . $request->q . '%');
            }
        }

        if ($request->has('id_data_center')) {
            if ($request->id_data_center) {
                $query->where('clouds.id_data_center', $request->id_data_center);
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
                            'table' => 'clouds'
                        ];

                        $result->prices = Price::select($select)
                            ->where($where)
                            ->get();
                    }
                }
            }

            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Clouds fetched correctly';
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
