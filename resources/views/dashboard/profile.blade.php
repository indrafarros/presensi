@extends('layouts.main')

@section('title', 'Profile')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-info text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Dashboard</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
    <div class="section" id="user-section" style="margin-top: 50px">
        <div id="user-detail">
            <div class="avatar">
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ ucfirst($user->name) }}</h2>
                <span id="user-role">{{ ucfirst($user->roles->name) }}</span>
            </div>
        </div>
    </div>

    <div class="section " id="presence-section" style="margin-top: 90px">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-auto mb-3">
                        <label for="nik" class="visually-hidden">NIK</label>
                        <input type="text" readonly class="form-control-plaintext" id="nik"
                            value="{{ $user->nik }}">
                    </div>
                    <div class="col-auto mb-3">
                        <label for="name" class="visually-hidden">Name</label>
                        <input type="text" class="form-control" id="name" readonly value="{{ $user->name }}">
                    </div>
                    <div class="col-auto mb-3">
                        <label for="occupation" class="visually-hidden">Occupation</label>
                        <input type="text" class="form-control" id="occupation" readonly
                            value="{{ $user->roles->name }}">
                    </div>
                    <div class="col-auto mb-3">
                        <label for="phone" class="visually-hidden">Phone Number</label>
                        <input type="text" class="form-control" id="phone" readonly value="{{ $user->phone }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
