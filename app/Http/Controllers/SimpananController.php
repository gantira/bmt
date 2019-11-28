<?php

namespace App\Http\Controllers;

use App\Simpanan;
use Illuminate\Http\Request;
use Auth;

class SimpananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('simpanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $saldo = Simpanan::whereUserId($request->user_id)->sum('debit') - Simpanan::whereUserId($request->user_id)->sum('kredit');

        $simpanan = new Simpanan;
        $simpanan->fill($request->all());
        $simpanan->saldo = $saldo + $request->debit;
        $simpanan->pengelola = Auth::user()->name;
        $simpanan->save();

        return $simpanan; 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Simpanan  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function show(Simpanan $simpanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Simpanan  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function edit(Simpanan $simpanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Simpanan  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $saldo = Simpanan::whereUserId($request->user_id)->sum('debit') - Simpanan::whereUserId($request->user_id)->sum('kredit');

        $simpanan = Simpanan::find($id);
        $simpanan->saldo = $saldo + $request->debit;
        $simpanan->fill($request->except('kode_transaksi'));
        $simpanan->save();

        return $simpanan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Simpanan  $simpanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Simpanan $simpanan)
    {
        //
    }

    public function report(Request $request)
    {
        $data['report'] = Simpanan::whereBetween('tanggal', [$request->tgl_awal, $request->tgl_akhir])->where('user_id', 'like', '%'.$request->user_id)->get();
        $data['periode'] = $request->tgl_awal . ' - ' . $request->tgl_akhir;
        
        return view('simpanan.report', $data);
    }

    public function struk($id)
    {
        $data['struk'] = Simpanan::find($id);

        return view('simpanan.struk', $data);
    }
}
