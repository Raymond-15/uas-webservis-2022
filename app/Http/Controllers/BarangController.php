<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Barang;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Exception;
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
    }

    public function getAll()
    {
        $data = Barang::all();
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

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'nama_brg' => 'required|unique:barangs,nama_brg',
                'kategori' => 'required',
                'unit' => 'required',
                'harga' => 'required',
                'qty' => 'required',
            ]);
            $barang = Barang::create($request->all());

            $data = Barang::where("id", "=", $barang->id)->get();

            if ($data) {
                return ApiResponse::createApi(200, 'Data berhasil ditambahkan!', $data);
            } else {
                return ApiResponse::createApi(400, 'Gagal');
            }
        } catch (Exception $error) {
            return ApiResponse::createApi(400, 'Gagal', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $data = Barang::find($request->id);
        $data = Barang::whereIn('id', $request->id)->get();
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
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function ubah($id)
    {
        $data['judul'] = 'Ubah Barang';
        $data['barang'] = Barang::find($id);
        return view('barang.ubahBarangV', ["data" => $data]);
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

    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'nama_brg' => 'required|unique:barangs,nama_brg',
                'kategori' => 'required',
                'unit' => 'required',
                'harga' => 'required',
                'qty' => 'required',
            ]);
            $barang = Barang::findOrFail($request->id);

            $barang->update([
                'nama_brg' => $request->nama_brg,
                'kategori' => $request->kategori,
                'unit' => $request->unit,
                'harga' => $request->harga,
                'qty' => $request->qty,
            ]);

            $data = Barang::where("id", "=", $barang->id)->get();

            if ($data) {
                return ApiResponse::createApi(200, 'Data berhasil diubah!', $data);
            } else {
                return ApiResponse::createApi(400, 'Gagal');
            }
        } catch (Exception $error) {
            return ApiResponse::createApi(400, 'Gagal', $error);
        }
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

    public function destroy(Request $request)
    {
        $data = Barang::findOrFail($request->id);
        $data->delete();
        if ($data) {
            return ApiResponse::createApi(200, 'Data berhasil dihapus!', $data);
        } else {
            return ApiResponse::createApi(400, 'Gagal');
        }
    }
}
