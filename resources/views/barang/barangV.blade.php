@extends('layouts.main')

@section('container')
<div class="card">
  <div class="card-header">
    @php
        echo $data['judul'];
    @endphp
    <a href="{{ url('barang/tambah') }}" class="btn btn-primary btn-sm float-end">Tambah</a>
  </div>
  <div class="card-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Harga</th>
          <th scope="col">QTY</th>
          <th scope="col">Kategori</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['barang'] as $brg)
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $brg->nama_brg }}</td>
          <td>{{ $brg->harga }}/{{ $brg->unit }}</td>
          <td>{{ $brg->qty }} {{ $brg->unit }}</td>
          <td>{{ $brg->kategori }}</td>
          <td>
            <a href="{{ url('barang/ubah/'. $brg->id) }}" class="btn btn-warning btn-sm">Ubah</a>
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
                  <a href="{{ url('barang/hapus/'. $brg->id) }}" type="button" class="btn btn-danger">Hapus</a>
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