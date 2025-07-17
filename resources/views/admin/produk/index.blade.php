@extends('layouts.admin.app')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Produk</h3>
            <a href="{{ url('admin/produk/create') }}" class="btn btn-sm btn-success float-right">Tambah Produk</a>
          </div>

          <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Produk</th>
                      <th>Kategori</th>
                      <th>Gambar</th>
                      <th>Deskripsi</th>
                      <th>Stok</th>
                      <th>Harga</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($produk as $index => $item)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $item->nama }}</td>
                      <td>{{ $item->kategori->nama ?? 'Tidak ada kategori' }}</td>  
                      <td>
                        @php
    $gambarArray = is_array($item->gambar) ? $item->gambar : json_decode($item->gambar, true);
@endphp

@if($gambarArray)
    @foreach ($gambarArray as $img)
        <img src="{{ asset('storage/' . $img) }}" width="70" height="70" class="rounded mb-1">
    @endforeach
@else
    <span class="text-muted">Tidak ada</span>
@endif


                      </td>
                      <td>{{ $item->deskripsi }}</td>
                      <td>{{ $item->stok }}</td>
                      <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                      <td>
                        <a href="{{ url('admin/produk/' . $item->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                      </form>                           
                      </td>
                    </tr>
                    @endforeach
                  </tbody>                  
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

