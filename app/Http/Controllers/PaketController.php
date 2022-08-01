<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\paket;
use App\Http\Requests\StorepaketRequest;
use App\Http\Requests\UpdatepaketRequest;
use App\Models\Barang;
use App\Models\Jadwal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['judul'] = 'Daftar Paket';
        $data['paket'] = DB::Table('pakets')->leftJoin('jadwals', 'jadwals.id', '=', 'pakets.jadwal_id')->get(['pakets.*', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        return view('paket.paketV', ["data" => $data]);
    }

    public function getAll()
    {
        $data = paket::all();
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
        $data['judul'] = 'Tambah Paket';
        $data['barang'] = Barang::all();
        return view('paket.tambahPaketV', ["data" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepaketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'nama_paket' => 'required|unique:pakets,nama_paket',
                'kode_paket' => 'required|unique:pakets,kode_paket',
                'barang_id' => 'required',
                'harga_paket' => 'required',
            ]);

            $id_jadwal = uniqid();
            $kode_pkt = uniqid();

            $date_start = $this->conv($request->datestart, $request->clockstart);
            $date_end = $this->conv($request->dateend, $request->clockend);
            $days = $this->detailed_day($request->rep, $request);
            $barangs = $this->detailed_barang($request->barang_id);

            $jadwal = new Jadwal;
            $jadwal->id = $id_jadwal;
            $jadwal->freq = $request->rep;
            $jadwal->day_no = $days;
            $jadwal->start_date = $date_start;
            $jadwal->end_date = $date_end;

            $paket = new paket;
            $paket->kode_paket = $kode_pkt;
            $paket->nama_paket = $request->nama_paket;
            $paket->harga_paket = $request->harga_paket;
            $paket->barang_id = $barangs;
            $paket->jadwal_id = $id_jadwal;

            $jadwal->save();
            $paket->save();

            $data = paket::where("id", "=", $paket->id)->get();

            if ($data) {
                return ApiResponse::createApi(200, 'Data berhasil ditambahkan!', $data);
            } else {
                return ApiResponse::createApi(400, 'Gagal');
            }
        } catch (Exception $error) {
            return ApiResponse::createApi(400, 'Gagal', $error);
        }
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

    public function detailed_barang($data)
    {
        return implode(' ', $data);
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'nama_paket' => 'required|unique:pakets,nama_paket',
            'barang' => 'required',
            'harga_paket' => 'required',
        ]);

        $id_jadwal = uniqid();
        $kode_pkt = uniqid();

        $date_start = $this->conv($request->datestart, $request->clockstart);
        $date_end = $this->conv($request->dateend, $request->clockend);
        $days = $this->detailed_day($request->rep, $request);
        $barangs = $this->detailed_barang($request->barang);

        $jadwal = new Jadwal;
        $jadwal->id = $id_jadwal;
        $jadwal->freq = $request->rep;
        $jadwal->day_no = $days;
        $jadwal->start_date = $date_start;
        $jadwal->end_date = $date_end;

        $paket = new paket;
        $paket->kode_paket = $kode_pkt;
        $paket->nama_paket = $request->nama_paket;
        $paket->harga_paket = $request->harga_paket;
        $paket->barang_id = $barangs;
        $paket->jadwal_id = $id_jadwal;

        $jadwal->save();
        $paket->save();

        return redirect('paket')->with('pesan', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = paket::find($request->id);
        if ($data) {
            return ApiResponse::createApi(200, 'Berhasil', $data);
        } else {
            return ApiResponse::createApi(400, 'Gagal');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function ubah($id)
    {
        $data['judul'] = 'Ubah Paket';
        $gabung = DB::table('pakets')->join('jadwals', 'jadwals.id', '=', 'pakets.jadwal_id')->where('pakets.id', $id)->get(['pakets.*', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        $data['paket'] = $gabung;
        $data['barang'] = Barang::all();
        $data['hari'] = explode(' ', $gabung[0]->day_no);
        $data['list'] = explode(' ', $gabung[0]->barang_id);
        return view('paket.ubahPaketV', ["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepaketRequest  $request
     * @param  \App\Models\paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $date_start = $this->conv($request->datestart, $request->clockstart);
            $date_end = $this->conv($request->dateend, $request->clockend);
            $days = $this->detailed_day($request->rep, $request);
            $barangs = $this->detailed_barang($request->barang);

            $jadwal = Jadwal::find($request->id_jadwal);
            $jadwal->freq = $request->rep;
            $jadwal->day_no = $days;
            $jadwal->start_date = $date_start;
            $jadwal->end_date = $date_end;

            $paket = paket::find($request->id_paket);
            $paket->nama_paket = $request->nama_paket;
            $paket->harga_paket = $request->harga;
            $paket->barang_id = $barangs;

            $jadwal->save();
            $paket->save();

            $data = paket::where("id", "=", $paket->id)->get();

            if ($data) {
                return ApiResponse::createApi(200, 'Data berhasil diubah!', $data);
            } else {
                return ApiResponse::createApi(400, 'Gagal');
            }
        } catch (Exception $error) {
            return ApiResponse::createApi(400, 'Gagal', $error);
        }
    }

    public function perbaharui(Request $request)
    {
        $date_start = $this->conv($request->datestart, $request->clockstart);
        $date_end = $this->conv($request->dateend, $request->clockend);
        $days = $this->detailed_day($request->rep, $request);
        $barangs = $this->detailed_barang($request->barang);

        $jadwal = Jadwal::find($request->id_jadwal);
        $jadwal->freq = $request->rep;
        $jadwal->day_no = $days;
        $jadwal->start_date = $date_start;
        $jadwal->end_date = $date_end;

        $paket = paket::find($request->id_paket);
        $paket->nama_paket = $request->nama_paket;
        $paket->harga_paket = $request->harga;
        $paket->barang_id = $barangs;

        $jadwal->save();
        $paket->save();
        return redirect('paket')->with('pesan', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\paket  $paket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = paket::find($request->id);
        $jadwal = Jadwal::find($data->jadwal_id);
        $data->delete();
        $jadwal->delete();
        if ($data) {
            return ApiResponse::createApi(200, 'Data berhasil dihapus!', $data);
        } else {
            return ApiResponse::createApi(400, 'Gagal');
        }
    }

    public function hapus($id)
    {
        $data = paket::find($id);
        $jadwal = Jadwal::find($data->jadwal_id);
        $data->delete();
        $jadwal->delete();
        return redirect('paket')->with('pesan', 'Data berhasil dihapus!');
    }
}
