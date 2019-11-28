<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    public $table = 'pinjamans';
    
    protected $fillable = [
        'user_id', 'kode_transaksi', 'jumlah', 'tanggal' ,  'durasi'
    ];

    public function detail()
    {
        return $this->hasMany(PinjamanDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class)->whereStatus(1);
    }

    public function setKodeTransaksiAttribute($value)
    {
        $no = \App\Pinjaman::max('id')+1;

        if (strlen($no) == 1) {
            $no = '00' . $no;
        } elseif (strlen($no) == 2) {
            $no = '0'. $no;
        }

        return $this->attributes['kode_transaksi'] = $value . '-' . $no;
    }

    public function scopeSearch($query, $q)
    {
        return $query->whereHas('user', function($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                });
    }
}
