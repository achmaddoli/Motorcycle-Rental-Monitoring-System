<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only(
            'email',
            'password'
        );
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('You have
Successfully loggedin');
        }

        return redirect("login")->withSuccess('Oppes!
You have entered invalid credentials');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $check = $this->create($data);

        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
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

    public function dashboard()
    {
        if (Auth::check()) {
            // Koordinat polygon (format: [longitude, latitude])


            $sub = Monitoring::select('id_kendaraan', DB::raw('MAX(created_at) as latest'))
                ->groupBy('id_kendaraan');

            $data = Monitoring::joinSub($sub, 'latest_monitoring', function ($join) {
                $join->on('monitoring.id_kendaraan', '=', 'latest_monitoring.id_kendaraan')
                    ->on('monitoring.created_at', '=', 'latest_monitoring.latest');
            })
                ->with(['kendaraan', 'sewa.pengguna']) // tambahkan relasi yang dibutuhkan
                ->get()
                ->map(function ($item) {
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



            // Ambil token bot




            return view('auth.dashboard', compact('data'));
        }

        return redirect("login")->withSuccess('Opps!
You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
