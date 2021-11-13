<?php

namespace App\Http\Controllers\Api\Airport;

use App\Http\Requests\Airport\FlightRequest;
use App\Models\Airport\Flight;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class FlightController extends Controller
{
    /**
     * Display a listing of elements
     *
     * @return array
     */
    public function index(): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('airports/flights-manage/list')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        return [
            "success" => true,
            "message" => "",
            "data" => Flight::getCollectionsStandardColumns('id', true),
            "info" => [
                "form" => Flight::standardForm(),
            ],
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param FlightRequest $request
     * @return array
     */
    public function store(FlightRequest $request): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('airports/flights-manage/add')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }
        $instance = new Flight();


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
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Flight::standardForm(),
                "relation_list" => Flight::standardRelationList(),
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
        if (!$auth_user->hasPermissionTo('airports/flights-manage/view')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Flight::find($id);

        return [
            "success" => true,
            "message" => "",
            "data" => !is_null($instance) ? $instance->getStandardColumns('id', true) : [],
            "info" => [
                "form" => Flight::standardForm(),
                "relation_list" => Flight::standardRelationList(),
            ]
        ];
    }


    /**
     * Update the specified resource in storage.
     *
     * @param FlightRequest $request
     * @param int $id
     * @return array
     */
    public function update(FlightRequest $request, int $id): array
    {
        $auth_user = Auth::user();

        if (!$auth_user->hasPermissionTo('airports/flights-manage/update')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Flight::find($id);

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
                    "form" => Flight::standardForm(),
                    "relation_list" => Flight::standardRelationList(),
                ]
            ];

        } else {
            return [
                "success" => false,
                "message" => "Invalid Element",
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

        if (!$auth_user->hasPermissionTo('airports/flights-manage/delete')) {
            return [
                "success" => false,
                "message" => "Insufficient permission",
            ];
        }

        $instance = Flight::find($id);
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
