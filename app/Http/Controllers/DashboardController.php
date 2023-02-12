<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $nik = Auth::guard()->user()->nik;
        $presensiToday = Presensi::where('nik', $nik)->where('presensi_date', $today)->first();
        $presensiUser =  Presensi::where('nik', $nik)->whereRaw('MONTH(presensi_date) = ?', date('m'))->orderBy('presensi_date', 'desc')->paginate(10);
        $user = Employees::with('roles')->where('nik', $nik)->first();

        return view('dashboard.home', ['presensi' => $presensiToday, 'presensiUser' => $presensiUser, 'user' => $user]);
    }
}
