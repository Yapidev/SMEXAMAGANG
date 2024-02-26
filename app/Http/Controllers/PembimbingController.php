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
            ->with('tempatPrakerin')
            ->latest()
            ->get();

        $tempatPrakerin = TempatPrakerin::query()
            ->get();

        return view('pembimbing.index', compact('dataPembimbing', 'tempatPrakerin'));
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
                'judul' => ucwords($request->name),
                'deskripsi' => $request->gender,
                'jurusan' => $request->jurusan,
                'tempat_prakerins_id' => $request->tempat_pkl,
                'image' => $nameImage,
                'alamat' => $request->alamat
            ];

            Pembimbing::create($data);

            $dataPembimbing = Pembimbing::query()
                ->with('tempatPrakerin')
                ->latest()
                ->get();

            return response()->json(['success' => 'Berhasil', 'dataPembimbing' => $dataPembimbing], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menambah data Pembimbing' . $e->getMessage()], 500);
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
                'tempat_prakerins_id' => $request->tempat_prakerins_id,
                'image' => $nameImage,
                'alamat' => $request->alamat
            ];

            $pembimbing->update($data);

            $dataPembimbing = Pembimbing::query()
                ->with('tempatPrakerin')
                ->latest()
                ->get();

            if ($pembimbing->wasChanged()) {
                return response()->json(['success' => 'Berhasil mengedit data pembimbing', 'dataPembimbing' => $dataPembimbing], 200);
            } else {
                return response()->json(['success' => 'Tidak ada perubahan', 'dataPembimbing' => $dataPembimbing], 200);
            }
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengupdate dataPembimbing' . $e->getMessage()], 500);
        }
    }

    /**
     * destroy function untuk delete data pembimbing terkait
     *
     * @param  mixed $pembimbing
     * @return void
     */
    public function destroy(Pembimbing $pembimbing)
    {
        $pembimbing->delete();

        $dataPembimbing = Pembimbing::query()
            ->with('tempatPrakerin')
            ->latest()
            ->get();

        if ($dataPembimbing->isEmpty()) {
            return response()->json(['success' => 'Berhasil', 'dataPembimbing' => null], 200);
        }

        return response()->json(['success' => 'Berhasil', 'dataPembimbing' => $dataPembimbing], 200);
    }
}
