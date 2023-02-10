<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        return view('presensi.create');
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'image' => 'required',
            'location' => 'required'
        ]);
        $today = Carbon::now()->toDateString();
        $nik = Auth::guard('employee')->user()->nik;
        // check presensi today
        $presensiToday = Presensi::where('nik', $nik)->where('presensi_date', $today)->count();
        if ($presensiToday > 0) {
            return response()->json(['message' => 'Hari ini sudah melakukan absensi'], 200);
        }

        // end check today

        $request['nik'] = $nik;
        $request['presensi_date'] = $today;
        $request['clock_in'] = Carbon::now()->toTimeString();

        if ($request->image) {
            $imageParts = explode(";base64", $request->image);
            $imageDecode = base64_decode($imageParts[1]);
            $fileName = $nik . "-" . now()->timestamp . "." . "png";

            $folderPath = "public/uploads/presensi/";
            Storage::put($folderPath . $fileName, $imageDecode);
            $request['photo_in'] = $fileName;
        }

        Presensi::create($request->all());

        return response()->json(['message' => "ok"], 200);
    }
}
