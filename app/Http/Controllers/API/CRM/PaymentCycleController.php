<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\PaymentCycle;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PaymentCycleController extends Controller
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
        $paymentCycle = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:55',
                'charge' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $paymentCycle = PaymentCycle::create([
                'name' => $request->name,
                'charge' => $request->charge,
            ]);

            if ($paymentCycle) {
                $success = true;
                $message = 'PaymentCycle created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new PaymentCycle.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $paymentCycle,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentCycle $paymentCycle)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($paymentCycle) {
            $success = true;
            $message = 'PaymentCycle founded successfully';
            $data = $paymentCycle;
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
    public function edit(PaymentCycle $paymentCycle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentCycle $paymentCycle)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $paymentCycle->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'PaymentCycle updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating PaymentCycle.';

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
    public function destroy(PaymentCycle $paymentCycle)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $paymentCycle->id;

        if ($id) {
            $paymentCycle->delete();
            $deleted = PaymentCycle::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'PaymentCycle deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting PaymentCycle.';

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
     * Retrieve PaymentCycles with query arguments
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

        $select = ['id', 'name', 'charge'];

        $query = PaymentCycle::select($select);

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
                $query->where('name', 'like', '%' . $request->q . '%')
                    ->orWwhere('charge', 'like', '%' . $request->q . '%');
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
            $message = 'PaymentCycles fetched correctly';
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
