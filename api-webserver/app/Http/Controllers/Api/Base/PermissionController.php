<?php

namespace App\Http\Controllers\Api\Base;

use App\Http\Requests\PermissionRequest;
use App\Models\Permission\Permission;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{

    /**
     * Display a listing of users
     *
     */
    public function index(): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/list')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        return [
            "success" => true,
            "message" => "",
            "data" => Permission::getCollectionsStandardColumns('id', true),
            "info" => [
                "form" => Permission::standardForm(),
            ],
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(PermissionRequest $request)
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/add')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $instance = new Permission();


        if (count($request->getValidationError())) {
            return [
                "success" => false,
                "message" => "Validation error",
                "validation" => $request->getValidationError(),
            ];
        }

        $fill = $instance->fillable;
        $request_filled = $request->only($fill);

        $request_filled['guard_name'] = 'web';


        $instance->updateStandardColumns($request_filled);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Permission::standardForm(),
                "relation_list" => Permission::standardRelationList(),
            ]
        ];


    }

    /**
     * Display the specified user.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $auth_user = Auth::user();
        if (!$auth_user->hasPermissionTo('roles-manage/view')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Permission::find($id);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Permission::standardForm(),
                "relation_list" => Permission::standardRelationList(),
            ]
        ];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param int $id
     * @return array
     */
    public function update(PermissionRequest $request, int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/update')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $role = Permission::find($id);


        if (count($request->getValidationError())) {
            return [
                "success" => false,
                "message" => "Validation error",
                "validation" => $request->getValidationError(),
            ];
        }

        $fill = $role->fillable;
        $request_filled = $request->only($fill);

        $request_filled['guard_name'] = 'web';


        $role->updateStandardColumns($request_filled);

        $permissions = $request->json()->get('permissions');
        $permissions_name = [];
        if (is_array($permissions)) {
            $permissions_name = Permission::select('name')->whereIn('id', $permissions)->get()->toArray();
        }
        $role->syncPermissions($permissions_name);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($role) ? $role->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Permission::standardForm(),
                "relation_list" => Permission::standardRelationList(),
            ]
        ];

    }

    /**
     * Remove the specified resource from storage.
     * @param int $user_id
     * @return array
     */
    public function destroy(int $user_id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/delete')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $user = Permission::find($user_id);
        $deleted = $user->delete();
        if ($deleted) {
            return [
                "success" => true,
                "message" => "",
            ];
        } else {
            return [
                "success" => false,
                "message" => "Unable to delete the record",
            ];
        }

    }
}
