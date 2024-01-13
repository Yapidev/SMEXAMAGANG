<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $dataSiswa = Siswa::query()
            ->latest()
            ->get();
        return view('siswa.index', compact('dataSiswa'));
    }

    /**
     * create
     *
     * @param  mixed $request
     * @return void
     */
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
                'image' => $nameImage,
            ];

            Siswa::create($data);

            $dataSiswa = Siswa::query()
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['message' => 'Terjadi kesalahan saat membuat siswa' . $e->getMessage()], 500);
        }
    }

    /**
     * edit
     *
     * @param  mixed $siswa
     * @return void
     */
    public function edit(Siswa $siswa)
    {
        return response()->json(['success' => 'Berhasil', 'dataSiswa' => $siswa], 200);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $siswa
     * @return void
     */
    public function update(UpdateSiswaRequest $request, Siswa $siswa)
    {
        try {
            if ($request->hasFile('image')) {
                if ($siswa->image != null) {
                    Storage::disk('public')->delete($siswa->image);
                }
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
                'image' => $nameImage,
            ];

            $siswa->update($data);

            $dataSiswa = Siswa::query()
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['message' => 'Terjadi kesalahan saat membuat siswa' . $e->getMessage()], 500);
        }
    }

    /**
     * destroy
     *
     * @param  mixed $siswa
     * @return void
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        $dataSiswa = Siswa::query()
            ->latest()
            ->get();

        if ($dataSiswa->isEmpty()) {
            return response()->json(['success' => 'Berhasil', 'dataSiswa' => null], 200);
        }

        return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
    }

    /**
     * importCsv
     * Ini adalah function untuk Import data siswa menggunakan file excel berformat csv
     *
     * @param  mixed $request
     * @return void
     */
    public function importCsv(Request $request)
    {
        DB::beginTransaction();
        try {
            $path = $request->import->getRealPath();
            $data = array_map('str_getcsv', file($path));
            array_shift($data);
            $data = array_filter($data, function ($item) {
                return !empty(trim(implode('', $item)));
            });

            foreach ($data as $row) {
                Siswa::create([
                    'name' => $row[0],
                    'class' => $row[1],
                    'phone_number' => $row[2],
                    'nik' => $row[3],
                    'gender' => $row[4],
                ]);
            }

            $siswa = Siswa::query()
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil import csv', 'dataSiswa' => $siswa]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal import csv' . $th->getMessage()]);
        }
    }
}
