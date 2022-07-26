@extends('layouts.main')

@section('container')
<div class="card">
  <div class="card-header">
    @php
        echo $data['judul'];
    @endphp
    <a href="{{ url('promo') }}" class="btn btn-primary btn-sm float-end">Kembali</a>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('promo.perbaharui') }}">
      @csrf
      <input type="hidden" name="id_promo" value="{{ $data['promo'][0]->id }}">
      <input type="hidden" name="id_jadwal" value="{{ $data['promo'][0]->jadwal_id }}">
      <div class="mb-3">
        <label for="nama_promo" class="form-label">Nama Promo</label>
        <input value="{{ $data['promo'][0]->nama_promo }}" type="text" class="form-control" name="nama_promo" id="nama_promo">
      </div>

      <div class="mb-3">
        <label for="barang" class="form-label">Barang</label>
        <select class="form-select" name="barang" id="barang">
          <option value="{{ $data['promo'][0]->kode_brg }}" selected>{{ $data['promo'][0]->nama_brg }}</option>              
        </select>
      </div>

      <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input value="{{ $data['promo'][0]->harga }}" type="number" name="harga" class="form-control" id="harga" disabled>
      </div>

      <div class="mb-3">
        <label for="diskon" class="form-label">Potongan</label>
        <input value="{{ $data['promo'][0]->diskon }}" type="number" name="diskon" class="form-control" id="diskon">
 
      </div>

      <div class="mb-3">
        <label for="qty_brg" class="form-label">QTY</label>
        <input value="{{ $data['promo'][0]->qty_brg }}" type="number" name="qty_brg" class="form-control" id="qty_brg">

      </div>

      <!-- Repetition section -->
      <div class="mb-3">
        <label for="rep">Rentang jadwal</label>
        <select class="form-control" id="rep" name="rep">
            <option value="">Pilih</option>
            <option value="1" {{ ($data['promo'][0]->freq == '1') ? 'selected' : '' }}>Satu hari</option>
            <option value="2" {{ ($data['promo'][0]->freq == '2') ? 'selected' : '' }}>Mingguan</option>
        </select>
      </div>

      <!-- Weekly -->
      <div class="mb-3" id="in_1">
        <label>Pilih Hari</label>
        <div class="form-row-checkbox" style="display: flex; flex-wrap: wrap;">
            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
                  {{ ($day == 1) ? 'checked' : '' }}
              @endforeach name="day[]" class="custom-control-input" id="customCheck1" value="1">  
              <label class="custom-control-label" for="customCheck1">Mon </label>
            </div>

            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
              {{ ($day == 2) ? 'checked' : '' }}
          @endforeach name="day[]" class="custom-control-input" id="customCheck2" value="2">
              <label class="custom-control-label" for="customCheck2">Tue </label>
            </div>

            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
              {{ ($day == 3) ? 'checked' : '' }}
          @endforeach name="day[]" class="custom-control-input" id="customCheck3" value="3">
              <label class="custom-control-label" for="customCheck3">Wed </label>
            </div>

            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
              {{ ($day == 4) ? 'checked' : '' }}
          @endforeach name="day[]" class="custom-control-input" id="customCheck4" value="4">
              <label class="custom-control-label" for="customCheck4">Thu </label>
            </div>

            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
              {{ ($day == 5) ? 'checked' : '' }}
          @endforeach name="day[]" class="custom-control-input" id="customCheck5" value="5">
              <label class="custom-control-label" for="customCheck5">Fri </label>
            </div>

            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
              {{ ($day == 6) ? 'checked' : '' }}
          @endforeach name="day[]" class="custom-control-input" id="customCheck6" value="6">
              <label class="custom-control-label" for="customCheck6">Sat </label>
            </div>

            <div class="custom-control custom-checkbox" style="margin-right: 20px;">
              <input type="checkbox" @foreach ($data['hari'] as $day)
              {{ ($day == 7) ? 'checked' : '' }}
          @endforeach name="day[]" class="custom-control-input" id="customCheck7" value="7">
              <label class="custom-control-label" for="customCheck7">Sun </label>
            </div>
        </div>
      </div>

      <div class="mb-3" id="simple-date1">
        <label for="datestart">Date start</label>
        <div class="input-group date">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
            <input type="text" class="form-control" value="{{ date('d/m/Y', $data['promo'][0]->start_date) }}" id="datestart" name="datestart">
        </div>
      </div>
      <div class="mb-3" id="simple-date2">
        <label for="simpleDataInput">Date end</label>
        <div class="input-group date">
            <span class="input-group-text"><i class="fas fa-calendar"></i></span>      
            <input type="text" class="form-control" value="{{ date('d/m/Y', $data['promo'][0]->end_date) }}" id="dateend" name="dateend">
        </div>
      </div>

      <div class="mb-3" id="simple-date4">
        <label for="dateRangePicker">Time</label>
        <div class="input-daterange input-group">
            <input data-autoclose="true" data-placement="top" type="text" class="form-control" id="clockPicker1" value="{{ date('H:i', $data['promo'][0]->start_date) }}" name="clockstart">
            <span class="input-group-text">to</span>
            <input data-autoclose="true" data-placement="top" type="text" class="form-control" id="clockPicker2" value="{{ date('H:i', $data['promo'][0]->end_date) }}" name="clockend">
        </div>
      </div>
      <button type="submit" class="btn btn-success">Submit</button>
    </form>
  </div>
</div>

<script>
  $("#barang").change( ()=> { 
    var data = $("#barang").val();
    $.ajax({
      type: "get",
      url: "/barang/show",
      data: {id:data},
      dataType: "json",
      success: function (response) {
        $("#harga").val(response['harga']);
      }
    });
    
  });
</script>

<script>
  var x = document.getElementById("rep").value;
    if (x == 2) {
        // $("#pp").html(x);
        $("#in_1").show();
        $("#in_2").hide();
        $("#in_3").hide();
        $("#simple-date1").show();
        $("#simple-date2").show();
        $("#simple-date4").show();
    } else if (x == 3) {
        $("#in_1").hide();
        $("#in_2").show();
        $("#in_3").hide();
    } else if (x == 4) {
        $("#in_1").hide();
        $("#in_2").hide();
        $("#in_3").show();
    } else if (x == 0 || x == 1) {
        $("#in_1").hide();
        $("#in_2").hide();
        $("#in_3").hide();
        $("#simple-date1").show();
        $("#simple-date2").hide();
        $("#simple-date4").show();
    }
</script>
@endsection