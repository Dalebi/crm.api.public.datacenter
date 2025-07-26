<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\DataCenter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class DataCenterController extends Controller
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
        $dataCenter = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:200',
                'prefix' => 'required|string|max:200',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $dataCenter = DataCenter::create([
                'name' => $request->dataCenter,
                'prefix' => $request->description,
                'information' => $request->active,
            ]);

            if ($dataCenter) {
                $success = true;
                $message = 'DC created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new DC.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $dataCenter,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DataCenter $dataCenter)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($dataCenter) {
            $success = true;
            $message = 'DataCenter founded successfully';
            $data = $dataCenter;
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
    public function edit(DataCenter $dataCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataCenter $dataCenter)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $dataCenter->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'DataCenter updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating DataCenter.';

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
    public function destroy(DataCenter $dataCenter)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $dataCenter->id;

        if ($id) {
            $dataCenter->delete();
            $deleted = DataCenter::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'DC deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting DataCenter.';

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
     * Retrieve DataCenters with query arguments
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

        $select = ['id', 'name', 'prefix', 'information'];

        $query = DataCenter::select($select);

        if ($request->has('sortBy')) {
            if ($request->sortBy) {
                foreach ($request->sortBy as $groupBy) {
                    $query->orderBy($groupBy['key'], $groupBy['order']);
                }
            }
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('prefix', 'like', '%' . $request->q . '%')
                    ->orWhere('information', 'like', '%' . $request->q . '%');
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
            $message = 'DC fetched correctly';
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
