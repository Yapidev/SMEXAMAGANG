<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSiswaRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('siswas', 'name'),
            ],
            'class' => 'required|string',
            'phone_number' => 'required|regex:/^08\d{8,11}$/',
            'nisn' => [
                'required',
                'digits:10',
                Rule::unique('siswas', 'nisn'),
            ],
            'gender' => 'required|in:L,P|string',
            'image' => 'nullable|image|max:2048',
            'alamat' => 'required'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Kolom nama harus diisi.',
            'name.unique' => 'Nama sudah digunakan. Silakan pilih nama lain.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.unique' => 'Nama sudah digunakan.',

            'class.required' => 'Kolom kelas harus diisi.',
            'class.string' => 'Kolom kelas harus berupa teks.',

            'phone_number.required' => 'Kolom nomor telepon harus diisi.',
            'phone_number.regex' => 'Format nomor telepon tidak valid. Harus dimulai dengan "08" dan panjangnya antara 10 hingga 13 digit.',

            'nisn.required' => 'Kolom NISN harus diisi.',
            'nisn.digits' => 'Format NISN tidak valid. NISN harus terdiri dari 10 digit angka.',
            'nisn.unique' => 'NISN sudah digunakan.',

            'gender.required' => 'Kolom jenis kelamin harus diisi.',
            'gender.in' => 'Jenis kelamin yang dipilih tidak valid.',
            'gender.string' => 'Kolom jenis kelamin harus berupa teks.',

            'image.required' => 'Kolom gambar harus diisi.',
            'image.image' => 'File yang diunggah bukan gambar.',
            'image.max' => 'Ukuran gambar terlalu besar. Maksimal ukuran gambar adalah 2MB.',

            'alamat.required' => 'Alamat harus diisi.'
        ];
    }
}
