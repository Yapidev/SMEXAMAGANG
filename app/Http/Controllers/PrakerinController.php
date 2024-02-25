<?php

namespace App\Http\Controllers;

use App\Http\Requests\Prakerin\StoreRequest;
use App\Http\Requests\Prakerin\UpdateRequest;
use App\Models\Pembimbing;
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
        $prakerin = Prakerin::all();

        return view('prakerin.index', compact('prakerin'));
    }

    public function create()
    {
        return view('prakerin.create');
    }

    public function edit()
    {
        return view('prakerin.edit');
    }

    public function show($id)
    {
        $prakerin = Prakerin::findOrFail($id);
        $pembimbing = Pembimbing::where('tempat_prakerins_id', $prakerin->tempat_prakerin_id)->get();
        $prakerinData = PrakerinDetail::where('prakerin_id', $id)->orderByRaw("FIELD(status, 'sedang_magang', 'selesai_magang', 'diberhentikan')")->paginate(10);

        // Data Count
        $siswaaktifcount = PrakerinDetail::where('prakerin_id', $id)->where('status', 'sedang_magang')->count();
        $siswaselesaicount = PrakerinDetail::where('prakerin_id', $id)->where('status', 'selesai_magang')->count();

        // Data untuk Form
        $siswa = Siswa::whereNotIn('id', function ($query) {
            $query->select('siswa_id')->from('prakerin_details');
        })->get();
        $tempatPrakerin = TempatPrakerin::all();

        if ($prakerinData) {
            return view('prakerin.show', compact('prakerin', 'siswa', 'tempatPrakerin', 'prakerinData', 'pembimbing', 'siswaaktifcount', 'siswaselesaicount'));
        } else {
            return view('prakerin.show', compact('prakerin', 'siswa', 'tempatPrakerin', 'pembimbing', 'siswaaktifcount', 'siswaselesaicount'));
        }
    }


    public function store(Request $request)
    {
        try {
            if ($request['siswa_id'] > 1) {
                foreach ($request['siswa_id'] as $siswaId) {
                    PrakerinDetail::create([
                        'siswa_id' => $siswaId,
                        'prakerin_id' => $request->prakerinId,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_selesai' => $request->tanggal_selesai,
                    ]);
                }
            } else {
                foreach ($request['siswa_id'] as $siswaId) {
                    PrakerinDetail::create([
                        'siswa_id' => $siswaId,
                        'prakerin_id' => $request->prakerinId,
                        'tanggal_mulai' => $request->tanggal_mulai,
                        'tanggal_selesai' => $request->tanggal_selesai,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Berhasil menambahkan siswa');
        } catch (Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Gagal menambahkan siswa. Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
        ], [
            'status.required' => 'Status tidak boleh kosong!',
            'tanggal_mulai.required' => 'Tanggal mulai tidak boleh kosong!',
            'tanggal_selesai.required' => 'Tanggal selesai tidak boleh kosong!'
        ]);

        try {
            $prakerin = PrakerinDetail::findOrFail($id);

            if ($request->status === $prakerin->status && $request->tanggal_mulai === $prakerin->tanggal_mulai && $request->tanggal_selesai === $prakerin->tanggal_selesai) {
                return back()->with('warning', 'Anda tidak merubah apapun');
            } else {
                $prakerin->update($validated);
                return back()->with('success', 'Anda berhasil mengupdate data siswa!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data siswa!');
        }
    }

    public function destroy($id)
    {
        try {
            $prakerin = PrakerinDetail::findOrFail($id);

            $prakerin->delete();

            return back()->with('success', 'Anda berhasil menghapus data siswa!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data siswa!');
        }
    }
}
