<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\Siswa\StoreRequest;
use App\Http\Requests\Siswa\UpdateRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class SiswaController extends Controller
{
    public function index()
    {
        $dataSiswa = Siswa::latest()->get();
        return view('siswa.index', compact('dataSiswa'));
    }

    public function create(CreateSiswaRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $nameImage = $request->image->store('foto-siswa', 'public');
            } else {
                $nameImage = null;
            }

            $data = [
                'name' => ucwords($request->name),
                'class' => $request->class,
                'phone_number' => $request->phone_number,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'image' => $nameImage
            ];

            Siswa::create($data);

            $dataSiswa = Siswa::latest()->get();

            return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['message' => 'Terjadi kesalahan saat membuat siswa' . $e->getMessage()], 500);
        }
    }

    public function edit(Siswa $siswa)
    {
        return response()->json(['success' => 'Berhasil', 'dataSiswa' => $siswa], 200);
    }

    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        try {
            if ($request->hasFile('image')) {
                Storage::disk('public')->delete($siswa->image);
                $nameImage = $request->image->store('foto-siswa', 'public');
            } else {
                $nameImage = $siswa->image;
            }

            $data = [
                'name' => ucwords($request->name),
                'class' => $request->class,
                'jurusan' => $request->jurusan,
                'phone_number' => $request->phone_number,
                'nik' => $request->nik,
                'gender' => $request->gender,
                'image' => $nameImage
            ];

            $siswa->update($data);

            $dataSiswa = Siswa::latest()->get();

            return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['message' => 'Terjadi kesalahan saat membuat siswa' . $e->getMessage()], 500);
        }
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        $dataSiswa = Siswa::latest()->get();

        if ($dataSiswa->isEmpty()) {
            return response()->json(['success' => 'Berhasil', 'dataSiswa' => null], 200);
        }

        return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
    }
}
