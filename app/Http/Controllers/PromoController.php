<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Promo;
use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\Barang;
use App\Models\Jadwal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['judul'] = 'Buat Promo';
        $data['promo'] = DB::Table('Promos')->leftJoin('barangs', 'barangs.id', '=', 'promos.kode_brg')->leftJoin('jadwals', 'jadwals.id', '=', 'promos.jadwal_id')->get(['promos.*', 'barangs.nama_brg', 'barangs.harga', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        return view('promo.promoV', ['data' => $data]);
        // dd($data['promo']);
    }

    public function getAll()
    {
        $data = DB::Table('Promos')->leftJoin('barangs', 'barangs.id', '=', 'promos.kode_brg')->leftJoin('jadwals', 'jadwals.id', '=', 'promos.jadwal_id')->get(['promos.*', 'barangs.nama_brg', 'barangs.harga', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        if ($data) {
            return ApiResponse::createApi(200, 'Berhasil', $data);
        } else {
            return ApiResponse::createApi(400, 'Gagal');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
        $data['judul'] = 'Buat Promo';
        $data['barang'] = Barang::all();
        return view('promo.tambahPromoV', ['data' => $data]);
    }

    public function conv($data, $clock)
    {
        $dat = \Carbon\Carbon::createFromFormat('d/m/Y', $data);
        $date = date_format($dat, "m/d/Y");

        $timestamp = $date . " " . $clock;

        $time = strtotime($timestamp);
        return $time;
    }

    public function detailed_day($rep, $req)
    {
        if ($rep == 2) {
            $hasil = implode(' ', $req->day);
        } elseif ($rep == 1) {
            $dat = \Carbon\Carbon::createFromFormat('d/m/Y', $req->datestart);
            $hasil = date_format($dat, 'N');
        }

        return $hasil;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePromoRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'nama_promo' => 'required|unique:promos,nama_promo',
                'barang' => 'required',
                'diskon' => 'required',
                'qty_brg' => 'required',
                'rep' => 'required',
            ]);

            $id_jadwal = uniqid();

            $date_start = $this->conv($request->datestart, $request->clockstart);
            $date_end = $this->conv($request->dateend, $request->clockend);
            $days = $this->detailed_day($request->rep, $request);

            $jadwal = Jadwal::create([
                'id' => $id_jadwal,
                'freq' => $request->rep,
                'day_no' => $days,
                'start_date' => $date_start,
                'end_date' => $date_end,
            ]);

            $promo = Promo::create([
                'nama_promo' => $request->nama_promo,
                'kode_brg' => $request->barang,
                'diskon' => $request->diskon,
                'qty_brg' => $request->qty_brg,
                'jadwal_id' => $id_jadwal,
            ]);

            $data = Promo::where("id", "=", $promo->id)->get();

            if ($data) {
                return ApiResponse::createApi(200, 'Data berhasil ditambahkan!', $data);
            } else {
                return ApiResponse::createApi(400, 'Gagal');
            }
        } catch (Exception $error) {
            return ApiResponse::createApi(400, 'Gagal', $error);
        }
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'nama_promo' => 'required|unique:promos,nama_promo',
            'barang' => 'required',
            'diskon' => 'required',
            'qty_brg' => 'required',
            'rep' => 'required',
        ]);

        $id_jadwal = uniqid();

        $date_start = $this->conv($request->datestart, $request->clockstart);
        $date_end = $this->conv($request->dateend, $request->clockend);
        $days = $this->detailed_day($request->rep, $request);

        $jadwal = new Jadwal;
        $jadwal->id = $id_jadwal;
        $jadwal->freq = $request->rep;
        $jadwal->day_no = $days;
        $jadwal->start_date = $date_start;
        $jadwal->end_date = $date_end;

        $promo = new Promo;
        $promo->nama_promo = $request->nama_promo;
        $promo->kode_brg = $request->barang;
        $promo->diskon = $request->diskon;
        $promo->qty_brg = $request->qty_brg;
        $promo->jadwal_id = $id_jadwal;

        $jadwal->save();
        $promo->save();

        return redirect('promo')->with('pesan', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = Promo::find($request->id);
        // return response()->json($data);
        // return json_encode($data);
        if ($data) {
            return ApiResponse::createApi(200, 'Berhasil', $data);
        } else {
            return ApiResponse::createApi(400, 'Gagal');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function ubah($id)
    {
        $data['judul'] = 'Ubah Promo';
        $gabung = DB::table('promos')->join('barangs', 'barangs.id', '=', 'promos.kode_brg')->join('jadwals', 'jadwals.id', '=', 'promos.jadwal_id')->where('promos.id', $id)->get(['promos.*', 'barangs.nama_brg', 'barangs.harga', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        $data['promo'] = $gabung;
        $data['hari'] = explode(' ', $gabung[0]->day_no);

        return view('promo.ubahPromoV', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePromoRequest  $request
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function perbaharui(Request $request)
    {
        $date_start = $this->conv($request->datestart, $request->clockstart);
        $date_end = $this->conv($request->dateend, $request->clockend);
        $days = $this->detailed_day($request->rep, $request);

        $jadwal = Jadwal::find($request->id_jadwal);
        $jadwal->freq = $request->rep;
        $jadwal->day_no = $days;
        $jadwal->start_date = $date_start;
        $jadwal->end_date = $date_end;

        $promo = Promo::find($request->id_promo);
        $promo->nama_promo = $request->nama_promo;
        $promo->kode_brg = $request->barang;
        $promo->diskon = $request->diskon;
        $promo->qty_brg = $request->qty_brg;

        $jadwal->save();
        $promo->save();

        return redirect('promo')->with('pesan', 'Data berhasil diubah!');
    }

    public function update(Request $request)
    {
        $gabung = DB::table('promos')->join('barangs', 'barangs.id', '=', 'promos.kode_brg')->join('jadwals', 'jadwals.id', '=', 'promos.jadwal_id')->where('promos.id', $request->id)->get(['promos.*', 'barangs.nama_brg', 'barangs.harga', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        // try {
        //     $this->validate($request, [
        //         'nama_promo' => 'required|unique:promos,nama_promo',
        //         'barang' => 'required',
        //         'diskon' => 'required',
        //         'qty_brg' => 'required',
        //         'rep' => 'required',
        //     ]);

        //     $jadwal_lama = Jadwal::findOrFail($gabung->jadwal_id);
        //     $promo_lama = Promo::findOrFail($request->id);

        //     $date_start = $this->conv($request->datestart, $request->clockstart);
        //     $date_end = $this->conv($request->dateend, $request->clockend);
        //     $days = $this->detailed_day($request->rep, $request);

        //     $jadwal_lama->update([
        //         'freq' => $request->rep,
        //         'day_no' => $days,
        //         'start_date' => $date_start,
        //         'end_date' => $date_end,
        //     ]);

        //     $promo_lama->update([
        //         'nama_promo' => $request->nama_promo,
        //         'kode_brg' => $request->barang,
        //         'diskon' => $request->diskon,
        //         'qty_brg' => $request->qty_brg,
        //     ]);

        //     $data = Promo::where("id", "=", $promo_lama->id)->get();

        //     if ($data) {
        //         return ApiResponse::createApi(200, 'Data berhasil ditambahkan!', $data);
        //     } else {
        //         return ApiResponse::createApi(400, 'Gagal');
        //     }
        // } catch (Exception $error) {
        //     return ApiResponse::createApi(400, 'Gagal', $error);
        // }
        return response()->json($gabung);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $data = Promo::find($id);
        $jadwal = Jadwal::find($data->jadwal_id);
        $data->delete();
        $jadwal->delete();
        return redirect('promo')->with('pesan', 'Data berhasil dihapus!');
    }

    public function destroy(Request $request)
    {
        $data = Promo::find($request->id);
        $jadwal = Jadwal::find($data->jadwal_id);
        $data->delete();
        $jadwal->delete();
        if ($data) {
            return ApiResponse::createApi(200, 'Data berhasil dihapus!', $data);
        } else {
            return ApiResponse::createApi(400, 'Gagal');
        }
    }
}
