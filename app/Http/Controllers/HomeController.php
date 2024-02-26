<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Prakerin;
use App\Models\PrakerinDetail;
use App\Models\Siswa;
use App\Models\TempatPrakerin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $siswaQuery = Siswa::query();
        $pembimbingQuery = Pembimbing::query();
        $tempatPrakerinQuery = TempatPrakerin::query();
        $prakerinQuery = PrakerinDetail::query();

        $tahunSekarang = now()->year;
        $tahunAwal = $tahunSekarang - 5;

        $siswaPerTahun = $prakerinQuery
            ->select(
                DB::raw('YEAR(tanggal_mulai) as tahun'),
                DB::raw('SUM(CASE WHEN status = "sedang_magang" THEN 1 ELSE 0 END) as aktif'),
                DB::raw('SUM(CASE WHEN status = "selesai_magang" THEN 1 ELSE 0 END) as selesai'),
                DB::raw('SUM(CASE WHEN status = "diberhentikan" THEN 1 ELSE 0 END) as diberhentikan')
            )
            ->whereBetween(DB::raw('YEAR(tanggal_mulai)'), [$tahunAwal, $tahunSekarang])
            ->groupBy(DB::raw('YEAR(tanggal_mulai)'))
            ->get();

        $tahun = range($tahunAwal, $tahunSekarang);
        $data = [];
        foreach ($tahun as $t) {
            $data[] = [
                'tahun' => $t,
                'aktif' => $siswaPerTahun->where('tahun', $t)->first()->aktif ?? 0,
                'selesai' => $siswaPerTahun->where('tahun', $t)->first()->selesai ?? 0,
                'diberhentikan' => $siswaPerTahun->where('tahun', $t)->first()->diberhentikan ?? 0,
            ];
        }

        $carouselData = [
            'siswa' => $siswaQuery->count(),
            'pembimbing' => $pembimbingQuery->count(),
            'tempat_prakerin' => $tempatPrakerinQuery->count(),
            'prakerin' => $prakerinQuery->whereNot('status', 'diberhentikan')->count(),
            'tahun' => $tahun,
            'data' => $data,
        ];
        
        return view('home', compact('carouselData'));
    }
}
