<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Dp_employee extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'dp_employee';
    protected $fillable = [
        'id',
        'nik',
        'id_dept',
        'dp_from','id_dp_from','periode','periode_expired','tgl','tgl_expired','status','created_by','created_date','tgl_akhir_kontrak'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];
    
}
