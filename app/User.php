<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'foto', 'kelamin', 'identitas', 'no_identitas', 'agama', 'alamat', 'no_anggota', 'status'
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = bcrypt($value);
    }

    public function setNoAnggotaAttribute($value)
    {
        $no = \App\User::max('id')+1;
        $tgl = \Carbon\Carbon::now()->format('ymd');

        if (strlen($no) == 1) {
            $no = '00' . $no;
        } elseif (strlen($no) == 2) {
            $no = '0'. $no;
        }

        return $this->attributes['no_anggota'] = 'BMTIM-' . $tgl . '-' . $no;
    }

    public function scopeSearch($query, $q)
    {
        return $query->where('name', 'like', '%' . $q . '%')
                        ->orWhere('no_anggota', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%');
    }

    public function simpanan()
    {
        return $this->hasMany(Simpanan::class);
    }

    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }

    public function penarikan()
    {
        return $this->hasMany(Simpanan::class);
    }
}
