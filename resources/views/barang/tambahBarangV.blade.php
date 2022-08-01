@extends('layouts.main')

@section('container')
<div class="card">
  <div class="card-header">
    {{ $data['judul'] }}
    <a href="{{ url('barang') }}" class="btn btn-primary btn-sm float-end">Kembali</a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('barang.simpan') }}">
      @csrf
      <div class="mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select class="form-select" name="kategori" id="kategori">
          <option value="">Pilih</option>
          <option value="Makanan" {{ (old('kategori') == 'Makanan') ? 'selected' : '' }}>Makanan</option>
          <option value="Minuman" {{ (old('kategori') == 'Minuman') ? 'selected' : '' }}>Minuman</option>
          <option value="ATK" {{ (old('kategori') == 'ATK') ? 'selected' : '' }}>ATK</option>
        </select>
        @error('kategori')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="nama_brg" class="form-label">Nama Barang</label>
        <input type="text" class="form-control" name="nama_brg" id="nama_brg" value="{{ old('nama_brg') }}">
        @error('nama_brg')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="unit" class="form-label">Unit</label>
        <select class="form-select" name="unit" id="unit">
          <option value="">Pilih</option>
          <option value="Buah" {{ (old('kategori') == 'Buah') ? 'selected' : '' }}>Buah</option>
          <option value="Kilogram" {{ (old('kategori') == 'Kilogram') ? 'selected' : '' }}>Kilogram</option>
          <option value="Bungkus" {{ (old('kategori') == 'Bungkus') ? 'selected' : '' }}>Bungkus</option>
          <option value="Liter" {{ (old('kategori') == 'Liter') ? 'selected' : '' }}>Liter</option>
        </select>
        @error('unit')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" name="harga" class="form-control" id="harga" value="{{ old('harga') }}">
        @error('harga')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <div class="mb-3">
        <label for="qty" class="form-label">QTY</label>
        <input type="number" name="qty" class="form-control" id="qty" value="{{ old('qty') }}">
        @error('qty')
            <div class="alert alert-sm alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>
@endsection