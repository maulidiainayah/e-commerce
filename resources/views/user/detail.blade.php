@extends('layouts.user.app')
@section('content')
    <section class="product-details spad">
    <div class="container">
        <div class="row">
            {{-- Gambar Produk --}}
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large"
                            @php
                                $gambarArray = is_array(json_decode($produk->gambar, true)) ? json_decode($produk->gambar, true) : [];
                                $gambarUtama = $gambarArray[0] ?? 'default.jpg';
                            @endphp
                             src="{{ asset('storage/' . $gambarUtama) }}" alt="">
                    </div>
                    <div class="product__details__pic__slider owl-carousel">
                        @foreach ($gambarArray as $gambar)
                            <img data-imgbigurl="{{ asset('storage/' . $gambar) }}"
                                 src="{{ asset('storage/' . $gambar) }}" alt="">
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{ $produk->nama }}</h3>
                    <div class="product__details__rating">
                        {{-- kamu bisa bikin sistem rating jika perlu --}}
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <span>(18 reviews)</span>
                    </div>
                    <div class="product__details__price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                    <p>{{ $produk->deskripsi }}</p>
                    <p><strong>Availability:</strong> {{ $produk->stok > 0 ? 'In Stock ('.$produk->stok.')' : 'Out of Stock' }}</p>

                    <form action="{{ route('user.cart.store') }}" method="POST">
                        @csrf
                       <input type="hidden" name="idproduk" value="{{ $produk->id }}">

                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" name="qty" value="1">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="primary-btn">ADD TO CART</button>
                    </form>
                    <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
                    <ul>
                        <li><b>Availability</b> <span>{{ $produk->stok > 0 ? 'In Stock' : 'Out of Stock' }}</span></li>
                        <li><b>Weight</b> <span>{{ $produk->berat ?? 'N/A' }} kg</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Related Product</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-1.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-2.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-3.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="img/product/product-7.jpg">
                            <ul class="product__item__pic__hover">
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="#">Crab Pool Security</a></h6>
                            <h5>$30.00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->
@endsection