<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kendaraan::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; flex-wrap: nowrap;">
            <a href="' . route('kendaraans.edit', $row->id) . '" class="btn btn-info btn-sm" style="white-space: nowrap;">Edit</a>
            <form action="' . route('kendaraans.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus kendaraan ini?\')" style="margin: 0; display: inline;">
                ' . csrf_field() . '
                ' . method_field("DELETE") . '
                <button type="submit" class="btn btn-danger btn-sm" style="white-space: nowrap;">Delete</button>
            </form>
        </div>
    ';
                })

                ->addColumn('foto', function ($row) {
                    $src = asset('storage/kendaraans/' . $row->foto);
                    return '<img src="' . $src . '"
                     onclick="showImagePreview(this)"
                     alt="Foto Kendaraan"
                     title="' . $row->foto . '"
                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); cursor: pointer; display: block; margin: auto;" />';
                })

                ->rawColumns(['action', 'foto'])
                ->make(true);
        }

        return view('kendaraans.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kendaraans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'tipe_kendaraan' => 'required',
        'nomor_kendaraan' => 'required|unique:kendaraan,nomor_kendaraan',
        'foto' => 'required|file|mimes:jpg,jpeg,png|max:5012',
        'status_kendaraan' => 'required'
    ]);

    $input = $request->all();
    
    // Path untuk menyimpan file di public_html/storage/kendaraans
    $storagePath = base_path('../public_html/storage/kendaraans');
    
    // Pastikan folder exists
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $customFileName = time() . '_' . $file->getClientOriginalName();
        
        // Move file to the new location
        $file->move($storagePath, $customFileName);
        $input['foto'] = $customFileName;
    }

    Kendaraan::create($input);
    return redirect()->route('kendaraans.index')
        ->with('success', 'Kendaraan berhasil ditambahkan.');
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('kendaraans.edit', compact('kendaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Kendaraan $kendaraan)
{
    $request->validate([
        'tipe_kendaraan' => 'required',
        'nomor_kendaraan' => 'required',
        'status_kendaraan' => 'required',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = $request->only(['tipe_kendaraan', 'nomor_kendaraan', 'status_kendaraan']);

    // Path untuk menyimpan file di public_html/storage/kendaraans
    $storagePath = base_path('../public_html/storage/kendaraans');
    
    // Pastikan folder exists
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    // Jika ada foto baru
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($kendaraan->foto && file_exists($storagePath.'/'.$kendaraan->foto)) {
            unlink($storagePath.'/'.$kendaraan->foto);
        }

        // Simpan foto baru
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move($storagePath, $fileName);

        $data['foto'] = $fileName;
    }

    $kendaraan->update($data);

    return redirect()->route('kendaraans.index')
        ->with('success', 'Kendaraan berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kendaraan $kendaraan)
{
    // Path untuk file di public_html
    $storagePath = base_path('../public_html/storage/kendaraans');

    // Hapus file foto jika ada
    if ($kendaraan->foto) {
        $fotoPath = $storagePath . '/' . $kendaraan->foto;
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }

    // Hapus data di tabel lain yang terkait dengan kendaraan ini
    DB::table('sewa')->where('id_kendaraan', $kendaraan->id)->delete();
    DB::table('monitoring')->where('id_kendaraan', $kendaraan->id)->delete();
    // DB::table('history')->where('id_kendaraan', $kendaraan->id)->delete();

    // Hapus kendaraan
    $kendaraan->delete();

    return redirect()->route('kendaraans.index')
        ->with('success', 'Kendaraan berhasil dihapus.');
}


    /**
     * Nonaktifkan kendaraan.
     */
    public function nonaktif($id)
    {
        Kendaraan::where('id', $id)->update([
            'status_kendaraan' => 'tidak aktif'
        ]);

        return redirect()->route('kendaraans.index')
            ->with('success', 'Kendaraan dinonaktifkan.');
    }

    /**
     * Aktifkan kendaraan.
     */
    public function aktif($id)
    {
        Kendaraan::where('id', $id)->update([
            'status_kendaraan' => 'aktif'
        ]);

        return redirect()->route('kendaraans.index')
            ->with('success', 'Kendaraan diaktifkan.');
    }
}
