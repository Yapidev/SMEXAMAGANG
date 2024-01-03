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
    public function index()
    {
        $data = Pembimbing::all();
        $lokasi = TempatPrakerin::all();

        return view('pembimbing.index', compact('data', 'lokasi'));
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = 'uploads/pembimbing/';

                Storage::makeDirectory($path);

                $imageName = Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();

                $image->storeAs($path, $imageName);

                $validatedData['image_path'] = $path . $imageName;
            }

            Pembimbing::create($validatedData);

            return redirect()->route('pembimbing.index')->with('success', 'Berhasil Menambah Data')->withStatus(201);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menambah Data. ' . $e->getMessage())->withStatus(400);
        }
    }

    public function update(UpdateRequest $request, Pembimbing $id)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = 'uploads/pembimbing/';
                Storage::makeDirectory($path);
                $imageName = Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();
                if ($id->image_path) {
                    Storage::delete($id->image_path);
                }
                $image->storeAs($path, $imageName);
                $validatedData['image_path'] = $path . $imageName;
            }

            $id->update($validatedData);

            return redirect()->route('pembimbing.index')->with('success', 'Berhasil Mengedit Data')->withStatus(200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Mengedit Data. ' . $e->getMessage())->withStatus(400);
        }
    }

    public function destroy($id)
    {
        try {
            $pembimbing = Pembimbing::findOrFail($id);

            if ($pembimbing->image_path) {
                Storage::delete($pembimbing->image_path);
            }

            $pembimbing->delete();

            return redirect()->route('pembimbing.index')->with('success', 'Berhasil Menghapus Data')->withStatus(200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menghapus Data. ' . $e->getMessage())->withStatus(400);
        }
    }
}
