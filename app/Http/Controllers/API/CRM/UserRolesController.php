<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserRolesController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $message = 'Welcome to User Roles API.';
        $success = true;
        $data = [];

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ]
        );
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
        $data = [];

        $data = Role::create(['name' => $request->role]);

        if ($data) {
            $message = 'User Role created successfully.';
            $success = true;
        } else {
            $message = 'Unexpected error.';
            $success = false;
        }

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $data = Role::find($id);

        if (is_null($data)) {
            $success = false;
            $message = 'User Role not found.';
        } else {
            $success = true;
            $message = 'User Role retrieved successfully.';
        }

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $userRole): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        //TODO - Sync with Permissions
        if ($data) {
            $success = true;
            $message = 'User Role updated successfully.';
        } else {
            $success = false;
            $message = 'Unexpetedd error.';
        }

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $success =  true;
        $message = '';
        $data = [];

        //TODO - Sync with Permissions

        /*
        if ($userProfile) {
            $userProfile->delete();
            $success = true;
            $message = 'User Profile deleted successfully.';
        } else {
            $success = false;
            $message = 'User Profile not founded.';
        }*/

        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $data
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $includeInactive
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(): JsonResponse
    {
        $success =  false;
        $message = '';
        $data = Role::all();

        if ($data) {
            $success = true;
            $message = 'User Role retrieved successfully.';
        } else {
            $success = true;
            $message = 'User Role not founded.';
        }

        return response()->json([
            'data' => $data,
            'success' => $success,
            'message' => $message
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function authUserRoles(): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id_user = Auth::id();

        $user = User::find($id_user);

        $data['user'] = $user;
        $data['roles'] = $user->getRoleNames();
        $data['permissions'] = $user->getAllPermissions();
        $success = true;
        $message = 'Roles de usuario autenticado recuperados exitosamente.';

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

}
