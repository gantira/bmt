@extends('layouts.app')

@section('content')
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Overview</span>
            <h3 class="page-title">Laporan</h3>
        </div>
    </div>
    <!-- Default Light Table -->

    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card" >
                    <ul class="list-group list-group-flush">
                      <li class="list-group-item"><a href="{{ url('laporan/simpanan') }}"> Laporan Simpanan</a></li>
                      <li class="list-group-item"><a href="{{ url('laporan/penarikan') }}"> Laporan Penarikan</a></li>
                      <li class="list-group-item"><a href="{{ url('laporan/pinjaman') }}"> Laporan Pinjaman</a></li>
                    </ul>
                  </div>
            
            </div>
        </div>
    </div>
    <!-- End Default Light Table -->

</div>
@endsection