<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Pinjaman;
use App\PinjamanDetail;
use App\User;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pinjaman = Pinjaman::with('user')->search($request->q)->orderBy('id', 'desc')->paginate(5);
        foreach ($pinjaman as $value) {
            $value->sudah_bayar = $value->detail()->sum('bayar_bulanan'); 
            $value->sisa_bayar = $value->jumlah - $value->detail()->sum('bayar_bulanan'); 
        }

        return $pinjaman; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return User::role('nasabah')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return PinjamanDetail::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Pinjaman::find($id); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['info'] = Pinjaman::with('user')->find($id);
        $data['detail'] = PinjamanDetail::wherePinjamanId($id)->get();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Pinjaman::destroy($id);
    }
}