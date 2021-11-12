<?php

namespace App\Http\Controllers\Api\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\UserRequest;
use App\Models\Permission\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class UserController extends Controller
{


    /**
     * Display a listing of users
     *
     * @return array
     */
    public function index(): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('users-manage/list')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        return [
            "success" => true,
            "message" => "",
            "data" => User::getCollectionsStandardColumns('id', true),
            "info" => [
                "form" => User::standardForm(),
            ],
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(UserRequest $request)
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('users-manage/add')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $instance = new User();


        if (count($request->getValidationError())) {
            return [
                "success" => false,
                "message" => "Validation error",
                "validation" => $request->getValidationError(),
            ];
        }

        $fill = $instance->fillable;
        $request_filled = $request->only($fill);

        $request_filled['password'] = Hash::make($request_filled['password']);


        $instance->updateStandardColumns($request_filled);

        $roles = $request->json()->get('roles');
        $roles_name = [];
        if (is_array($roles)) {
            $roles_name = Role::select('name')->whereIn('id', $roles)->get()->toArray();
        }
        $instance->syncRoles($roles_name);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => User::standardForm(),
                "relation_list" => User::standardRelationList(),
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
        if (!$auth_user->hasPermissionTo('users-manage/view')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = User::find($id);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => User::standardForm(),
                "relation_list" => User::standardRelationList(),
            ]
        ];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param int $id
     * @return array
     */
    public function update(UserRequest $request, int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('users-manage/update')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $instance = User::find($id);

        if (!is_null($instance)) {
            if (count($request->getValidationError())) {
                return [
                    "success" => false,
                    "message" => "Validation error",
                    "validation" => $request->getValidationError(),
                ];
            }


            $fill = $instance->fillable;
            $request_filled = $request->only($fill);

            if (!strlen($request->json()->get('password'))) {
                unset($request_filled['password']);
            } else {
                $request_filled['password'] = Hash::make($request_filled['password']);
            }


            $instance->updateStandardColumns($request_filled);

            $roles = $request->json()->get('roles');
            $roles_name = [];
            if (is_array($roles)) {
                $roles_name = Role::select('name')->whereIn('id', $roles)->get()->toArray();
            }
            $instance->syncRoles($roles_name);

            return [
                "success" => true,
                "message" => "",
                "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
                "info" => [
                    "form" => User::standardForm(),
                    "relation_list" => User::standardRelationList(),
                ]
            ];

        } else {
            return [
                "success" => false,
                "message" => "Invalid User",
            ];
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('users-manage/delete')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = User::find($id);
        $deleted = $instance->delete();
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
