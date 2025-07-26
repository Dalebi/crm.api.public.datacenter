<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\ControlPanel;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ControlPanelController extends Controller
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
        $controlPanel = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:55',
                'price' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $controlPanel = ControlPanel::create([
                'name' => $request->name,
                'price' => $request->price,
            ]);

            if ($controlPanel) {
                $success = true;
                $message = 'ControlPanel created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new ControlPanel.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $controlPanel,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ControlPanel $controlPanel)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($controlPanel) {
            $success = true;
            $message = 'ControlPanel founded successfully';
            $data = $controlPanel;
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
    public function edit(ControlPanel $controlPanel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ControlPanel $controlPanel)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $controlPanel->fill($input)->save();

        if ($data) {
            if ($request->has('prices')) {
                if ($request->prices) {
                    $where = [
                        'id_service', $request->id,
                        'table' => 'control_panels'
                    ];

                    Price::where($where)
                        ->delete();

                    foreach ($request->prices as $price) {
                        Price::create(
                            [
                                'table' => 'control_panels',
                                'id_service' => $request->id,
                                'label' => $price['label'],
                                'price' => $price['price']
                            ]
                        );
                    }
                }
            }

            $success = true;
            $message = 'ControlPanel updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating ControlPanel.';

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
    public function destroy(ControlPanel $controlPanel)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $controlPanel->id;

        if ($id) {
            $controlPanel->delete();
            $deleted = ControlPanel::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'ControlPanel deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting ControlPanel.';

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
     * Retrieve ControlPanels with query arguments
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

        $select = ['id', 'name', 'price'];

        $query = ControlPanel::select($select);

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
                            'table' => 'control_panels'
                        ];

                        $result->prices = Price::select($select)->where($where)->get();
                    }
                }
            }

            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'ControlPanels fetched correctly';
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
