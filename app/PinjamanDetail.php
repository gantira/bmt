<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinjamanDetail extends Model
{
    public $table = 'pinjaman_details';
    
    protected $fillable = [
        'pinjaman_id', 'bayar_bulanan', 'tanggal' , 
    ];
     
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function scopeSearch($query, $q)
    {
        return $query->whereHas('user', function($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                });
    }
}
