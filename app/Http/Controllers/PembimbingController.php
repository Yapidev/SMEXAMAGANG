<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pembimbing\StoreRequest;
use App\Http\Requests\Pembimbing\UpdateRequest;
use App\Models\Pembimbing;
use App\Models\Prakerin;
use App\Models\TempatPrakerin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PembimbingController extends Controller
{
    /**
     * index function untuk menampilkan halaman dan data pembimbing
     *
     * @return void
     */
    public function index()
    {
        $dataPembimbing = Pembimbing::query()
            ->latest()
            ->get();

        return view('pembimbing.index', compact('dataPembimbing'));
    }

    /**
     * create function untuk store atau post data pembimbing baru ke table pembimbings
     *
     * @param  mixed $request
     * @return void
     */
    public function Store(StoreRequest $request)
    {
        try {
            if ($request->hasFile('image')) {
                $nameImage = $request->image->store('foto-pembimbing', 'public');
            } else {
                $nameImage = null;
            }

            $data = [
                'name' => ucwords($request->name),
                'gender' => $request->gender,
                'jurusan' => $request->jurusan,
                'tempat_prakerin_id' => $request->tempat,
                'image' => $nameImage,
            ];

            Pembimbing::create($data);

            $dataPembimbing = Pembimbing::query()
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil', 'dataPembimbing' => $dataPembimbing], 200);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['message' => 'Terjadi kesalahan saat membuat siswa' . $e->getMessage()], 500);
        }
    }

    /**
     * edit function untuk get data instance model pembimbing terkait
     *
     * @param  mixed $pembimbing
     * @return void
     */
    public function edit(Pembimbing $pembimbing)
    {
        return response()->json(['success' => 'Berhasil', 'dataPembimbing' => $pembimbing], 200);
    }

    /**
     * update function untuk update atau put data pembimbing terkait
     *
     * @param  mixed $request
     * @param  mixed $pembimbing
     * @return void
     */
    public function update(UpdateRequest $request, Pembimbing $pembimbing)
    {
        try {
            if ($request->hasFile('image')) {
                if ($pembimbing->image != null) {
                    Storage::disk('public')->delete($pembimbing->image);
                }
                $nameImage = $request->image->store('foto-pembimbing', 'public');
            } else {
                $nameImage = $pembimbing->image;
            }

            $data = [
                'name' => ucwords($request->name),
                'gender' => $request->gender,
                'jurusan' => $request->jurusan,
                'tempat_prakerin_id' => $request->tempat,
                'image' => $nameImage,
            ];

            $pembimbing->update($data);

            $dataPembimbing = Pembimbing::query()
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil', 'dataPembimbing' => $dataPembimbing], 200);
        } catch (\Throwable $e) {
            dd($e);
            return response()->json(['message' => 'Terjadi kesalahan saat mengupdate dataPembimbing' . $e->getMessage()], 500);
        }
    }

    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->delete();

        $dataPembimbing = Pembimbing::query()
            ->latest()
            ->get();

        if ($dataPembimbing->isEmpty()) {
            return response()->json(['success' => 'Berhasil', 'dataPembimbing' => null], 200);
        }

        return response()->json(['success' => 'Berhasil', 'dataPembimbing' => $dataPembimbing], 200);
    }
}
