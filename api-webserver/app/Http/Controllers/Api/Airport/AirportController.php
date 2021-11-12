<?php

namespace App\Http\Controllers\Api\Airport;


use App\Http\Requests\Airport\AirportRequest;
use App\Models\Airport\Airport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AirportController extends Controller
{
    /**
     * Display a listing of papers
     *
     * @return array
     */
    public function index(): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('preventivi/parameters/list')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        return [
            "success" => true,
            "message" => "",
            "data" => Airport::getCollectionsStandardColumns('id', true),
            "info" => [
                "form" => Airport::standardForm(),
            ],
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param AirportRequest $request
     * @return array
     */
    public function store(AirportRequest $request): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('preventivi/parameters/add')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $istance = new AirportRequest();


        if (count($request->getValidationError())) {
            return [
                "success" => false,
                "message" => "Validation error",
                "validation" => $request->getValidationError(),
            ];
        }

        $fill = $istance->fillable;
        $request_filled = $request->only($fill);

        $istance->updateStandardColumns($request_filled);


        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($istance) ? $istance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Airport::standardForm(),
                "relation_list" => Airport::standardRelationList(),
            ]
        ];


    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $auth_user = Auth::user();
        if (!$auth_user->hasPermissionTo('preventivi/parameters/view')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Airport::find($id);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Airport::standardForm(),
                "relation_list" => Airport::standardRelationList(),
            ]
        ];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AirportRequest $request
     * @param int $id
     * @return array
     */
    public function update(AirportRequest $request, int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('preventivi/parameters/update')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Airport::find($id);

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

            $instance->updateStandardColumns($request_filled);

            return [
                "success" => true,
                "message" => "",
                "data" => $instance->getStandardColumns('id', true),
                "info" => [
                    "form" => Airport::standardForm(),
                    "relation_list" => Airport::standardRelationList(),
                ]
            ];

        } else {
            return [
                "success" => false,
                "message" => "Invalid Paper",
            ];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('preventivi/parameters/delete')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Airport::find($id);
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
