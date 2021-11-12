<?php

namespace App\Http\Requests\Base;

use App\Http\Requests\Website\WebsiteRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends WebsiteRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $id = $this->route()->parameter('manage_role');
        if ($id > 0) {
            //Update
            $rules['name'] = ['required', Rule::unique('roles')->ignore($id), 'max:255'];
            $rules['permissions'] = ['required', 'array',];
            $rules['permissions.*'] = ['required', 'integer',];

        } else {
            $rules['name'] = ['required', 'unique:roles', 'max:255'];
            $rules['permissions'] = ['required', 'array',];
            $rules['permissions.*'] = ['required', 'integer',];
        }
        return $rules;
    }
}
