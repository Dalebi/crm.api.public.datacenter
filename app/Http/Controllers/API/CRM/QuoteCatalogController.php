<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\QuoteCatalog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class QuoteCatalogController extends Controller
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
        $quoteCatalog = null;

        $validator = Validator::make(
            $request->all(),
            [
                'label' => 'required|string|max:255',
                'order' => 'required|numeric|min:1|max:100',
                'active' => 'required|boolean'
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $quoteCatalog = QuoteCatalog::create([
                'label' => $request->label,
                'description' => $request->description,
                'order' => $request->order,
                'color' => $request->color,
                'active' => $request->active,
            ]);

            if ($quoteCatalog) {
                $success = true;
                $message = 'Quote Catalog created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new item.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $quoteCatalog,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(QuoteCatalog $quoteCatalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuoteCatalog $quoteCatalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote $quoteCatalog
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, QuoteCatalog $quoteCatalog): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $quoteCatalog->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'Quote Catalog updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating item.';

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
     * @param  Quote  $quoteCatalog
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(QuoteCatalog $quoteCatalog): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $quoteCatalog->id;

        if ($id) {
            $quoteCatalog->delete();
            $deleted = QuoteCatalog::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Item deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting item.';

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

        $select = ['id', 'label', 'description', 'order', 'color', 'active'];

        $query = QuoteCatalog::select($select);

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
            } else {
                $query->orderBy('order', 'ASC');
            }
        } else {
            $query->orderBy('order', 'ASC');
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('label', 'like', '%' . $request->q . '%');
                $query->orWhere('description', 'like', '%' . $request->q . '%');
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
            $message = 'Quote Catalog fetched correctly';
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
