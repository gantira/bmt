<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    public $fillable = [
        'user_id', 'jenis', 'kode_transaksi', 'debit', 'kredit', 'saldo', 'tanggal', 'pengelola',
    ];

    public function setKodeTransaksiAttribute($value)
    {
        $no = \App\Simpanan::where('jenis', $value)->count()+1;

        if (strlen($no) == 1) {
            $no = '00' . $no;
        } elseif (strlen($no) == 2) {
            $no = '0'. $no;
        }

        return $this->attributes['kode_transaksi'] = $value . '-' . $no;
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function scopeSearch($query, $q)
    {
        return $query->whereHas('user', function($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%')
                        ->orWhere('no_anggota', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%');
                });
    }
}