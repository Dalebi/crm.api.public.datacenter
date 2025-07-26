<?php

namespace App\Http\Controllers\API\CRM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $message = 'Welcome to Users API.';
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

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors();
            $success  = false;
        } else {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'active' => $request->active,
                'position' => $request->position,
            ]);

            if ($user) {
                if ($request->has('roles')) {
                    $roleIds = [];
                    foreach ($request->roles as $role) {
                        $roleIds[] = $role['id'];
                    }
                    $user->syncRoles($roleIds);
                }

                $success = true;
                $message = 'User created successfully.';

                activity()->log($message);
            } else {
                $success = false;
                $message = 'Unexpected error.';
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $user,
        ]);
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

        $user = User::find($id);

        if (is_null($user)) {
            $success = false;
            $message = 'User not found.';
        } else {
            $data['user'] = $user;
            $data['roles'] = $user->getRoleNames();
            $data['permissions'] = $user->getAllPermissions();
            $success = true;
            $message = 'User retrieved successfully.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  use App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $input = $request->all();

        $data = $user->fill($input)->save();

        if ($data) {
            if ($request->has('roles')) {
                $roleIds = [];
                foreach ($request->roles as $role) {
                    $roleIds[] = $role['id'];
                }
                $user->syncRoles($roleIds);
            }
            $success = true;
            $message = 'User updated successfully.';
        } else {
            $success = false;
            $message = 'Unexpetedd error.';
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
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $message = '';
        $success = false;
        $data = [];

        $id = $user->id;

        if ($id) {
            $user->delete();
            $deleted = User::find($id);
            if (!$deleted) {
                $success = true;
                $message = 'User deleted successfully.';
            } else {
                $success = false;
                $message = 'Unexpected error.';
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $q
     * @param  int  $role
     * @param  int  $status / $active
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  int  $includeInactive
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function query(Request $request): JsonResponse
    {
        $success = false;
        $message =  '';

        $skip = $request->currentPage ? ($request->currentPage - 1) * $request->perPage : 0;
        $perPage = $request->perPage;
        $totalPage = 0;
        $totalUsers = 0;

        $query = User::select('users.id', 'users.name', 'users.email', 'users.position', 'users.active', 'users.image');

        if ($request->has('userId')) {
            if ($request->userId) {
                $query->where('users.id', $request->userId);
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
                    ->orWhere('email', 'like', '%' . $request->q . '%')
                    ->orWhere('id', 'like', '%' . $request->q . '%')
                    ->orWhere('position', 'like', '%' . $request->q . '%');
            }
        }

        if ($request->has('active')) {
            if ($request->active > -1) {
                $query->where('users.active', $request->active);
            }
        }

        if ($request->has('roles')) {
            if (!empty($request->roles)) {
                $query->role($request->roles);
            }
        }

        $totalUsers = $query->count();

        if ($perPage > 0) {
            $query->skip($skip)->take($perPage);
        }

        $filteredUsers = $query->get();

        if ($filteredUsers) {

            foreach ($filteredUsers as $user) {
                $user->roles = $user->getRoleNames();
            }

            $totalPage = ceil($totalUsers / $perPage) ? ceil($totalUsers / $perPage) : 1;

            $success = true;
            $message = 'Users fetched correctly';
        }

        return response()->json([
            'data' => $filteredUsers,
            'totalPage' => $totalPage,
            'totalUsers' => $totalUsers,
            'success' => $success,
            'message' => $message,
            'sortBy' => $request->sortBy
        ]);
    }

    /**
     * Upload image for user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $message = '';
        $success = false;
        $user = null;

        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        ]);

        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $request->file('file')->storeAs('users', $file_name, 'open');

            User::where('id', $request->id)->update(['image' => $file_name]);

            $user = User::find($request->id);
            $message = 'Image uploaded correctly';
            $success = true;
        } else {
            $message = 'Unable to uploaded image';
            $success = false;
        }

        return response()->json(
            [
                'data' => $user,
                'message' => $message,
                'success' => $success
            ]
        );
    }

    /**
     * Delete image for user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request): JsonResponse
    {
        $success = false;
        $message = '';
        $user = null;

        if ($request->has('id')) {
            User::where('id', $request->id)->update(array('image' => ''));
            $success = true;
            $message = 'Image removed correctly';
            $user = User::find($request->id);
        } else {
            $message = 'Unabled to find the User Image';
        }

        return response()->json(
            [
                'message' => $message,
                'success' => $success,
                'data' => $user
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $includeInactive
     * @return \Illuminate\Http\JsonResponse
     */
    public function forSelect(Request $request): JsonResponse
    {
        $success = false;
        $message = '';
        $data = [];

        $query = null;
        $select = ['users.id AS value', 'users.name AS title'];

        if ($request->has('includeInactive') && $request->includeInactive) {
            $query = User::select($select);
        } else {
            $query = User::select($select)->where('users.active', '=', 1);
        }

        $data = $query->get();

        if ($data) {
            $success = true;
            $message = 'Users retrieved unsuccessfully.';
        } else {
            $success = false;
            $message = 'Unexpected error.';
        }

        return response()->json([
            'message' => $message,
            'success' => $success,
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $q
     * @param  int    $perPage
     * @param  array  $userIds
     * @param  int    $currentPage
     * @return \Illuminate\Http\JsonResponse
     */
    public function logs(Request $request): JsonResponse
    {
        $success = false;
        $message =  '';

        $skip = $request->currentPage ? ($request->currentPage - 1) * $request->perPage : 0;
        $perPage = $request->perPage ? $request->perPage : 10;
        $totalPage = 0;
        $totalLogs = 0;

        $select = [
            'activity_log.id',
            'activity_log.description',
            'users.email',
            'activity_log.created_at AS date'
        ];

        $query = Activity::select($select)
            ->leftJoin('users', 'users.id', 'activity_log.causer_id');

        if ($request->has('users')) {
            if ($request->users) {
                $query->whereIn('users.id', $request->users);
            }
        }

        if ($request->has('sortBy')) {
            if ($request->sortBy) {
                foreach ($request->sortBy as $groupBy) {
                    $query->orderBy($groupBy['key'], $groupBy['order']);
                }
            } else {
                $query->orderBy('activity_log.id', 'DESC');
            }
        } else {
            $query->orderBy('activity_log.id', 'DESC');
        }

        if ($request->has('q')) {
            if ($request->q) {
                $query->where('activity_log.description', 'like', '%' . $request->q . '%')
                    ->orWhere('activity_log.created_at', 'like', '%' . $request->q . '%')
                    ->orWhere('users.email', 'like', '%' . $request->q . '%');
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        $totalLogs = $query->count();

        $query->skip($skip)->take($perPage);

        $filteredLogs = $query->get();

        return response()->json([
            'data' => $filteredLogs,
            'totalPage' => $totalPage,
            'totalLogs' => $totalLogs,
            'success' => $success,
            'message' => $message,
        ]);
    }
}
