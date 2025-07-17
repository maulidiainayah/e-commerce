@extends('layouts.user.app')
@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ url('fe/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="/">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <form action="{{ route('user.checkout.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <div class="checkout__form">
                        <h4>Billing Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Full Name<span>*</span></p>
                                    <input type="text" name="nama" value="{{ auth()->user()->name }}" required readonly style="color: #000;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Checkout Date<span>*</span></p>
                                    <input type="text" name="tanggal" value="{{ now()->format('d-m-Y H:i') }}" readonly style="color: #000;">
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input tyle="color: #000;" type="text" name="alamat" placeholder="Your full address" required>
                        </div>
                        <div class="checkout__input">
                            <p>Metode Pembayaran<span>*</span></p>
                            <select name="metode_pembayaran" class="form-control" required style="color: #000;">
                                <option value="transfer">Transfer Bank</option>
                                <option value="cod">BRI</option>
                                <option value="cod">BNI</option>
                                <option value="cod">MANDIRI</option>
                            </select>
                        </div>
                        
                        <div class="checkout__input">
                            <p>Upload Bukti Pembayaran<span>*</span></p>
                
                            <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required style="color: #000;">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <div class="checkout__order">
                        <h4>Your Order</h4>
                        <div class="checkout__order__products">Products <span>Total</span></div>
                        <ul>
                            @php $total = 0; @endphp
                            @foreach($keranjangs as $k)
                                @php
                                    $subtotal = $k->product->harga * $k->qty;
                                    $total += $subtotal;
                                @endphp
                                <li>{{ $k->product->nama }} x{{ $k->qty }} <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span></li>
                            @endforeach
                        </ul>
                        <div class="checkout__order__total">Total <span>Rp{{ number_format($total, 0, ',', '.') }}</span></div>

                        <input type="hidden" name="keranjang_ids" value="{{ implode(',', $cartIds) }}">
                        <button type="submit" class="site-btn">Selesaikan Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Checkout Section End -->
@endsection
