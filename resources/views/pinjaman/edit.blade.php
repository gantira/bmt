@extends('layouts.app', ['linkpinjaman'=>'active'])

@section('content')
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle"></span>
            <h3 class="page-title">Pembayaran</h3>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="row">
        <div class="col-lg-9 col-md-12">
            <!-- Add New Post Form -->
            <div class="card card-small mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pinjaman->detail()->get() as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ number_format($item->bayar_bulanan, 2) }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        <a href="#" onclick="getElementById('hapus{{ $item->id }}').submit()">
                                            <i class="material-icons" title="delete">delete</i>
                                        </a>
                                        <form action="{{ route('pinjaman.destroy', ['id'=>$item->id]) }}" method="post" id="hapus{{ $item->id }}">
                                            @method('delete')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- / Add New Post Form -->
        </div>
        <div class="col-lg-3 col-md-12">
            <!-- Post Overview -->
            <div class='card card-small mb-3'>
                <div class="card-header border-bottom">
                    <h6 class="m-0">Info</h6>
                </div>
                <form action="{{ route('bayar.update', ['id'=>$pinjaman->id]) }}" method="post">
                    @method('patch')
                    @csrf
                    <div class='card-body p-0'>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3">
                                <span class="d-flex mb-2">
                                    <i class="material-icons mr-1">person</i>
                                    <strong class="mr-1">Nasabah:</strong> {{ $pinjaman->user->name }}
                                </span>
                                <span class="d-flex mb-2">
                                    <i class="material-icons mr-1">local_atm</i>
                                    <strong class="mr-1">Jumlah Pinjaman:</strong>
                                    <strong class="text-success">Rp{{ number_format($pinjaman->jumlah,2) }}</strong>
                                </span>
                                <span class="d-flex mb-2">
                                    <i class="material-icons mr-1">calendar_today</i>
                                    <strong class="mr-1">Durasi:</strong> {{ $pinjaman->durasi }}
                                </span>
                                <span class="d-flex">
                                    <i class="material-icons mr-1">score</i>
                                    <strong class="mr-1">Cicilan/bulan:</strong>
                                    <strong class="text-warning">Rp{{ number_format($pinjaman->jumlah /
                                        $pinjaman->durasi, 2) }}</strong>
                                    <input type="hidden" name="bayar_bulanan" value="{{ $pinjaman->jumlah / $pinjaman->durasi }}">
                                </span>
                            </li>
                            <li class="list-group-item d-flex px-3">
                                <div>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-accent ml-auto"
                                    {{ $pinjaman->durasi <= $pinjaman->detail()->count() ? 'disabled' : ''}}>
                                    {!! $pinjaman->durasi <= $pinjaman->detail()->count() ? '<i class="material-icons">local_atm</i>
                                        Lunas' : '<i class="material-icons">local_atm</i> Bayar' !!}
                                </button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <!-- / Post Overview -->

        </div>
    </div>
</div>

@endsection
