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

                <form action="/history" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-auto mb-3">
                            <select name="bulan" id="bulan" class="form-control">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}"
                                        @if (isset($selectDate[0]) && $selectDate[0] == $m) selected @elseif(date('n') == $m) selected @endif>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto mb-3">
                            <select name="tahun" id="tahun" class="form-control">
                                {{ $last = date('Y') - 10 }}
                                {{ $now = date('Y') }}

                                @for ($i = $now; $i >= $last; $i--)
                                    <option value="{{ $i }}"
                                        @if (isset($selectDate[1]) && $selectDate[1] == $i) selected @elseif(date('Y') == $i) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto mb-3">
                            <button class="btn btn-primary btn-block">Cari</button>
                        </div>
                    </div>
                </form>

                <div class="mt-5">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tgl</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($presensiUser)
                                    @foreach ($presensiUser as $item)
                                        <tr>
                                            <td>{{ date('d-m-Y', strtotime($item->presensi_date)) }}</td>
                                            <td>{{ date('H:i', strtotime($item->clock_in)) }}</td>
                                            <td>{{ date('H:i', strtotime($item->clock_out)) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>Tidak ada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $presensiUser->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
