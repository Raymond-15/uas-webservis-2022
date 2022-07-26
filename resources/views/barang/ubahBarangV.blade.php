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
    <form action="{{ route('barang.perbaharui') }}" method="POST">
      @csrf
      {{-- @method('PATCH') --}}
      <input type="hidden" name="id" value="{{ $data->id }}">
      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select class="form-select" name="kategori" id="kategori">
          <option value="">Pilih</option>
          <option value="Makanan" {{ $data->kategori == 'Makanan' ? 'Selected' : '' }}>Makanan</option>
          <option value="Minuman" {{ $data->kategori == 'Minuman' ? 'Selected' : '' }}>Minuman</option>
          <option value="ATK" {{ $data->kategori == 'ATK' ? 'Selected' : '' }}>ATK</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="nama_brg" class="form-label">Nama Barang</label>
        <input type="text" class="form-control" name="nama_brg" id="nama_brg" value="{{ $data->nama_brg }}">
      </div>
      <div class="mb-3">
        <label for="unit" class="form-label">Unit</label>
        <select class="form-select" name="unit" id="unit">
          <option value="">Pilih</option>
          <option value="Buah" {{ $data->unit == 'Buah' ? 'selected' : '' }}>Buah</option>
          <option value="Kilogram" {{ $data->unit == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
          <option value="Bungkus" {{ $data->unit == 'Bungkus' ? 'selected' : '' }}>Bungkus</option>
          <option value="Liter" {{ $data->unit == 'Liter' ?  'selected' : '' }}>Liter</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" name="harga" class="form-control" id="harga" value="{{ $data->harga }}">
      </div>
      <div class="mb-3">
        <label for="qty" class="form-label">QTY</label>
        <input type="number" name="qty" class="form-control" id="qty" value="{{ $data->qty }}">
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>
@endsection