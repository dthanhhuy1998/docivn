<script>
    const currentPage = 'trang-chu';
    const THEME = 'theme_user';
    const PATHTHEME = 'public/catalog/assets/public/upload/theme/';
    const URL_ROOT = './';
    const SDT = '0779999965';
    const USER_ID = -1;
    let windowWidth = document.documentElement.clientWidth;
    let token = 'm4PqPDdhBFyAiu9Lvq9E';
    let ngonngu = 1;
    let datasanphamchitiet = [];
    const khsi = false;
</script>
<div class="floating-cart" id="floating-cart">
    <div class="cart-header">
        <div class="cart-title">
            Giỏ hàng
        </div>
        <button href="javascript:void(0)" class="js-close_cart cart-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="cart-body">
        <div class="cart-main">
            <div class="cart-main_scroll">
                <div class="cart-list" style="display:none"></div>
                <div class="cart-empty" style="display:block">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 576 512">
                        <path d="M263.4 103.4C269.7 97.18 279.8 97.18 286.1 103.4L320 137.4L353.9 103.4C360.2 97.18 370.3 97.18 376.6 103.4C382.8 109.7 382.8 119.8 376.6 126.1L342.6 160L376.6 193.9C382.8 200.2 382.8 210.3 376.6 216.6C370.3 222.8 360.2 222.8 353.9 216.6L320 182.6L286.1 216.6C279.8 222.8 269.7 222.8 263.4 216.6C257.2 210.3 257.2 200.2 263.4 193.9L297.4 160L263.4 126.1C257.2 119.8 257.2 109.7 263.4 103.4zM80 0C87.47 0 93.95 5.17 95.6 12.45L100 32H541.8C562.1 32 578.3 52.25 572.6 72.66L518.6 264.7C514.7 278.5 502.1 288 487.8 288H158.2L172.8 352H496C504.8 352 512 359.2 512 368C512 376.8 504.8 384 496 384H160C152.5 384 146.1 378.8 144.4 371.5L67.23 32H16C7.164 32 0 24.84 0 16C0 7.164 7.164 0 16 0H80zM107.3 64L150.1 256H487.8L541.8 64H107.3zM128 456C128 425.1 153.1 400 184 400C214.9 400 240 425.1 240 456C240 486.9 214.9 512 184 512C153.1 512 128 486.9 128 456zM184 480C197.3 480 208 469.3 208 456C208 442.7 197.3 432 184 432C170.7 432 160 442.7 160 456C160 469.3 170.7 480 184 480zM512 456C512 486.9 486.9 512 456 512C425.1 512 400 486.9 400 456C400 425.1 425.1 400 456 400C486.9 400 512 425.1 512 456zM456 432C442.7 432 432 442.7 432 456C432 469.3 442.7 480 456 480C469.3 480 480 469.3 480 456C480 442.7 469.3 432 456 432z"></path>
                    </svg>
                    <div class="title">
                        Giỏ hàng của bạn đang trống.
                    </div>
                    <div class="button content-center">
                        <a href="{{ route('catalog.homepage') }}" class="js-close_cart button-theme button-theme_primary" data-title="Về trang chủ">
                            <span>Về trang chủ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-bottom" style="display:none">
            <div class="cart-total">
                <div class="cart-price_text">
                    Tạm tính:
                </div>
                <div class="cart-price_value">
                    199.000.000đ
                </div>
            </div>
            <div class="cart-desc">
                Phí vận chuyển sẽ được tính khi giao hàng
            </div>
            <div class="card-buttons">
                <a href="{{ Illuminate\Support\Facades\Route::has('catalog.cart.getCartList') ? route('catalog.cart.getCartList') : '#' }}" class="button-theme button-theme_secondary" data-title="Xem giỏ hàng">
                    <span>Xem giỏ hàng</span>
                </a>
                <a href="{{ Illuminate\Support\Facades\Route::has('catalog.cart.getOrder') ? route('catalog.cart.getOrder') : '#' }}" class="button-theme button-theme_primary" data-title="Đặt mua ngay">
                    <span>Đặt mua ngay</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="floating-overlay js-close_cart"></div>
<!-- <button type="button" class="button-return" id="return-top">
    <i class="fas fa-chevron-up"></i>
</button>
<a @if(!empty($zalo)) href="https://zalo.me/{{ $zalo }}" target="_blank" @else href="#" onclick="return false;" @endif class="button-zalo" >
    <img src="https://nongsankhaianh.com/wp-content/uploads/2021/10/icon-zalo.png" alt="zalo">
</a> 
<a href="{{ Illuminate\Support\Facades\Route::has('catalog.product') ? route('catalog.cart.getCartList') : '#' }}" class="button-return is-show">
    <i class="fas fa-shopping-cart"></i>
</a>-->