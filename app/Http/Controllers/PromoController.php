<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Http\Requests\StorePromoRequest;
use App\Http\Requests\UpdatePromoRequest;
use App\Models\Barang;
use App\Models\Jadwal;
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

        // $data = $request->all();
        $date_start = $this->conv($request->datestart, $request->clockstart);
        $date_end = $this->conv($request->dateend, $request->clockend);
        $days = $this->detailed_day($request->rep, $request);

        $jadwal = new Jadwal;
        $jadwal->id = $id_jadwal;
        $jadwal->freq = $request->rep;
        $jadwal->day_no = $days;
        $jadwal->start_date = $date_start;
        $jadwal->end_date = $date_end;
        $jadwal->save();


        $promo = new Promo;
        $promo->nama_promo = $request->nama_promo;
        $promo->kode_brg = $request->barang;
        $promo->diskon = $request->diskon;
        $promo->qty_brg = $request->qty_brg;
        $promo->jadwal_id = $id_jadwal;
        $promo->save();

        // dd($days);
        redirect('promo');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        //
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
        $data['promo'] = DB::table('promos')->join('barangs', 'barangs.id', '=', 'promos.kode_brg')->join('jadwals', 'jadwals.id', '=', 'promos.jadwal_id')->where('promos.id', $id)->get(['promos.*', 'barangs.nama_brg', 'barangs.harga', 'jadwals.freq', 'jadwals.day_no', 'jadwals.start_date', 'jadwals.end_date']);
        return view('promo.ubahPromoV', compact('data'));
        // dd($data['promo']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePromoRequest  $request
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function perbaharui(UpdatePromoRequest $request, Promo $promo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        //
    }
}
