<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Sewa;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class SewaController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sewa::with(['pengguna', 'kendaraan'])->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pengguna', fn($row) => $row->pengguna->nama ?? '-')
                ->addColumn('nomor_hp', fn($row) => $row->pengguna->no_hp ?? '-')
                ->addColumn('plat_kendaraan', fn($row) => $row->kendaraan->nomor_kendaraan ?? '-')
                ->addColumn('action', function ($row) {
                    return '
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; flex-wrap: nowrap;">
            <a href="' . route('sewas.edit', $row->id) . '" class="btn btn-info btn-sm" style="white-space: nowrap;">Edit</a>
            <form action="' . route('sewas.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')" style="margin: 0; display: inline;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn-danger btn-sm" style="white-space: nowrap;">Delete</button>
            </form>
        </div>
    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sewas.index');
    }




    public function create()
    {
        $penggunas = Pengguna::all();
        $kendaraans = Kendaraan::where('status_kendaraan', 'aktif')->get();

        return view('sewas.create', compact('penggunas', 'kendaraans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pengguna' => ['required', 'exists:penggunas,id'],
            'id_kendaraan' => ['required', 'exists:kendaraan,id'],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:' . now()->format('Y-m-d H:i')],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
        ]);

        // Cek apakah kendaraan sudah disewa di rentang tanggal tersebut
        $cekSewa = Sewa::where('id_kendaraan', $validated['id_kendaraan'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('tanggal_mulai', [$validated['tanggal_mulai'], $validated['tanggal_selesai']])
                    ->orWhereBetween('tanggal_selesai', [$validated['tanggal_mulai'], $validated['tanggal_selesai']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('tanggal_mulai', '<=', $validated['tanggal_mulai'])
                            ->where('tanggal_selesai', '>=', $validated['tanggal_selesai']);
                    });
            })
            ->exists();

        if ($cekSewa) {
            return redirect()->back()
                ->withErrors(['id_kendaraan' => 'Kendaraan ini sudah disewa pada rentang tanggal tersebut.'])
                ->withInput();
        }

        // Hitung durasi
        $durasi = Carbon::parse($validated['tanggal_mulai'])
            ->diffInDays(Carbon::parse($validated['tanggal_selesai']));

        // Simpan data
        Sewa::create([
            ...$validated,
            'durasi_penyewaan' => $durasi,
            'sudah_dikirim_notifikasi' => 0, // agar siap menerima notifikasi
        ]);

        return redirect()->route('sewas.index')
            ->with('success', 'Sewa berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Sewa $sewa)
    {
        $sewa->load(['pengguna', 'kendaraan']);
        return view('sewas.show', compact('sewa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sewa $sewa)
    {
        $penggunas = Pengguna::all();
        $kendaraans = Kendaraan::where('status_kendaraan', 'aktif')->get();

        return view('sewas.edit', compact('sewa', 'penggunas', 'kendaraans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sewa $sewa)
    {
        $validated = $request->validate([
            'id_pengguna' => 'required|exists:penggunas,id',
            'id_kendaraan' => 'required|exists:kendaraan,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:now|after_or_equal:tanggal_mulai',
        ]);

        if (Carbon::parse($validated['tanggal_mulai'])->ne(Carbon::parse($sewa->tanggal_mulai))) {
            return redirect()->back()
                ->withErrors(['tanggal_mulai' => 'Tanggal mulai tidak boleh diubah.'])
                ->withInput();
        }

        $durasi = Carbon::parse($validated['tanggal_mulai'])
            ->diffInDays(Carbon::parse($validated['tanggal_selesai']));

        $sewa->update([
            ...$validated,
            'durasi_penyewaan' => $durasi,
            'sudah_dikirim_notifikasi' => 0, // reset jika disunting ulang
        ]);

        return redirect()->route('sewas.index')
            ->with('success', 'Sewa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sewa $sewa)
    {
        $sewa->delete();

        return redirect()->route('sewas.index')
            ->with('success', 'Sewa berhasil dihapus.');
    }
}
