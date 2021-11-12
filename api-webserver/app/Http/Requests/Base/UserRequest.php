<?php

namespace App\Http\Requests\Base;

use App\Http\Requests\Website\WebsiteRequest;
use Illuminate\Validation\Rule;

class UserRequest extends WebsiteRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $id = $this->route()->parameter('manage_user');
        if ($id > 0) {
            //Update
            $rules['first_name'] = ['required', 'max:255'];
            $rules['last_name'] = ['required', 'max:255'];
            $rules['username'] = ['required', Rule::unique('users')->ignore($id), 'max:255'];
            $rules['email'] = ['required', Rule::unique('users')->ignore($id), 'max:255', 'email:rfc,dns,spoof',];
            $rules['roles'] = ['required', 'array',];
            $rules['roles.*'] = ['required', 'integer',];

        } else {
            $rules['first_name'] = ['required', 'max:255'];
            $rules['last_name'] = ['required', 'max:255'];
            $rules['username'] = ['required', 'unique:users', 'max:255'];
            $rules['email'] = ['required', 'unique:users', 'max:255', 'email:rfc,dns,spoof',];
            $rules['roles'] = ['required', 'array',];
            $rules['password'] = ['required',];
            $rules['roles.*'] = ['required', 'integer',];
        }
        return $rules;
    }

}
