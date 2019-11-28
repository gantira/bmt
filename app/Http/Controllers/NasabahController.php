<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class NasabahController extends Controller
{
    public function index()
    {
        return view('nasabah.index');
    }

    public function store(UserRequest $request)
    {
        $user = new User;
        $user->fill($request->all());

        if($request->get('foto')) {
            $image = $request->get('foto');
            $user->foto = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('foto'))->save(public_path('images/').$user->foto);
        }

        $user->save();
        $user->assignRole('nasabah');

        return $user;
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->except('kode_transaksi'));

        if($request->get('foto')) {
            $image = $request->get('foto');
            $user->foto = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('foto'))->save(public_path('images/').$user->foto);
        }
        $user->save();

        return $user;
    }
}
