@extends('catalog.common.layout')

@section('content')
<div class="section-main">
    <div class="page-cart">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="cart-inner">
                        <div class="cart-header d-none d-xl-flex">
                            <div class="cart-thumb cart-boxsize"></div>
                            <div class="cart-product cart-boxsize">
                                Tên sản phẩm
                            </div>
                            <div class="cart-price cart-boxsize">
                                Đơn giá
                            </div>
                            <div class="cart-quantity cart-boxsize">
                                Số lượng
                            </div>
                            <div class="cart-total cart-boxsize">
                                Thành tiền
                            </div>
                        </div>
                        @if(count($cartContent))
                            <div class="cart-body">
                                @php $countItem = 0; @endphp
                                @foreach($cartContent as $item)
                                    <div class="cart-item" id="cart-item_{{$countItem}}">
                                        <div class="cart-thumb cart-boxsize">
                                            <div class="cart-image">
                                                <a href="{{ $item->options->view }}" target="_blank">
                                                    <img src="{{ $item->options->image }}" alt="{{ $item->name }}">
                                                </a>
                                                <div class="cart-remove">
                                                    <button 
                                                        type="button" data-key="{{ $item->rowId }}"
                                                        data-id="{{ $item->rowId }}"
                                                        class="delete-cart btn-remove"
                                                    >
                                                        <svg 
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                        >
                                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cart-product cart-boxsize">
                                            <a class="cart-title" href="{{ $item->options->view }}" target="_blank">{{ $item->name }}</a>
                                            {{-- <div class="cart-property">
                                                Dung tích:&nbsp;<b>25ml</b>
                                            </div> --}}
                                        </div>
                                        <div class="cart-price cart-boxsize">{{ number_format($item->price) }}đ</div>
                                        <div class="cart-quantity cart-boxsize">
                                            <div class="quantity2">
                                                <span class="dec quantity-button" data-type="0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                </span>
                                                <input 
                                                    type="text" 
                                                    name="quantity-number"
                                                    class="quantity-number"
                                                    value="{{ $item->qty }}"
                                                    data-key="{{$countItem}}"
                                                    data-id="{{ $item->rowId }}"
                                                    data-max="{{ $item->options->max_qty }}"
                                                >
                                                <span class="inc quantity-button" data-type="1">
                                                    <svg 
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                    >
                                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="cart-total cart-boxsize">{{ number_format($item->price*$item->qty) }}đ</div>
                                    </div>
                                    @php $countItem++; @endphp   
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-4 mt-4 mt-xl-0">
                    <div class="cart-sidebar">
                        <div class="cart-title">
                            Giỏ hàng
                            <span>(<span id="soluongCheckout">{{ $cartCount }}</span> sản phẩm)</span>
                        </div>
                        <div class="cart-list">
                            <div class="cart-list_item">
                                Tạm tính:&nbsp;
                                <span class="value totalCheckout">{{ $cartTotal }}đ</span>
                            </div>
                            <div class="cart-list_item">
                                Tổng tiền:&nbsp;
                                <span class="value totalCheckout">{{ $cartTotal }}đ</span>
                            </div>
                        </div>
                        <div class="cart-desc">
                            Miễn phí cước vận chuyển
                        </div>
                        <div class="cart-button content-center">
                            <a href="{{ route('catalog.cart.getOrder') }}" class="button-theme button-theme_primary" data-title="Đặt hàng">
                                <span>Đặt hàng</span>
                            </a>
                        </div>
                        <div class="cart-link">
                            <a href="{{ route('catalog.homepage') }}">Tiếp tục mua hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection