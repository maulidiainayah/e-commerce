@extends('layouts.user.app')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ url('fe/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Nay's Shop</h2>
                    <div class="breadcrumb__option">
                        <a href="#">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
     <div class="container-fluid px-0">
        <div class="row">
            <!-- Sidebar -->
            {{-- <div class="col-lg-3 col-md-5">
                @include('partials.sidebar') {{-- Taruh sidebar jika ada --}}
            {{-- </div> --}} 

            <!-- Produk -->
           <div class="col-lg-10 offset-lg-1 col-md-12">
                <div class="product__discount">
                    <div class="section-title product__discount__title">
                        <h2>Produk Unggulan</h2>
                    </div>
                    <div class="row">
                        <div class="product__discount__slider owl-carousel">
                            @foreach ($produk as $item)
                                @php
                                    $gambarArray = json_decode($item->gambar, true);
                                    $gambar = $gambarArray[0] ?? 'default.jpg';
                                @endphp
                                <div class="col-lg-4">
                                    <div class="product__discount__item">
                                        <div class="product__discount__item__pic set-bg"
                                            data-setbg="{{ asset('storage/' . $gambar) }}">
                                            <ul class="product__item__pic__hover">
                                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                                <li><a href="{{ route('user.detail', $item->id) }}"><i class="fa fa-eye"></i></a></li>
                                                <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__discount__item__text">
                                            <span>{{ $item->kategori->nama ?? 'Uncategorized' }}</span>
                                            <h5><a href="#">{{ $item->nama }}</a></h5>
                                            <div class="product__item__price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Produk Semua -->
                <div class="filter__item">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="filter__sort">
                                <span>Sort By</span>
                                <select>
                                    <option value="0">Default</option>
                                    <option value="1">Name A-Z</option>
                                    <option value="2">Price Lowest</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="filter__found">
                                <h6><span>{{ $produk->count() }}</span> Products found</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @forelse ($produk as $item)
                        @php
                            $gambarArray = json_decode($item->gambar, true);
                            $gambar = $gambarArray[0] ?? 'default.jpg';
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg"
                                    data-setbg="{{ asset('storage/' . $gambar) }}">
                                    <ul class="product__item__pic__hover">
                                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="{{ route('user.detail', $item->id) }}">{{ $item->nama }}</a></h6>
                                    <h5>Rp {{ number_format($item->harga, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Produk belum tersedia.</p>
                        </div>
                    @endforelse
                </div>

                {{-- <div class="product__pagination">
                    {{-- Tambahkan pagination jika dibutuhkan --}}
                    {{-- {{ $produk->links() }}
                </div> --}} 
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->

@endsection
