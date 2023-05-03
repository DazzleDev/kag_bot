<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'EMPLOYEE';
    protected $fillable = [
        'EMPLOYEEID',
        'FINGERID',
        'EMNAME',
        'ADDRESS',
        'PHONE',
        'HP','EMAIL','EXT1','EXT2','EXT2','EMERGENCYNAME','EMERGENCYNUMB','STSEM','EMSTART','EMEND','JAMSOSTEKID','PHOTO','FLAKTRIF','GRADEID','DIVISIONID','ASKESID','POSITIONID','IMAGEPATH','TL','STSKAWIN','JK','DEPTID','JNASKES','AGAMA','STAT_SMS','STAT_EMAIL','STAT_PRINT','stat_gaji','ldap','HP2','DIVISI','pwd_ldap','user_ldap','no_casual','tmpt_lahir','kelurahan','kecamatan','rt','rw','dusun','provinsi','kota','update_kartu','baru','nokartu','nokartu_manual','ktp','pot_casual','pendidikan','nama_pt','is_from_finger','is_finish_repair_absen'
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
