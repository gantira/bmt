<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Simpanan;
use App\User;

class SimpananController extends Controller
{
    public function index(Request $request)
    {
        return Simpanan::with('user')->search($request->q)->orderBy('id', 'desc')->paginate(5);
    }

    public function create()
    {
        return User::role('nasabah')->get();
    }

    public function destroy($id)
    {
        return Simpanan::destroy($id);
    }

    public function show($id)
    {
        return Simpanan::find($id); 
    }
}
