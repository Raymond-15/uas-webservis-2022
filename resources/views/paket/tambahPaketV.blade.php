@extends('layouts.main')

@section('container')
<div class="card">
  <div class="card-header">
    @php
        echo $data['judul'];
    @endphp
    <a href="{{ url('paket') }}" class="btn btn-primary btn-sm float-end">Kembali</a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('paket.simpan') }}">
      @csrf
      <div class="mb-3">
        <label for="nama_paket" class="form-label">Nama Paket</label>
        <input value="{{ old('nama_paket') }}" type="text" class="form-control" name="nama_paket" id="nama_paket">
        @error('nama_paket')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="barang" class="form-label">Barang</label>
        <select multiple class="form-select" name="barang[]" id="barang">
          @foreach ($data['barang'] as $brg)
          @if (old('barang') == $brg->id)
          <option value="{{ $brg->id }}" selected>{{ $brg->nama_brg }}</option>              
          @else
          <option value="{{ $brg->id }}">{{ $brg->nama_brg }}</option>              
          @endif
          @endforeach
        </select>
        @error('barang')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="harga_paket" class="form-label">Harga Paket</label>
        <input value="{{ old('harga_paket') }}" type="number" name="harga_paket" class="form-control" id="harga_paket">
        @error('harga_paket')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>

      <!-- Repetition section -->
      <div class="mb-3">
        <label for="rep">Rentang jadwal</label>
        <select class="form-control" id="rep" name="rep">
            <option value="">Pilih</option>
            <option value="1" {{ (old('rep') == '1') ? 'selected' : '' }}>Satu hari</option>
            <option value="2" {{ (old('rep') == '2') ? 'selected' : '' }}>Mingguan</option>
        </select>
        @error('rep')
          <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
      </div>

      <!-- Weekly -->
      <div class="mb-3" id="in_1">
        <label>Pilih Hari</label>
        <div class="form-row-checkbox" style="display: flex; flex-wrap: wrap;">
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck1" value="1">
                <label class="custom-control-label" for="customCheck1">Mon </label>
            </div>
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck2" value="2">
                <label class="custom-control-label" for="customCheck2">Tue </label>
            </div>
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck3" value="3">
                <label class="custom-control-label" for="customCheck3">Wed </label>
            </div>
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck4" value="4">
                <label class="custom-control-label" for="customCheck4">Thu </label>
            </div>
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck5" value="5">
                <label class="custom-control-label" for="customCheck5">Fri </label>
            </div>
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck6" value="6">
                <label class="custom-control-label" for="customCheck6">Sat </label>
            </div>
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
                <input type="checkbox" name="day[]" class="custom-control-input" id="customCheck7" value="7">
                <label class="custom-control-label" for="customCheck7">Sun </label>
            </div>
        </div>
      </div>

      <div class="mb-3" id="simple-date1">
        <label for="datestart">Date start</label>
        <div class="input-group date">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            <input type="text" class="form-control" value="<?= date('d/m/Y'); ?>" id="datestart" name="datestart">
        </div>
      </div>
      <div class="mb-3" id="simple-date2">
        <label for="simpleDataInput">Date end</label>
        <div class="input-group date">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>      
            <input type="text" class="form-control" value="<?= date('d/m/Y'); ?>" id="dateend" name="dateend">
        </div>
      </div>

      <div class="mb-3" id="simple-date4">
        <label for="dateRangePicker">Time</label>
        <div class="input-daterange input-group">
            <input data-autoclose="true" data-placement="top" type="text" class="form-control" id="clockPicker1" value="08:00" name="clockstart">
            <span class="input-group-text">to</span>
            <input data-autoclose="true" data-placement="top" type="text" class="form-control" id="clockPicker2" value="09:00" name="clockend">
        </div>
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>

<script src="{{ asset('js/changepicker.js') }}" defer></script>
@endsection