<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Prakerin;
use App\Models\PrakerinDetail;
use App\Models\Siswa;
use App\Models\TempatPrakerin;
use Illuminate\Http\Request;

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

        $carouselData = [
            'siswa' => $siswaQuery->count(),
            'pembimbing' => $pembimbingQuery->count(),
            'tempat_prakerin' => $tempatPrakerinQuery->count(),
            'prakerin' => $prakerinQuery->whereNot('status', 'diberhentikan')->count(),
        ];

        return view('home', compact('carouselData'));
    }
}
