<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['judul'] = 'Daftar Barang';
        $data['barang'] = Barang::all();
        return view('barang.barangV', ["data" => $data]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tambah()
    {
        $data['judul'] = 'Tambah Barang';
        return view('barang.tambahBarangV', ["data" => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function simpan(Request $request)
    {
        $this->validate($request, [
            'nama_brg' => 'required|unique:barangs,nama_brg',
            'kategori' => 'required',
            'unit' => 'required',
            'harga' => 'required',
            'qty' => 'required',
        ]);
        Barang::create($request->all());
        return redirect('barang')->with('pesan', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $data = Barang::find($id);
        return json_encode($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function ubah($id)
    {
        $data = Barang::find($id);
        return view('barang.ubahBarangV', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBarangRequest  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function perbaharui(Request $request)
    {
        $barang = Barang::find($request->id);
        $barang->kategori = $request->kategori;
        $barang->nama_brg = $request->nama_brg;
        $barang->unit = $request->unit;
        $barang->harga = $request->harga;
        $barang->qty = $request->qty;
        $barang->save();
        return redirect('barang')->with('pesan', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function hapus($id)
    {
        $data = Barang::find($id);
        $data->delete();
        return redirect('barang')->with('pesan', 'Data berhasil dihapus!');
    }
}
