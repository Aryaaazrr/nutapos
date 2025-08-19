<?php

namespace App\Http\Requests\Pajak;

use Illuminate\Foundation\Http\FormRequest;

class PajakRequest extends FormRequest
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
            'total' => 'required|numeric|min:1',
            'persen_pajak' => 'required|numeric|min:0.1|max:100',
        ];
    }
}
