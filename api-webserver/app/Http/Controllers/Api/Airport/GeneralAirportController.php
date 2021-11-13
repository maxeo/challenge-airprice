<?php

namespace App\Http\Controllers\Api\Airport;


use App\Models\Airport\Airport;
use App\Models\Airport\AirStat;
use App\Models\Airport\Flight;
use App\Models\Website\WebsiteUtility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;


class GeneralAirportController extends Controller
{


    /**
     * @return Collection
     */
    public function getAirportList(): Collection
    {
        return Airport::orderBy('name')->select(['name', 'code'])->get();
    }


    /**
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['success' => "bool", 'data' => "array", 'error' => "string"])]
    public function checkFlights(Request $request): array
    {
        $code_departure = $request->get('code_departure');
        $code_arrival = $request->get('code_arrival');

        $list = Flight::getBetterFlightsList($code_departure, $code_arrival);
        AirStat::incrementCounter('search_counter');

        return [
            'success' => (bool)count($list),
            'data' => $list->toArray(),
            'error' => count($list) ? '' : 'No flights for selected airport',
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['success' => "bool", 'error' => "string"])]
    public function bookFlight(): array
    {
        AirStat::incrementCounter('book_counter');

        return [
            'success' => true,
            'error' => '',
        ];
    }


    /**
     * @return array
     */
    public function getDashboard(): array
    {
        $auth_user = Auth::user();
        if (!$auth_user->hasPermissionTo('dashboard/view')) {
            return [
                'success' => false,
                'error' => 'Insufficient permission',
            ];
        }
        return [
            'success' => true,
            'error' => '',
            'data' => WebsiteUtility::getDashboardData(),
        ];
    }
}
