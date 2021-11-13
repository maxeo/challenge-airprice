<?php

namespace App\Http\Requests\Airport;

use App\Http\Requests\Website\WebsiteRequest;

class FlightRequest extends WebsiteRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $rules['departure'] = ['required', 'max:255'];
        $rules['arrival'] = ['required', 'max:255'];
        $rules['price'] = ['required', 'numeric'];

        return $rules;
    }


}
