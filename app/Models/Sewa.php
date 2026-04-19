<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    protected $table = "sewa";
    protected $guarded = ['id'];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }
    
    protected static function booted()
    {
        static::deleted(function ($sewa) {
            Monitoring::where('id_sewa', $sewa->id)->delete();
        });
    }
}
