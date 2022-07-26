@extends('layouts.main')

@section('container')
<div class="card">
  <div class="card-header">
    @php
        echo $data['judul'];
    @endphp
    <a href="{{ url('barang') }}" class="btn btn-primary btn-sm float-end">Kembali</a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('barang.simpan') }}">
      @csrf
      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select class="form-select" name="kategori" id="kategori">
          <option selected>Pilih</option>
          <option value="Makanan">Makanan</option>
          <option value="Minuman">Minuman</option>
          <option value="ATK">ATK</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="nama_brg" class="form-label">Nama Barang</label>
        <input type="text" class="form-control" name="nama_brg" id="nama_brg">
      </div>
      <div class="mb-3">
        <label for="unit" class="form-label">Unit</label>
        <select class="form-select" name="unit" id="unit">
          <option selected>Pilih</option>
          <option value="Buah">Buah</option>
          <option value="Kilogram">Kilogram</option>
          <option value="Bungkus">Bungkus</option>
          <option value="Liter">Liter</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" name="harga" class="form-control" id="harga">
      </div>
      <div class="mb-3">
        <label for="qty" class="form-label">QTY</label>
        <input type="number" name="qty" class="form-control" id="qty">
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>
@endsection