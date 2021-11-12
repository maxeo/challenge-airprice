<?php

namespace App\Http\Requests\Website;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class WebsiteRequest extends FormRequest
{
    private array $validation_error = [];

    /**
     * @return array
     */
    public function getValidationError(): array
    {
        return $this->validation_error;
    }

    protected function failedValidation(Validator $validator): bool
    {
        $errors = $validator->errors()->toArray();
        $messages = $this->messages();

        foreach ($errors as $el => $el_errors) {
            foreach ($el_errors as $k => $v) {
                $errors[$el][$k] = $messages[$v] ?? $v;
            }
        }
        $this->validation_error = $errors;
        return true;

        //throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function messages()
    {
        return [
            'validation.email' => 'Email non valida',
            'validation.required' => 'Campo obbligatorio',
            'validation.max.string' => 'Il numero di caratteri supera il limite massimo',
            'validation.array' => 'Il tipo di dato non è valido per il campo',
            'validation.unique' => 'Il valore è già stato usato. Il campo deve essere unico',
            'validation.numeric' => 'Il valore deve essere un numero',
            'validation.integer' => 'Il valore deve essere un numero intero',
        ];
    }

}
