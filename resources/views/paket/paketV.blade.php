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
    <a href="{{ url('paket/tambah') }}" class="btn btn-primary btn-sm float-end">Tambah</a>
  </div>
  <div class="card-body">
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Kode</th>
          <th scope="col">Nama</th>
          <th scope="col">Harga</th>
          <th scope="col">Jadwal</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data['paket'] as $pkt)
        <tr>
          <th scope="row">{{ $loop->iteration }}</th>
          <td>{{ $pkt->kode_paket }}</td>
          <td>{{ $pkt->nama_paket }}</td>
          <td>{{ $pkt->harga_paket }}</td>
          <td>
            @php
          if ($pkt->freq == 2) {
            $dn = explode(" ", $pkt->day_no);
                            for($i=0; $i < count($dn); $i++){
                                    if($dn[$i]==1){ 
                                        $ds[$i]="Mon";
                                    }else if($dn[$i]==2){
                                    $ds[$i]="Tue";
                                    }else if($dn[$i]==3){
                                    $ds[$i]="Wed";
                                    }else if($dn[$i]==4){
                                    $ds[$i]="Thu";
                                    }else if($dn[$i]==5){
                                    $ds[$i]="Fri";
                                    }else if($dn[$i]==6){
                                    $ds[$i]="Sat";
                                    }else if($dn[$i]==7){
                                    $ds[$i]="Sun";
                                    }
                                    // var_dump($ds[$i]);
                                }
                                $result = implode(" ", $ds);
                                echo($result);
          }elseif ($pkt->freq == 1) {
            echo(date('D', $pkt->start_date));
          } @endphp / {{ gmdate('H:i', $pkt->start_date) }} - {{ gmdate('H:i', $pkt->end_date) }}</td>
          <td>
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal" onclick="listBarang('{{ $pkt->barang_id }}')">Detail</button>
            <a href="{{ url('paket/ubah/'. $pkt->id) }}" class="btn btn-warning btn-sm">Ubah</a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Hapus</button>
          </td>
        </tr>

          <!-- Modal Hapus-->
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
                  <a href="{{ url('paket/hapus/'. $pkt->id) }}" type="button" class="btn btn-danger">Hapus</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Detail-->
          <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="detailModalLabel">Detail - {{ $pkt->nama_paket }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Harga Paket : {{ $pkt->harga_paket }}</p>
                  <textarea name="list" id="list"></textarea>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
  function listBarang(id_brg){
    var data = id_brg.split(" ");
    var hasil = '';
    // console.log(data);
    $.ajax({
      type: "get",
      url: "/barang/show",
      data: {
        id: data,
      },
      dataType: "json",
      success: function (response) {
        // console.log(response['data']);
        response['data'].forEach(element => {
          hasil += element['nama_brg'] + ', ';
        });
        $("#list").val(hasil);
      }
    });
  }
</script>
    
@endsection