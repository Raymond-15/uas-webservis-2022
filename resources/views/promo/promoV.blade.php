@extends('layouts.main')

@section('container')
@if (session()->has('pesan'))
  <div class="alert alert-success" role="alert">
    {{ session('pesan') }}
  </div>
@endif
<div class="card">
  <div class="card-header">
    @php
        echo $data['judul'];
    @endphp
    <a href="{{ url('promo/tambah') }}" class="btn btn-primary btn-sm float-end">Tambah</a>
  </div>
  <div class="card-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Barang</th>
          <th scope="col">Potongan</th>
          <th scope="col">QTY</th>
          <th scope="col">Jadwal</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['promo'] as $prm)
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $prm->nama_promo }}</td>
          <td>{{ $prm->nama_brg }}</td>
          <td>{{ $prm->diskon }}</td>
          <td>{{ $prm->qty_brg }}</td>
          <td>{{ gmdate('d/m/Y ~ H:i', $prm->start_date) }} - {{ gmdate('d/m/Y ~ H:i', $prm->end_date) }}</td>
          <td>
            <a href="{{ url('promo/ubah/'. $prm->id) }}" class="btn btn-warning btn-sm">Ubah</a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Hapus</button>
          </td>
        </tr>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Hapus ?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Yakin hapus data ?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <a href="{{ url('promo/hapus/'. $prm->id) }}" type="button" class="btn btn-danger">Hapus</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
    
@endsection