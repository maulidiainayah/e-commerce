@extends('layouts.admin.app')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Checkout Menunggu Verifikasi</h3>
          </div>

          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama User</th>
                  <th>Tanggal</th>
                  <th>Bukti Pembayaran</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($checkouts as $index => $checkout)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $checkout->user->name }}</td>
                    <td>{{ $checkout->tanggal->format('d-m-Y H:i') }}</td>
                    <td>
                      @if($checkout->bukti_pembayaran)
                        <a href="{{ asset('storage/' . $checkout->bukti_pembayaran) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                      @else
                        <span class="text-muted">Belum ada</span>
                      @endif
                    </td>
                    <td>
                      <span class="badge badge-warning text-uppercase">{{ $checkout->status }}</span>
                    </td>
                    <td>
                      {{-- Tombol Verifikasi --}}
                      <form action="{{ route('admin.checkout.verifikasi', $checkout->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Verifikasi checkout ini?')">Verifikasi</button>
                      </form>

                      {{-- Tombol Tolak (opsional)
                      <form action="{{ route('admin.checkout.tolak', $checkout->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tolak checkout ini?')">Tolak</button>
                      </form> --}}
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center">Tidak ada data checkout pending.</td>
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
