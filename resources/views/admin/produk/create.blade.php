@extends('layouts.admin.app')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Tambah Produk</h3>
          </div>

          <!-- Tampilkan error validasi -->
          @if ($errors->any())
              <div class="alert alert-danger mt-2">
                  <ul class="mb-0">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          <!-- form start -->
          <form action="{{ url('admin/produk') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body">
              <div class="form-group mt-3">
                <label for="idkategori">Kategori Produk</label>
                <select name="idkategori" class="form-control" required>
                  <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $kat)
                  <option value="{{ $kat->id }}" {{ old('idkategori') == $kat->id ? 'selected' : '' }}>
                    {{ $kat->nama }}
                  </option>
                    @endforeach
                </select>
              </div>


              <div class="form-group">
                <label for="nama">Nama Produk</label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama produk" value="{{ old('nama') }}" required>
              </div>

              <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" class="form-control" name="harga" placeholder="Masukkan harga" value="{{ old('harga') }}" required>
              </div>

              <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" name="stok" placeholder="Masukkan jumlah stok" value="{{ old('stok') }}" required>
              </div>

              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="4" placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
              </div>

              <div class="form-group">
                <label for="gambar">Gambar Produk</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="gambar[]" multiple required>
                    <label class="custom-file-label">Pilih gambar</label>
                  </div>
                </div>
              </div>              
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
@endsection
