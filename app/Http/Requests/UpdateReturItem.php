<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReturItem extends FormRequest
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
            'is_valid' => 'sometimes|required|boolean',
            'no_surat_jalan' => 'sometimes|required|string',
            'jenis_masalah' => 'sometimes|required|string',
            'keterangan'=> 'sometimes|required|string',
            'tanggal_pesan'=> 'sometimes|required|date',
            'tanggal_kirim'=> 'sometimes|required|date',
            'bukti_foto'=> 'sometimes|required|file|mimes:png,jpg,jpeg',
            'status'=> 'sometimes|required|integer',
            'remarks_sales'=> 'sometimes|required',
            'remarks_direktur' => 'sometimes|required',
            // 'validate_sales_at' => 'sometimes|required|datetime',
            // 'validate_direktur_at' => 'sometimes|required|datetime',
        ];
    }
}
