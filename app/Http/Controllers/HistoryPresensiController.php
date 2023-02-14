<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryPresensiController extends Controller
{
    public function show(Request $request)
    {
        if (Auth::guard('employee')) {
            $nik = Auth::guard('employee')->user()->nik;
            $presensiUser =  Presensi::where('nik', $nik)->whereRaw('MONTH(presensi_date) = ?', date('m'))->orderBy('presensi_date', 'desc')->paginate(2);

            $user = Employees::where('nik', $nik)->with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])->first(['nik', 'name', 'role_id', 'phone']);

            if ($request->bulan && $request->tahun) {
                $presensiUser =  Presensi::where('nik', $nik)->whereRaw('MONTH(presensi_date) = ?', $request->bulan)->orderBy('presensi_date', 'desc')->paginate(2);

                $selectDate = [$request->bulan, $request->tahun];
                return view('dashboard.historyPresensi', compact(['presensiUser', 'user', 'selectDate']));
            }

            return view('dashboard.historyPresensi', compact(['presensiUser', 'user']));
        }
    }
}
