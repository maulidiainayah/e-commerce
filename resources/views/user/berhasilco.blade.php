@extends('layouts.user.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{url('fe/img/breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
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
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h3>Checkout Berhasil</h3>
<p>Tanggal: {{ $checkout->tanggal->format('d-m-Y H:i') }}</p>

<h5>Produk:</h5>
<ul>
    @foreach($keranjangs as $k)
        <li>{{ $k->product->nama }} x{{ $k->qty }} - Rp{{ number_format($k->product->harga) }}</li>
    @endforeach
</ul>

<p>Total: Rp{{ number_format($keranjangs->sum(fn($k) => $k->product->harga * $k->qty)) }}</p>

<p>Status: {{ ucfirst($checkout->status) }}</p>
<img src="{{ asset('storage/' . $checkout->bukti_pembayaran) }}" width="200">
            </div>

    </section>
    <!-- Checkout Section End -->
    
    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    @endsection

    
    