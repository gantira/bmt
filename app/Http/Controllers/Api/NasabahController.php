<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Simpanan;
use App\User;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        return User::role('nasabah')->search($request->q)->orderBy('id', 'desc')->paginate(5);
    }
    
    public function create()
    {
        return User::role('nasabah')->get();
    }

    public function store(UserRequest $request)
    {
        return User::create($request->all());
    }

    public function destroy($id)
    {
        return User::destroy($id);
    }

    public function show($id)
    {
        return User::find($id); 
    }
}
