<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query_data = new Pengguna();

            if ($request->sSearch) {
                $search_value = '%' . $request->sSearch . '%';
                $query_data = $query_data->where(function ($query) use ($search_value) {
                    $query->where('nama', 'like', $search_value)
                        ->orWhere('alamat', 'like', $search_value);
                });
            }

            $data = $query_data->orderBy('nama', 'asc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
        <div style="display: flex; justify-content: center; align-items: center; gap: 6px; flex-wrap: nowrap;">
            <a href="' . route('penggunas.edit', $row->id) . '" class="btn btn-info btn-sm"" style="white-space: nowrap;">Edit</a>
            <form action="' . route('penggunas.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus pengguna ini?\')" style="margin: 0; display: inline;">
                ' . csrf_field() . method_field('DELETE') . '
                <button type="submit" class="btn btn-danger btn-sm" style="white-space: nowrap;">Delete</button>
            </form>
        </div>
    ';
                })
                ->addColumn('foto_pelanggan', function ($row) {
                    $fotoUrl = asset('storage/penggunas/' . $row->foto_pelanggan);
                    return '<img src="' . $fotoUrl . '"
                 alt="Foto Pelanggan"
                 onclick="showImagePreview(this)"
                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s; cursor: pointer; display: block; margin: auto;"
                 onmouseover="this.style.transform=\'scale(1.05)\'"
                 onmouseout="this.style.transform=\'scale(1)\'" />';
                })
                ->addColumn('file_ktp', function ($row) {
                    $ktpUrl = asset('storage/penggunas/' . $row->file_ktp);
                    return '<img src="' . $ktpUrl . '"
                 alt="File KTP"
                 onclick="showImagePreview(this)"
                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #ccc; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s; cursor: pointer; display: block; margin: auto;"
                 onmouseover="this.style.transform=\'scale(1.05)\'"
                 onmouseout="this.style.transform=\'scale(1)\'" />';
                })

                ->rawColumns(['action', 'foto_pelanggan', 'file_ktp'])
                ->make(true);
        }

        return view('penggunas.index');
    }


    public function create()
    {
        return view('penggunas.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required|unique:penggunas,no_hp',
        'id_telegram' => 'required|numeric|unique:penggunas,id_telegram',
        'foto_pelanggan' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'file_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'id_telegram.unique' => 'ID Telegram ini sudah digunakan oleh pengguna lain.',
        'id_telegram.required' => 'ID Telegram wajib diisi.',
        'id_telegram.numeric' => 'ID Telegram harus berupa angka.',
         'no_hp.unique' => 'Nomor HP ini sudah digunakan oleh pengguna lain.',
            'no_hp.required' => 'No HP wajib diisi.',
    ]);

    $input = $request->all();

    // Path untuk menyimpan file di public_html/storage/penggunas
    $storagePath = base_path('../public_html/storage/penggunas');
    
    // Pastikan folder exists
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    if ($request->hasFile('foto_pelanggan')) {
        $file = $request->file('foto_pelanggan');
        $customFileName = time() . '_foto_' . $file->getClientOriginalName();
        $file->move($storagePath, $customFileName);
        $input['foto_pelanggan'] = $customFileName;
    }

    if ($request->hasFile('file_ktp')) {
        $filektp = $request->file('file_ktp');
        $customFileNameFileKtp = time() . '_ktp_' . $filektp->getClientOriginalName();
        $filektp->move($storagePath, $customFileNameFileKtp);
        $input['file_ktp'] = $customFileNameFileKtp;
    }

    Pengguna::create($input);

    return redirect()->route('penggunas.index')
        ->with('success', 'Pengguna berhasil ditambahkan.');
}

    public function show(Pengguna $pengguna)
    {
        return view('penggunas.show', compact('pengguna'));
    }

    public function edit(Pengguna $pengguna)
    {
        return view('penggunas.edit', compact('pengguna'));
    }

   public function update(Request $request, Pengguna $pengguna)
{
    $request->validate([
        'nama' => 'required',
        'alamat' => 'required',
         'no_hp' => 'required|unique:penggunas,no_hp,' . $pengguna->id,
        'id_telegram' => 'required|numeric|unique:penggunas,id_telegram,' . $pengguna->id,
        'foto_pelanggan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'file_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ], [
        'id_telegram.unique' => 'ID Telegram ini sudah digunakan oleh pengguna lain.',
        'id_telegram.required' => 'ID Telegram wajib diisi.',
        'id_telegram.numeric' => 'ID Telegram harus berupa angka.',
         'no_hp.unique' => 'No HP ini sudah digunakan oleh pengguna lain.',
    ]);

    $data = $request->all();

    // Path untuk menyimpan file di public_html/storage/penggunas
    $storagePath = base_path('../public_html/storage/penggunas');
    
    // Pastikan folder exists
    if (!file_exists($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    // Update foto jika ada
    if ($request->hasFile('foto_pelanggan')) {
        // Hapus file lama jika ada
        if ($pengguna->foto_pelanggan && file_exists($storagePath.'/'.$pengguna->foto_pelanggan)) {
            unlink($storagePath.'/'.$pengguna->foto_pelanggan);
        }
        
        $file = $request->file('foto_pelanggan');
        $customFileName = time() . '_foto_' . $file->getClientOriginalName();
        $file->move($storagePath, $customFileName);
        $data['foto_pelanggan'] = $customFileName;
    }

    // Update file KTP jika ada
    if ($request->hasFile('file_ktp')) {
        // Hapus file lama jika ada
        if ($pengguna->file_ktp && file_exists($storagePath.'/'.$pengguna->file_ktp)) {
            unlink($storagePath.'/'.$pengguna->file_ktp);
        }
        
        $filektp = $request->file('file_ktp');
        $customFileNameKtp = time() . '_ktp_' . $filektp->getClientOriginalName();
        $filektp->move($storagePath, $customFileNameKtp);
        $data['file_ktp'] = $customFileNameKtp;
    }

    $pengguna->update($data);

    return redirect()->route('penggunas.index')
        ->with('success', 'Pengguna berhasil diperbarui.');
}

    public function destroy(Pengguna $pengguna)
{
    // Path penyimpanan file di public_html
    $storagePath = base_path('../public_html/storage/penggunas');

    // Hapus foto pelanggan jika ada
    if (!empty($pengguna->foto_pelanggan)) {
        $fotoPath = $storagePath . '/' . $pengguna->foto_pelanggan;
        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }

    // Hapus file KTP jika ada
    if (!empty($pengguna->file_ktp)) {
        $ktpPath = $storagePath . '/' . $pengguna->file_ktp;
        if (file_exists($ktpPath)) {
            unlink($ktpPath);
        }
    }

    // Hapus data dari database
    $pengguna->delete();

    return redirect()->route('penggunas.index')
        ->with('success', 'Pengguna berhasil dihapus.');
}
}
