<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
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
        $country = null;

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:55',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;

            activity()->log($message);
        } else {

            $country = Country::create([
                'name' => $request->name,
            ]);

            if ($country) {
                $success = true;
                $message = 'Country created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error creating new Country.';

                activity()->log($message);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $country,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        $success = 0;
        $message = '';
        $data = null;

        if ($country) {
            $success = true;
            $message = 'Country founded successfully';
            $data = $country;
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
    public function edit(Country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $country->fill($input)->save();

        if ($data) {
            $success = true;
            $message = 'Country updated successfully.';

            activity()->log($message);
        } else {
            $success = false;
            $message = 'Unexpected error updating Country.';

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
    public function destroy(Country $country)
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $country->id;

        if ($id) {
            $country->delete();
            $deleted = Country::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'Country deleted successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error deleting Country.';

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
     * Retrieve Countrys with query arguments
     *
     * @paCountry  \Illuminate\Http\Request  $request
     * @paCountry  int  $q
     * @paCountry  int  $perPage
     * @paCountry  int  $currentPage
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

        $select = ['id', 'name', 'active'];

        $query = Country::select($select);

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
            $totalPage = ceil($totalResults / $perPage) ? ceil($totalResults / $perPage) : 1;

            $success = true;
            $message = 'Countrys fetched correctly';
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
