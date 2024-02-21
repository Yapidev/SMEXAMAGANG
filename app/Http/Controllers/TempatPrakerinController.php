<?php

namespace App\Http\Controllers;

use App\Http\Requests\TempatPrakerin\StoreRequest;
use App\Http\Requests\TempatPrakerin\UpdateRequest;
use App\Models\Prakerin;
use App\Models\TempatPrakerin;
use Illuminate\Support\Facades\Storage;

class TempatPrakerinController extends Controller
{
    public function index()
    {
        $prakerin = TempatPrakerin::all();
        return view('tempatPrakerin.index', compact('prakerin'));
    }

    public function create()
    {
        return view('tempatPrakerin.create');
    }

    public function store(StoreRequest $request)
    {
        try {
            $validatedData = $request->validated();
            if ($request->hasFile('image')) {
                $validatedData['image'] = $request->image->store('uploads/tempatPrakerin/', 'public');
            }
            $createData = TempatPrakerin::create($validatedData);

            Prakerin::create([
                'tempat_prakerin_id' => $createData->id,
            ]);

            return redirect()->back()->with('success', 'Berhasil Menambah Data')->withStatus(201);
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal Menambah Data. ' . $e->getMessage())->withStatus(400);
        }
    }

    public function show($id) {
        $tempat = TempatPrakerin::findOrFail($id);

        return view('tempatPrakerin.show', compact('tempat'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $tempatPrakerin = TempatPrakerin::findOrFail($id);
            $validatedUpdate = $request->validated();
            if ($request->hasFile('image')) {
                if ($tempatPrakerin->image) {
                    Storage::disk('public')->delete($tempatPrakerin->image);
                }
                $validatedUpdate['image'] = $request->file('image')->store('uploads/tempatPrakerin/', 'public');
            } else {
                $validatedUpdate['image'] = $tempatPrakerin->image;
            }
            $tempatPrakerin->update($validatedUpdate);
            return redirect()->back()->with('success', 'Berhasil Memperbarui Data')->withStatus(200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Memperbarui Data. ' . $e->getMessage())->withStatus(400);
        }
    }

    public function destroy($id)
    {
        try {
            $prakerin = TempatPrakerin::findOrFail($id);
            $prakerin->delete($id);
            return redirect()->back()->with('success', 'Berhasil Menghapus Data')->withStatus(202);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Menghapus Data' . $e->getMessage())->withStatus(400);
        }
    }
}
