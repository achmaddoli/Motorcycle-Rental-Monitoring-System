<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $table = "monitoring";
    protected $guarded = ['id'];

  
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }

    public function sewa()
    {
        return $this->belongsTo(Sewa::class, 'id_sewa');
    }





    public function getSisaWaktuAttribute()
    {
        $sewa = $this->sewa;

        if ($sewa && $sewa->tanggal_selesai) {
            $tanggal_selesai = Carbon::parse($sewa->tanggal_selesai);
            $now = Carbon::now();

            $selisih_detik = $now->diffInSeconds($tanggal_selesai, false);

            if ($selisih_detik <= 0) {
                return '<span class="text-danger">0 jam</span>';
            }

            $jam = floor($selisih_detik / 3600);
            $menit = floor(($selisih_detik % 3600) / 60);

            $output = "{$jam} jam {$menit} menit";

            if ($jam < 1) {
                return '<span class="text-danger">' . $output . '</span>'; // merah kalau < 1 jam
            }

            return $output;
        }

        return '<span class="text-danger">0 jam</span>';
    }
}
