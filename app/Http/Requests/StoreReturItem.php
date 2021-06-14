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
        // 'is_valid' => 'required|boolean',
        'no_surat_jalan' => 'required|string',
        'jenis_masalah' => 'required|string',
        'keterangan'=> 'required|string',
        'tanggal_pesan'=> 'required|date',
        'tanggal_kirim'=> 'required|date',
        'bukti_foto'=> 'required|file|mimes:png,jpg,jpeg',
        // 'status'=> 'required|integer',
        // 'remarks_sales'=> 'required',
        // 'remarks_direktur' => 'required',
        // 'validate_sales_at' => 'required|string|min:3|max:255',
        // 'validate_direktur_at' => 'required|string|min:3|max:255',
        ];
    }
}
