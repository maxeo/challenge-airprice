<?php

namespace App\Http\Requests\Base;

use App\Http\Requests\Website\WebsiteRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends WebsiteRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $id = $this->route()->parameter('manage_permission');
        if ($id > 0) {
            //Update
            $rules['name'] = ['required', Rule::unique('permissions')->ignore($id), 'max:255'];

        } else {
            $rules['name'] = ['required', 'unique:permissions', 'max:255'];
        }
        return $rules;
    }


}
