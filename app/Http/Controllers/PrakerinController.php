<?php

namespace App\Http\Controllers;

use App\Http\Requests\Prakerin\StoreRequest;
use App\Http\Requests\Prakerin\UpdateRequest;
use App\Models\Prakerin;
use App\Models\PrakerinDetail;
use App\Models\Siswa;
use App\Models\TempatPrakerin;
use Exception;
use Illuminate\Http\Request;

class PrakerinController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        $tempatPrakerin = TempatPrakerin::all();

        return view('prakerin.index', compact('siswa', 'tempatPrakerin'));
    }

    public function create()
    {
        return view('prakerin.create');
    }

    public function edit()
    {
        return view('prakerin.edit');
    }

    public function store(Request $request)
    {
        try {
            $prakerinIds = Prakerin::create([
                'tempat_prakerin_id' => $request->tempat_prakerin_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => 'sedang_magang'
            ]);

            foreach ($request['siswa_id'] as $siswaId) {
                PrakerinDetail::create([
                    'siswa_id' => $siswaId,
                    'prakerin_id' => $prakerinIds->id,
                ]);
            }

            return redirect()->back()->with('success', 'Berhasil menambahkan siswa');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan siswa. Error: ' . $e->getMessage());
        }
    }


    public function update(UpdateRequest $request)
    {
        // 
    }

    public function destroy($id)
    {
        // 
    }
}
