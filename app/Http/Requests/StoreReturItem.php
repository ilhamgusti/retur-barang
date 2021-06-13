<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturItem extends FormRequest
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
            // 'is_valid' => 'required|string|email|max:255|unique:users',
            'keterangan' => 'required|string|min:8',
            // 'status' => 'required|string',
            // 'remarks_sales'=> 'required',
            // 'remarks_direktur' => 'required',
            // 'validate_sales_at' => 'required|string|min:3|max:255',
            // 'validate_direktur_at' => 'required|string|min:3|max:255',
            'kode_transaksi' => 'required|string|min:3|max:255|exists:transaksi,kode_transaksi',
            'images.*' => 'required|file|mimes:png,jpg,jpeg',
        ];
    }
}
