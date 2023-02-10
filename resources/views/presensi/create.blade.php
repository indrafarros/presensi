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

    <style>
        .capture,
        .capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 240px;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection

@section('content')
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

    <div class="row mt-5">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
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
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map)

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.1,
                radius: 50
            }).addTo(map);
        }

        function errorCallBack() {

        }
    </script>
@endpush
