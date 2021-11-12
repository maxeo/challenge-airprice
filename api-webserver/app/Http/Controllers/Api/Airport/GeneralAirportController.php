<?php

namespace App\Http\Controllers\Api\Airport;


use App\Models\Airport\Airport;
use App\Models\Airport\AirStat;
use App\Models\Airport\Flight;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;


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
     */
    public function checkFlights(Request $request)
    {
        $code_departure = $request->get('code_departure');
        $code_arrival = $request->get('code_arrival');

        $list = Flight::getBetterFlightsList($code_departure, $code_arrival);
        AirStat::incrementCounter('search_counter');

        return [
            'success' => (bool)count($list),
            'data' => $list,
            'error' => count($list) ? '' : 'No flights for selected airport',
        ];
    }
}
