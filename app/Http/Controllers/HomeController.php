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
            ->select(DB::raw('YEAR(tanggal_mulai) as tahun'), DB::raw('count(*) as total'))
            ->whereBetween(DB::raw('YEAR(tanggal_mulai)'), [$tahunAwal, $tahunSekarang])
            ->groupBy(DB::raw('YEAR(tanggal_mulai)'))
            ->get();

        $tahun = $siswaPerTahun->pluck('tahun');
        $totalSiswa = $siswaPerTahun->pluck('total');

        $carouselData = [
            'siswa' => $siswaQuery->count(),
            'pembimbing' => $pembimbingQuery->count(),
            'tempat_prakerin' => $tempatPrakerinQuery->count(),
            'prakerin' => $prakerinQuery->whereNot('status', 'diberhentikan')->count(),
            'tahun' => $tahun,
            'totalSiswa' => $totalSiswa,
        ];

        return view('home', compact('carouselData'));
    }
}
