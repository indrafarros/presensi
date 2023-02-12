<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $nik = Auth::guard('employee')->user()->nik;
        $today = Carbon::now()->toDateString();
        $presensi = Presensi::where('nik', $nik)->where('presensi_date', $today)->first();
        return view('presensi.create', ['presensi' => $presensi]);
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
        // end check today

        $request['nik'] = $nik;
        $request['presensi_date'] = $today;
        $officeCoordinat = '-6.242722057456307, 107.0485064442227';
        $officeExplode = explode(",", $officeCoordinat);

        $locationExplode = explode(",", $request->location);
        $distance = $this->getDistance($officeExplode[0], $officeExplode[1], $locationExplode[0], $locationExplode[1]);
        $radius = round($distance["meters"]);

        if ($radius > 20) {
            return response()->json(['message' => 'Anda berada diluar radius'], 400);
        }

        if ($request->image) {
            $imageParts = explode(";base64", $request->image);
            $imageDecode = base64_decode($imageParts[1]);
            $fileName = $nik . "-" . now()->timestamp . "." . "png";

            $folderPath = "public/uploads/presensi/";
            Storage::put($folderPath . $fileName, $imageDecode);
            $request['photo_in'] = $fileName;
        }
        if ($presensiToday < 1) {
            $request['location_in'] = $request->location;
            $request['clock_in'] = Carbon::now()->toTimeString();
            Presensi::create($request->all());
        } else {
            $request['location_out'] = $request->location;
            $request['clock_out'] = Carbon::now()->toTimeString();
            Presensi::where('nik', $nik)->update(['clock_out' => $request['clock_out'], 'photo_out' => $request['photo_in'], 'location_out' => $request['location_out']]);
        }

        return response()->json(["status" => true, "message" => 'Success'], 200);
    }

    function getDistance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet  = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }
}
