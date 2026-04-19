<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Monitoring;
use App\Models\Pengaturan;
use App\Models\Sewa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PengaturanController extends Controller
{
    public function kirim_telegram($id_telegram, $pesan)
    {
        $token = "8089204138:AAHzC-z59DZM8j-Z3vklV1Jtr36Z5LwVJFs";

        // Ambil konten update dari Telegram
        $chat_id = $id_telegram;
        $message = $pesan;

        $response = Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chat_id,
            'text' => $message,
        ]);

        if ($response->successful()) {
            return 1;
        } else {
            return 0;
        }
    }


    public function proses_data(Request $request)
    {
        $longitude = floatval($request->input('longitude'));
        $latitude = floatval($request->input('latitude'));
        $id_alat = $request->input('id_kendaraan');
        $waktu_aktif = Carbon::now();

        Log::info("📡 [$id_alat] Posisi: $latitude, $longitude");

        // Ambil sewa aktif (bukan hanya berdasarkan ID terbaru)
        $sewa = Sewa::where('id_kendaraan', $id_alat)
            ->where('tanggal_mulai', '<=', $waktu_aktif)
            ->where('tanggal_selesai', '>=', $waktu_aktif)
            ->orderBy('id', 'desc')
            ->first();

        if (!$sewa) {
            return response()->json([
                'status' => false,
                'message' => "Kendaraan Tidak Sedang Disewa",
                'data' => [
                    'status_lokasi' => false,
                    'status_waktu' => false,
                    'relay_status' => 'putus',
                    'status_buzzer' => false
                ]
            ], 200);
        }

        $waktu_mulai = Carbon::parse($sewa->tanggal_mulai);
        $waktu_selesai = Carbon::parse($sewa->tanggal_selesai);
        $sekarang = Carbon::now();

        // Cek lokasi dari polygon
        $csvFile = public_path('titik_batas_palembang.csv');
        $polygon = [];

        if (($handle = fopen($csvFile, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $lat = floatval($data[1]);
                $lng = floatval($data[0]);
                $polygon[] = [$lng, $lat];
            }
            fclose($handle);
        }
        if ($polygon[0] !== end($polygon)) {
            $polygon[] = $polygon[0];
        }

        $point = [$longitude, $latitude];
        $status_lokasi = $this->isPointInPolygon($point, $polygon);
        $status_waktu = $sekarang->between($waktu_mulai, $waktu_selesai);
        $selisih_menit = $sekarang->floatDiffInMinutes($waktu_selesai, false);

        $monitoring = Monitoring::where('id_kendaraan', $id_alat)->first();
        $status_sebelumnya = $monitoring?->is_inside;
        $id_tele = $sewa->pengguna?->id_telegram;

        // Kirim Telegram hanya sekali
        if (round($selisih_menit) <= 20 && $sewa->sudah_dikirim_notifikasi == 0) {
            $this->kirim_telegram($id_tele, "Waktu sewa akan habis dalam 20 menit. Silakan segera kembalikan kendaraan.");
            $sewa->update(['sudah_dikirim_notifikasi' => 1]);
        }

        if ($status_waktu === false && $sewa->sudah_dikirim_notifikasi == 0) {
            $this->kirim_telegram($id_tele, "️Waktu sewa telah habis. Harap segera kembalikan kendaraan.");
            $sewa->update(['sudah_dikirim_notifikasi' => 1]);
        }

           // Notifikasi keluar geofence
        if (!is_null($status_sebelumnya) && $status_sebelumnya !== $status_lokasi) {
            if (!$status_lokasi && $sewa->sudah_dikirim_notifikasi_lokasi == 0) {
                $this->kirim_telegram($id_tele, "Kendaraan keluar dari area palembang!");
                $sewa->update(['sudah_dikirim_notifikasi_lokasi' => 1]);
            }
        }
        

        // Simpan lokasi ke history
        History::create([
            'id_alat' => $id_alat,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'waktu_aktif' => $waktu_aktif
        ]);

        // Update atau buat monitoring
        if (!$monitoring) {
            Monitoring::create([
                'id_kendaraan' => $id_alat,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'id_sewa' => $sewa->id,
                'is_inside' => $status_lokasi,
                'created_by' => 1
            ]);
        } else {
            $monitoring->update([
                'longitude' => $longitude,
                'latitude' => $latitude,
                'id_sewa' => $sewa->id,
                'is_inside' => $status_lokasi,
                'created_by' => 1
            ]);
        }

        // 🚨 Logika buzzer hanya tergantung kondisi, TIDAK tergantung flag notifikasi
        $status_buzzer = (
            ($status_waktu && $selisih_menit <= 10) ||
            !$status_lokasi
        );

        return response()->json([
            'status' => true,
            'message' => "Data berhasil diproses",
            'data' => [
                'status_lokasi' => $status_lokasi,
                'status_waktu' => $status_waktu,
                'relay_status' => ($status_lokasi && $status_waktu) ? 'nyambung' : 'putus',
                'status_buzzer' => $status_buzzer
            ]
        ], 200);
    }


    function isPointInPolygon($point, $polygon)
    {
        $x = $point[0];
        $y = $point[1];

        $inside = false;
        $n = count($polygon);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i][0];
            $yi = $polygon[$i][1];
            $xj = $polygon[$j][0];
            $yj = $polygon[$j][1];

            $intersect = (($yi > $y) != ($yj > $y)) &&
                ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi + 0.0000001) + $xi);
            if ($intersect) $inside = !$inside;
        }

        return $inside;
    }

    public function apiShow($id)
    {
        $monitoring = Monitoring::where('id_kendaraan', '=', $id)->first();

        if (!$monitoring) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => true,
            'latitude' => $monitoring->latitude,
            'longitude' => $monitoring->longitude,
        ]);
    }
}
