<?php

namespace App\Http\Requests\Airport;

use App\Http\Requests\Website\WebsiteRequest;
use Illuminate\Validation\Rule;

class AirportRequest extends WebsiteRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $id = $this->route()->parameter('airport');
        if ($id > 0) {
            //Update
            $rules['name'] = ['required', Rule::unique('airports')->ignore($id), 'max:255'];
            $rules['code'] = ['required', Rule::unique('airports')->ignore($id), 'max:255'];
            $rules['lat'] = ['required', 'numeric', 'max:255'];
            $rules['lng'] = ['required', 'numeric', 'max:255'];

        } else {
            $rules['name'] = ['required', 'unique:airports', 'max:255'];
            $rules['code'] = ['required', 'unique:airports', 'max:255'];
            $rules['lat'] = ['required', 'numeric', 'max:255'];
            $rules['lng'] = ['required', 'numeric', 'max:255'];
        }
        return $rules;
    }


}
