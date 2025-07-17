@extends('layouts.user.app')
@section('content')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{url('fe/img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="#">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <form id="cart-form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="check-all"></th>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $k)
                                @php
                                    $gambar = json_decode($k->product->gambar, true);
                                    $totalPerItem = $k->product->harga * $k->qty;
                                @endphp
                                <tr>
                                  <td><input type="checkbox" class="item-check" value="{{ $k->id }}" data-total="{{ $totalPerItem }}"></td>
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('storage/' . ($gambar[0] ?? 'default.jpg')) }}" alt="" class="img-fluid" style="max-width: 150px;">
                                        <h5>{{ $k->product->nama }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        Rp{{ number_format($k->product->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" value="{{ $k->qty }}" 
                                                class="qty-input" 
                                                data-id="{{ $k->id }}" 
                                                data-harga="{{ $k->product->harga }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        Rp{{ number_format($totalPerItem, 0, ',', '.') }}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <form action="{{ route('user.cart.destroy', $k->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon_close" style="border: none; background: none;"></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>

        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{ route('user.shop') }}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                </div>
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li><strong>Selected Total</strong> <span id="cart-total"><strong>Rp.0.00</strong></span></li>
                    </ul>
                    <form id="checkout-form" method="GET" action="{{ route('user.checkout.page') }}">
                        <input type="hidden" name="keranjang_ids" id="selected-carts">
                        <button type="submit" class="primary-btn">PROCEED TO CHECKOUT</button>
                    </form>
                </div>
            </div>
        </div>
            </div>

            
            
</section>
<!-- Shoping Cart Section End -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.item-check');
        const checkAll = document.getElementById('check-all');
        const totalDisplay = document.getElementById('cart-total');
        const qtyInputs = document.querySelectorAll('.qty-input');
        const checkoutForm = document.getElementById('checkout-form');
        const selectedInput = document.getElementById('selected-carts');

        function updateTotal() {
            let total = 0;

            document.querySelectorAll('tr').forEach(row => {
                const qtyInput = row.querySelector('.qty-input');
                if (!qtyInput) return;

                const qty = parseInt(qtyInput.value) || 1;
                const price = parseFloat(qtyInput.dataset.harga);
                const rowTotal = qty * price;

                const checkbox = row.querySelector('.item-check');
                if (checkbox) checkbox.dataset.total = rowTotal;

                const totalCell = row.querySelector('.shoping__cart__total');
                if (totalCell) totalCell.innerHTML = `Rp${rowTotal.toFixed(2)}`;

                if (checkbox && checkbox.checked) total += rowTotal;
            });

            if (totalDisplay) totalDisplay.innerHTML = `<strong>Rp${total.toFixed(2)}</strong>`;
        }

        function updateSelectedIds() {
            const ids = Array.from(document.querySelectorAll('.item-check:checked')).map(cb => cb.value);
            selectedInput.value = ids.join(',');
            return ids.length;
        }

        qtyInputs.forEach(input => {
            input.addEventListener('input', function () {
                if (parseInt(input.value) < 1 || isNaN(parseInt(input.value))) {
                    input.value = 1;
                }
                updateTotal();
            });
        });

        document.querySelectorAll('.pro-qty').forEach(wrapper => {
            wrapper.addEventListener('click', function (e) {
                if (e.target.classList.contains('qtybtn')) {
                    const input = wrapper.querySelector('.qty-input');
                    let oldVal = parseInt(input.value);
                    if (isNaN(oldVal)) oldVal = 1;

                    if (e.target.innerText === '+') {
                        input.value = oldVal + 1;
                    } else if (e.target.innerText === '-' && oldVal > 1) {
                        input.value = oldVal - 1;
                    }

                    updateTotal();
                }
            });
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                updateTotal();
                updateSelectedIds();
            });
        });

        checkAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
            updateTotal();
            updateSelectedIds();
        });

        checkoutForm.addEventListener('submit', function (e) {
            const totalSelected = updateSelectedIds();
            if (totalSelected === 0) {
                e.preventDefault();
                alert('Pilih minimal satu produk untuk di-checkout.');
            }
        });

        updateTotal();
        updateSelectedIds();
    });
</script>

@endsection