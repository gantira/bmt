@extends('layouts.app', ['linkhome', 'active'])

@section('content')
<div class="main-content-container container-fluid px-4">
    <!-- Page Header -->
    <div class="page-header row no-gutters py-4">
        <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
            <span class="text-uppercase page-subtitle">Dashboard</span>
            <h3 class="page-title">Home Overview</h3>
        </div>
    </div>
    <!-- End Page Header -->
    <!-- Small Stats Blocks -->
    @role('nasabah')
    <div class="row">
        <div class="col-lg col-md-6 col-sm-6 mb-4">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">Simpanan</span>
                            <h6 class="stats-small__value count my-3">{{ Auth::user()->simpanan()->count() }}</h6>
                        </div>
                        <div class="stats-small__data">
                            {{-- <span class="stats-small__percentage stats-small__percentage--increase">4.7%</span> --}}
                        </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-1"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-6 col-sm-6 mb-4">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">Penarikan</span>
                            <h6 class="stats-small__value count my-3">{{ Auth::user()->penarikan()->count() }}</h6>
                        </div>
                        <div class="stats-small__data">
                            {{-- <span class="stats-small__percentage stats-small__percentage--increase">12.4%</span> --}}
                        </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-2"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6 mb-4">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">Pinjaman</span>
                            <h6 class="stats-small__value count my-3">{{ Auth::user()->pinjaman()->count() }}</h6>
                        </div>
                        <div class="stats-small__data">
                            {{-- <span class="stats-small__percentage stats-small__percentage--decrease">3.8%</span> --}}
                        </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-3"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6 mb-4">
            <div class="stats-small stats-small--1 card card-small">
                <div class="card-body p-0 d-flex">
                    <div class="d-flex flex-column m-auto">
                        <div class="stats-small__data text-center">
                            <span class="stats-small__label text-uppercase">Saldo</span>
                            <h6 class="stats-small__value count my-3">{{ number_format(Auth::user()->simpanan()->sum('debit') - Auth::user()->simpanan()->sum('kredit'))}}</h6>
                        </div>
                        <div class="stats-small__data">
                            {{-- <span class="stats-small__percentage stats-small__percentage--decrease">3.8%</span> --}}
                        </div>
                    </div>
                    <canvas height="120" class="blog-overview-stats-small-3"></canvas>
                </div>
            </div>
        </div>
        </div>

        <div class="row">

        
        <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header border-bottom">
                      Histori Transaksi
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <table class="table mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="border-0">Kode Transaksi</th>
                                    <th scope="col" class="border-0">Tanggal</th>
                                    <th scope="col" class="border-0">Nasabah</th>
                                    <th scope="col" class="border-0">Tarik</th>
                                    <th scope="col" class="border-0">Masuk</th>
                                    <th scope="col" class="border-0">Saldo</th>
                                    <th scope="col" class="border-0">Pengelola</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Auth::user()->simpanan()->get() as $simpanan)
                                <tr>
                                    <td>{{ $simpanan->kode_transaksi }}</td>
                                    <td>{{ $simpanan->tanggal }}</td>
                                    <td>{{ $simpanan->user->name }}</td>
                                    <td>{{ $simpanan->debit }}</td>
                                    <td>{{ $simpanan->kredit }}</td>
                                    <td>{{ $simpanan->saldo }}</td>
                                    <td>{{ $simpanan->pengelola }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="float-right mr-2 mt-2">
                            <vue-pagination :data="simpanan" v-on:pagination-change-page="getSimpanan" :limit="1"></vue-pagination>
                        </div>
                    </div>


                  
                </div>
            </div>


        </div>
    </div>
    @endrole

    @hasanyrole('admin|pengelola')
    <div class="row">
            <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                    <div class="card-body p-0 d-flex">
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <span class="stats-small__label text-uppercase">Simpanan</span>
                                <h6 class="stats-small__value count my-3">{{ App\Simpanan::where('jenis', '!=', 'PNK')->count() }}</h6>
                            </div>
                            <div class="stats-small__data">
                                {{-- <span class="stats-small__percentage stats-small__percentage--increase">4.7%</span> --}}
                            </div>
                        </div>
                        <canvas height="120" class="blog-overview-stats-small-1"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                    <div class="card-body p-0 d-flex">
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <span class="stats-small__label text-uppercase">Penarikan</span>
                                <h6 class="stats-small__value count my-3">{{ App\Simpanan::where('jenis', 'PNK')->count() }}</h6>
                            </div>
                            <div class="stats-small__data">
                                {{-- <span class="stats-small__percentage stats-small__percentage--increase">12.4%</span> --}}
                            </div>
                        </div>
                        <canvas height="120" class="blog-overview-stats-small-2"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                    <div class="card-body p-0 d-flex">
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <span class="stats-small__label text-uppercase">Pinjaman</span>
                                <h6 class="stats-small__value count my-3">{{ App\Pinjaman::count() }}</h6>
                            </div>
                            <div class="stats-small__data">
                                {{-- <span class="stats-small__percentage stats-small__percentage--decrease">3.8%</span> --}}
                            </div>
                        </div>
                        <canvas height="120" class="blog-overview-stats-small-3"></canvas>
                    </div>
                </div>
            </div>
            </div>
    
            <div class="row">
    
            
            <div class="col">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                          Histori Transaksi
                        </div>
                        <div class="card-body p-0 pb-3 text-center">
                            <table class="table mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="border-0">Kode Transaksi</th>
                                        <th scope="col" class="border-0">Tanggal</th>
                                        <th scope="col" class="border-0">Nasabah</th>
                                        <th scope="col" class="border-0">Tarik</th>
                                        <th scope="col" class="border-0">Masuk</th>
                                        <th scope="col" class="border-0">Saldo</th>
                                        <th scope="col" class="border-0">Pengelola</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (\App\Simpanan::get() as $simpanan)
                                    <tr>
                                        <td>{{ $simpanan->kode_transaksi }}</td>
                                        <td>{{ $simpanan->tanggal }}</td>
                                        <td>{{ $simpanan->user->name }}</td>
                                        <td>{{ number_format($simpanan->debit, 2) }}</td>
                                        <td>{{ number_format($simpanan->kredit, 2) }}</td>
                                        <td>{{ number_format($simpanan->saldo, 2) }}</td>
                                        <td>{{ $simpanan->pengelola }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-right mr-2 mt-2">
                                <vue-pagination :data="simpanan" v-on:pagination-change-page="getSimpanan" :limit="1"></vue-pagination>
                            </div>
                        </div>
    
    
                      
                    </div>
                </div>
    
    
            </div>
        </div>
    @endhasanyrole
    <!-- End Small Stats Blocks -->
   
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/shards-ui@latest/dist/js/shards.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sharrre/2.0.1/jquery.sharrre.min.js"></script>
<script src="{{ asset('shards/scripts/extras.1.0.0.min.js') }}"></script>
<script src="{{ asset('shards/scripts/shards-dashboards.1.0.0.min.js') }}"></script>
<script src="{{ asset('shards/scripts/app/app-blog-overview.1.0.0.js') }}"></script>
@endpush