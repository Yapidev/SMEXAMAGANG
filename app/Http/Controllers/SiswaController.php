<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'image' => $nameImage,
                'alamat' => $request->alamat
            ];

            Siswa::create($data);

            $dataSiswa = Siswa::query()
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil', 'dataSiswa' => $dataSiswa], 200);
        } catch (\Throwable $e) {
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
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'image' => $nameImage,
                'alamat' => $request->alamat ?: $siswa->alamat
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
            $validator = Validator::make($request->all(), [
                'import' => 'required|mimes:csv,txt',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $path = $request->file('import')->getRealPath();
            $data = array_map('str_getcsv', file($path));
            array_shift($data);
            $data = array_filter($data, function ($item) {
                return !empty(trim(implode('', $item)));
            });

            if ($data == null) {
                return response()->json(['error', 'gagal'], 500);
            };

            $newData = [];

            foreach ($data as $row) {
                foreach ($row as $item) {
                    $rowData = explode(';', $item);

                    $rowData[2] = str_pad($rowData[3], 12, '0', STR_PAD_LEFT);
                    $rowData[3] = str_pad($rowData[2], 10, '0', STR_PAD_LEFT);

                    $newData[] = [
                        'name' => $rowData[0],
                        'class' => $rowData[1],
                        'phone_number' => $rowData[2],
                        'nisn' => $rowData[3],
                        'gender' => $rowData[4],
                        'alamat' => $rowData[5]
                    ];
                }
            }

            foreach ($newData as $rowData) {
                $validator = Validator::make($rowData, [
                    'name' => 'required|string|max:255',
                    'class' => 'required|string|max:255',
                    'phone_number' => 'required|string|max:20',
                    'nisn' => [
                        'required',
                        'string',
                        'max:20',
                        Rule::unique('siswas', 'nisn'), // Pastikan nisn unik dalam tabel siswas
                    ],
                    'gender' => 'required',
                    'alamat' => 'required|string|max:255',
                ]);

                if ($validator->fails()) {
                    DB::rollBack();
                    return response()->json(['error' => $validator->errors()->first()], 422);
                }

                Siswa::create($rowData);
            }

            DB::commit();
            $siswa = Siswa::latest()->get();

            return response()->json(['success' => 'Berhasil import csv', 'dataSiswa' => $siswa]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal import csv: ' . $th->getMessage()], 500);
        }
    }
}
