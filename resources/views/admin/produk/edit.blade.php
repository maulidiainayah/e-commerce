@extends('layouts.admin.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Produk</h3>
                    </div>
                    <form action="{{ url('admin/produk/' . $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Kategori Produk</label>
                                <select name="idkategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                        @foreach($kategori as $kat)
                                    <option value="{{ $kat->id }}" {{ (old('idkategori', $produk->idkategori) == $kat->id) ? 'selected' : '' }}>
                                        {{ $kat->nama }}
                                    </option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama Produk</label>
                                <input type="text" class="form-control" name="nama" value="{{ $produk->nama }}" required>
                            </div>

                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" class="form-control" name="harga" value="{{ $produk->harga }}" required>
                            </div>

                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" name="stok" value="{{ $produk->stok }}" required>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="4" required>{{ $produk->deskripsi }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="gambar">Gambar Produk</label><br>
                                <!-- Menampilkan gambar-gambar yang sudah ada -->
                                @if(is_array(json_decode($produk->gambar)))
                                    @foreach (json_decode($produk->gambar) as $img)
                                        <img src="{{ asset('storage/' . $img) }}" width="100" class="mb-2">
                                    @endforeach
                                @else
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" width="100" class="mb-2">
                                @endif
                                <input type="file" name="gambar[]" class="form-control" multiple>
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
