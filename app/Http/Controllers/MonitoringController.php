<?php

namespace App\Http\Controllers;

use App\Models\Monitoring;
use App\Models\Pengguna;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data dengan relasi pengguna dan kendaraan
            $data = Monitoring::whereHas('sewa', function ($query) {
                $query->where('tanggal_mulai', '<=', now());
            })->with(['pengguna', 'kendaraan', 'sewa', 'sewa.pengguna'])->latest()->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pengguna', function ($row) {
                    return $row->sewa?->pengguna?->nama ?? '-';
                })
                ->addColumn('kendaraan', function ($row) {
                    return $row->kendaraan->nomor_kendaraan ?? 'ID: ' . $row->id_kendaraan;
                })
                ->addColumn('status_geofencing', function ($row) {
                    return $row->status_geofencing ?? '-';
                })
                ->addColumn('sisa_waktu', function ($row) {
                    $sewa = $row->sewa;
                    if ($sewa) {
                        $selisih = now()->diffInMinutes($sewa->tanggal_selesai, false);
                        if ($selisih < 0) return 'Sewa sudah selesai';
                        $jam = floor($selisih / 60);
                        $menit = $selisih % 60;
                        return "{$jam} jam {$menit} menit";
                    }
                    return '-';
                })

                  ->addColumn('action', function ($row) {
                    return '
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px;">
            <a href="' . route('monitorings.show', $row->id) . '" class="btn btn-info btn-sm">Show</a>
            <form action="' . route('monitorings.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus data ini?\')" style="margin: 0; display: inline;">
                ' . csrf_field() . '
                ' . method_field("DELETE") . '
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </div>
    ';
                })



                ->rawColumns(['action', 'sisa_waktu'])
                ->make(true);
        }

        $data = Monitoring::with(['kendaraan', 'sewa.pengguna'])->get()->map(function ($item) {
            return [
                'id_kendaraan'   => $item->id_kendaraan,
                'plat_nomor'     => $item->kendaraan?->nomor_kendaraan ?? $item->kendaraan?->plat_nomor ?? '❌',
                'nama_pengguna'  => $item->sewa?->pengguna?->nama ?? '❌',
                'latitude'       => $item->latitude,
                'longitude'      => $item->longitude,
                'tanggal_selesai' => $item->sewa?->tanggal_selesai
                    ? \Carbon\Carbon::parse($item->sewa->tanggal_selesai)->translatedFormat('d F Y H:i')
                    : 'Tidak diketahui',

            ];
        });


        return view('monitorings.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penggunas = Pengguna::all();
        $kendaraans = Kendaraan::all();
        return view('monitorings.create', compact('penggunas', 'kendaraans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'id_kendaraan' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'status_geofencing' => 'nullable|string'
        ]);

        Monitoring::create($request->all());

        return redirect()->route('monitorings.index')
            ->with('success', 'Monitoring created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $monitoring = Monitoring::with(['pengguna', 'kendaraan'])->findOrFail($id);

        if (request()->wantsJson()) {
            return response()->json($monitoring);
        }

        return view('monitorings.show', compact('monitoring'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoring $monitoring)
    {
        $penggunas = Pengguna::all();
        $kendaraans = Kendaraan::all();
        return view('monitorings.edit', compact('monitoring', 'penggunas', 'kendaraans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'id_kendaraan' => 'required',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'status_geofencing' => 'nullable|string'
        ]);

        $monitoring->update($request->all());

        return redirect()->route('monitorings.index')
            ->with('success', 'Monitoring updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        $monitoring->delete();

        return redirect()->route('monitorings.index')
            ->with('success', 'Monitoring deleted successfully');
    }
}
