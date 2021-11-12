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

        $id = $this->route()->parameter('paper');
        if ($id > 0) {
            //Update
            $rules['name'] = ['required', Rule::unique('papers')->ignore($id), 'max:255'];
            $rules['cost_mq'] = ['required', 'numeric'];

        } else {
            $rules['name'] = ['required', 'unique:papers', 'max:255'];
            $rules['cost_mq'] = ['required', 'numeric'];
        }
        return $rules;
    }


}
