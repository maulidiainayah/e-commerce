@extends('layouts.admin.app')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Mutasi Barang</h3>
          </div>

          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>Nama User</th>
                  <th>Nama Produk</th>
                  <th>Qty</th>
                  <th>Harga Satuan</th>
                  <th>Subtotal</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Resi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($mutasi as $index => $item)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->produk->nama ?? '-' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y H:i') }}</td>
                    <td>
                      <span class="badge {{ $item->m_k === 'keluar' ? 'badge-danger' : 'badge-success' }}">
                        {{ strtoupper($item->m_k) }}
                      </span>
                    </td>
                    <td>{{ $item->no_resi ?? '-' }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="9" class="text-center text-muted">Belum ada data mutasi.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
