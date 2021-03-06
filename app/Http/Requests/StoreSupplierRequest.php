<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Auth\Access\AuthorizationException;

class StoreSupplierRequest extends FormRequest
{
    protected function failedAuthorization()
    {
        throw new AuthorizationException(trans('app.unauthorized'));
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('edit suppliers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company' => 'required_without:name|string|max:255',
            'name' => 'required_without:company|string|max:255',
            'state_id' => 'nullable|integer',
            'address' => 'required',
            'address2' => 'max:255',
            'city' => 'required|required',
            'zip_code' => 'required|numeric',
            'gstin' => 'required_without:name|string',
            'contact_person' => 'required|string',
            'phone' => 'required|string',
            'phone2' => 'nullable|string',
            'currency' => 'required|string|max:3',
            'country' => 'required|string',
            'credit_period' => 'required',
            'email' => 'required|email|unique:suppliers,email,'.$this->id
        ];
    }
}
