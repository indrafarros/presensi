<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $presensiToday = Presensi::where('nik', Auth::guard()->user()->nik)->where('presensi_date', $today)->first();

        return view('dashboard.home', ['presensi' => $presensiToday]);
    }
}
