<?php

namespace App\Http\Requests\Pembimbing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $pembimbingId = $this->route('pembimbing');
        return [
            'name' => [
                'required',
                Rule::unique('pembimbings', 'name')->ignore($pembimbingId)
            ],
            'image' => 'nullable|image|max:2000',
            'gender' => 'required|in:L,P',
            'jurusan' => 'required',
            'tempat_prakerins_id' => 'required',
            'alamat' => 'required'
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.unique' => 'Nama sudah digunakan. Silakan pilih nama lain.',
            'image.image' => 'Gambar harus berupa file gambar.',
            'image.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar tidak boleh melebihi 2MB.',
            'gender.required' => 'Jenis kelamin harus dipilih.',
            'gender.in' => 'Jenis kelamin harus "laki-laki" atau "perempuan".',
            'jurusan.required' => 'Jurusan harus diisi.',
            'tempat_prakerins_id' => 'Tempat Prakerin harus diisi.',
            'alamat.required' => 'Alamat harus diisi'
        ];
    }
}
