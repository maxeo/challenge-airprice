<?php

namespace App\Http\Controllers\Api\Base;

use App\Http\Requests\Base\RoleRequest;
use App\Models\Permission\Role;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
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
            "data" => Role::getCollectionsStandardColumns('id', true),
            "info" => [
                "form" => Role::standardForm(),
            ],
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RoleRequest $request)
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/add')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $role = new Role();


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
                "form" => Role::standardForm(),
                "relation_list" => Role::standardRelationList(),
            ]
        ];


    }

    /**
     * Display the specified user.
     *
     * @param int $role_id
     * @return array
     */
    public function show(int $role_id): array
    {
        $auth_user = Auth::user();
        if (!$auth_user->hasPermissionTo('roles-manage/view')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $role = Role::find($role_id);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($role) ? $role->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Role::standardForm(),
                "relation_list" => Role::standardRelationList(),
            ]
        ];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param int $id
     * @return array
     */
    public function update(RoleRequest $request, int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/update')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $instance = Role::find($id);


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

        $permissions = $request->json()->get('permissions');
        $permissions_name = [];
        if (is_array($permissions)) {
            $permissions_name = Permission::select('name')->whereIn('id', $permissions)->get()->toArray();
        }
        $instance->syncPermissions($permissions_name);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Role::standardForm(),
                "relation_list" => Role::standardRelationList(),
            ]
        ];

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('roles-manage/delete')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $user = Role::find($id);
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
