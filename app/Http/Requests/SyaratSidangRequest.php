<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyaratSidangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'tugas_akhir_id' => 'required',
			'dokumen_id' => 'required',
			'dokumen_file_original' => 'required|string',
			'dokumen_file' => 'required|string',
			'verified' => 'required|integer|in:0,1,2',
        ];
    }
}
