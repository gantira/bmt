<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pinjaman;
use App\Simpanan;
use App\User;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        return view('laporan.index');
    }
    public function simpanan(Request $request)
    {
        $data['simpanan'] = Simpanan::orderBy('id', 'desc')->get();
        $data['nasabah'] = User::role('nasabah')->get();
        
        return view('laporan.simpanan', $data);
    }

    public function penarikan(Request $request)
    {
        $data['penarikan'] = Simpanan::orderBy('id', 'desc')->get();
        $data['nasabah'] = User::role('nasabah')->get();

        return view('laporan.penarikan', $data);
    }

    public function pinjaman(Request $request)
    {
        $pinjaman = Pinjaman::with(['user'])->search($request->q)->orderBy('id', 'desc')->paginate(5);
        foreach ($pinjaman as $value) {
            $value->sudah_bayar = $value->detail()->sum('bayar_bulanan'); 
            $value->sisa_bayar = $value->jumlah - $value->detail()->sum('bayar_bulanan'); 
        }

        $data['pinjaman'] = $pinjaman;
        $data['nasabah'] = User::role('nasabah')->get();
        
        return view('laporan.pinjaman', $data);
    }
}
