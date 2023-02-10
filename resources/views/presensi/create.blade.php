@extends('layouts.main')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-info text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <style>
        .capture,
        .capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }
    </style>
    <div class="row" style="margin-top:70px">
        <div class="col">
            <input type="hidden" name="lokasi" id="lokasi" class="form-control">
            <div class="capture">
            </div>
        </div>
    </div>

    <div class="row">
        <button type="button" class="btn btn-primary btn-block" id="absen">
            <ion-icon name="save-outline"></ion-icon> Absen
        </button>
    </div>
@endsection

@push('myscript')
    <script>
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.capture');

        var lokasi = document.getElementById('lokasi');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallBack, errorCallBack);
        }

        function successCallBack(position) {
            lokasi.value = position.coords.latitude;
        }

        function errorCallBack() {

        }
    </script>
@endpush
