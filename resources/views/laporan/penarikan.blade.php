@extends('layouts.app')

@section('content')
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Overview</span>
            <h3 class="page-title">Laporan Penarikan</h3>
        </div>
    </div>
    <!-- Default Light Table -->

    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-header border-bottom">
                    <h6 class="m-0 d-flex justify-content-between">
                        <form action="{{ url('penarikan/report') }}">
                            <div class="form-inline">
                                <label for="tgl_awal">Report</label>
                                <input type="date" name="tgl_awal" id="tgl_awal" class="form-control"> To
                                <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control">
                                <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Semua Nasabah</option>
                                        @foreach ($nasabah as $item)
                                            <option value="{{ $item->id }}">{{ $item->no_anggota .'-'.  $item->name }}</option>
                                        @endforeach
                                    </select>
                                <button class="btn btn-sm btn-primary ml-1"><i class="material-icons">print</i></button>
                            </div>
                        </form>
                    </h6>
                </div>
                <div class="card-body p-0 pb-3 text-center">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">Kode Transaksi</th>
                                <th scope="col" class="border-0">Tanggal</th>
                                <th scope="col" class="border-0">Nasabah</th>
                                <th scope="col" class="border-0">Debit</th>
                                <th scope="col" class="border-0">Kredit</th>
                                <th scope="col" class="border-0">Saldo</th>
                                <th scope="col" class="border-0">Pengelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penarikan as $row)
                            <tr>
                                <td>{{ $row->kode_transaksi }}</td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->kredit }}</td>
                                <td>{{ $row->debit }}</td>
                                <td>{{ $row->saldo }}</td>
                                <td>{{ $row->pengelola }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 
                </div>
            
            </div>
        </div>
    </div>
    <!-- End Default Light Table -->

</div>
@endsection