<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\PublicPort;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PublicPortController extends Controller
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
        $publicPort = null;

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

            $publicPort = PublicPort::create([
                'name' => $request->name,
                'price' => $request->price,
                'id_data_center' => $request->id_data_center,
                'active' => $request->active,
            ]);

            if ($publicPort) {
                $success = true;
                $message = 'PublicPort created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new PublicPort.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $publicPort,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PublicPort $publicPort)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($publicPort) {
            $success = true;
            $message = 'PublicPort founded successfully';
            $data = $publicPort;
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
    public function edit(PublicPort $publicPort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublicPort $publicPort)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $publicPort->fill($input)->save();

        if ($data) {
            if ($request->has('prices')) {
                if ($request->prices) {
                    $where = [
                        'id_service' => $request->id,
                        'table' => 'public_ports'
                    ];

                    Price::where($where)
                        ->delete();

                    foreach ($request->prices as $price) {
                        Price::create(
                            [
                                'table' => 'public_ports',
                                'id_service' => $request->id,
                                'label' => $price['label'],
                                'price' => $price['price']
                            ]
                        );
                    }
                }
            }

            $success = true;
            $message = 'PublicPort updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating PublicPort.';

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
    public function destroy(PublicPort $publicPort)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $publicPort->id;

        if ($id) {
            $publicPort->delete();
            $deleted = PublicPort::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'PublicPort deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting PublicPort.';

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
     * Retrieve PublicPorts with query arguments
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
            'public_ports.id',
            'public_ports.name',
            'public_ports.price',
            'public_ports.id_data_center',
            'public_ports.active',
            'data_centers.prefix AS dc'
        ];

        $query = PublicPort::select($select)
            ->leftJoin('data_centers', 'data_centers.id', 'public_ports.id_data_center');

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
                $query->where('public_ports.id_data_center', $request->id_data_center);
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
                            'table' => 'public_ports'
                        ];

                        $result->prices = Price::select($select)
                            ->where($where)
                            ->get();
                    }
                }
            }

            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'PublicPorts fetched correctly';
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
