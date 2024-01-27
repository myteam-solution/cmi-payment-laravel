<?php

namespace Soluzi\CMI\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'storekey' => 'required|string',
            'clientid' => 'required|string',
            'storetype' => 'required|string',
            'trantype' => 'required|string',
            'amount' => 'required|string',
            'currency' => 'required|string',
            'oid' => 'required|string',
            'okUrl' => 'required|string|url',
            'failUrl' => 'required|string|url',
            'lang' => 'required|string|in:fr,ar,en',
            'email' => 'required|string|email',
            'BillToName' => 'required|string',
            'hashAlgorithm' => 'required|string',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'storekey.required' => 'storekey is required',
            'storekey.string' => 'storekey must be a string',

            'clientid.required' => 'clientid is required',
            'clientid.string' => 'clientid must be a string',

            'storetype.required' => 'storetype is required',
            'storetype.string' => 'storetype must be a string',

            'trantype.required' => 'trantype is required',
            'trantype.string' => 'trantype must be a string',

            'amount.required' => 'amount is required',
            'amount.string' => 'amount must be a string',

            'currency.required' => 'currency is required',
            'currency.string' => 'currency must be a string',

            'oid.required' => 'oid is required',
            'oid.string' => 'oid must be a string',

            'okUrl.required' => 'okUrl is required',
            'okUrl.string' => 'okUrl must be a string',
            'okUrl.url' => 'okUrl must be a valid URL',

            'failUrl.required' => 'failUrl is required',
            'failUrl.string' => 'failUrl must be a string',
            'failUrl.url' => 'failUrl must be a valid URL',

            'lang.required' => 'lang is required',
            'lang.string' => 'lang must be a string',
            'lang.in' => 'you should choose between fr, ar, or en',

            'email.required' => 'email is required',
            'email.string' => 'email must be a string',
            'email.email' => 'Invalid email format',

            'BillToName.required' => 'BillToName is required',
            'BillToName.string' => 'BillToName must be a string',

            'hashAlgorithm.required' => 'hashAlgorithm is required',
            'hashAlgorithm.string' => 'hashAlgorithm must be a string',
        ];
    }
}
