<header class="header" id="header">
    <div class="container">
        <div class="header-inner">
            <div class="header-bar">
                <div class="header-bar-left">
                    <a href="{{ route('catalog.homepage') }}" class="header-logo">
                        <div class="header-logo-img">
                            <img src="{{$logo}}" alt="{{$logo}}" class="img-fuild">
                        </div>
                        <div class="doci-slogan">
                            <span class="solid">DOCI PERFUME</span>
                            <span>Chọn đẳng cấp, chọn chúng tôi</span>
                            <span>Chọn độc đáo, chọn DOCI</span>
                        </div>
                    </a>
                </div>
                <div class="header-bar-right">
                    {{-- <div class="header-action ms-auto lg-hidden">
                        <a href="javascript:void(0)" class="js-toggle_search">
                            <i class="fal fa-search"></i>
                        </a>
                    </div>
                    <div class="header-action header-favourite lg-hidden">
                        <a href="/danh-sach-yeu-thich">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172Z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </div> --}}
                    <!-- <div class="header-action header-user lg-hidden">
                        <a href="javascript:void(0)">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.6667 17.5V15.8333C16.6667 14.9493 16.3155 14.1014 15.6903 13.4763C15.0652 12.8512 14.2174 12.5 13.3333 12.5H6.66666C5.78261 12.5 4.93476 12.8512 4.30964 13.4763C3.68452 14.1014 3.33333 14.9493 3.33333 15.8333V17.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M10 9.16667C11.841 9.16667 13.3333 7.67428 13.3333 5.83333C13.3333 3.99238 11.841 2.5 10 2.5C8.15906 2.5 6.66667 3.99238 6.66667 5.83333C6.66667 7.67428 8.15906 9.16667 10 9.16667Z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                        <div class="header-user_dropdown">
                            @if(!session()->exists('userLogin'))
                                <div class="button">
                                    <a href="{{ Illuminate\Support\Facades\Route::has('catalog.clientLogin') ? route('catalog.clientLogin') : '#' }}" class="button-theme button-theme_primary" data-title="Đăng nhập">
                                        <span>Đăng nhập</span>
                                    </a>
                                </div>
                                <div class="text">
                                    Khách mới?
                                    <a href="{{ Illuminate\Support\Facades\Route::has('catalog.getClientRegister') ? route('catalog.getClientRegister') : '#' }}">Đăng ký</a>
                                </div>
                            @else
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <div class="welcome">
                                            <span>Xin chào, <span class="welcome-text">{{ $userLogin->lastname }} {{ $userLogin->firstname }}</span></span>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.index') }}">
                                            Cập nhật thông tin tài khoản
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.getInvoice') }}">
                                            Quản lý đơn hàng
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.getResetPassword') }}">
                                            Đổi mật khẩu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('catalog.getClientLogout') }}">
                                            Đăng xuất
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="header-action header-cart lg-hidden">
                        <a href="javascript:void(0)" class="js-toggle_cart">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADe0lEQVR4nO1aPUwUQRQeMaGRShuxEis18acRCxULItGIjXKxkArOfbOHMWKlFVr4UyhW2kmh+BOxEittpBMLxYRETAAj3MwCiTaARhPzmd1996Ph7maWQyfGL5nkcjvvzfftzr55b2aF+I+lgdFULbLecWh6AE1jUHIhauFvLe9H10ZTtcJlIPBTUHISWqJsUzQBLY8J1wCkVkPJ3gJZeg1Fp6D9LQja10Qt/B39R2+KBF0LbYUrQEHEV2RlByBWleyLnhoomY76shjhzHTS0VP4AkV7jO2UtzcvRntHV5alyYudeyeyssPaXtHJ+KnI8b8aABBFJ34n0FNjbR9OMy1HIh+Bn1oZliZEtHwYk5BdiX0oeZpvxr3qsrMhoel9PDW8zcvwsZWFjFWXnQ0JRfMRidlMXWIfs5k6jl7z1WVnQ4LXA1f8/PtCoOVixXTjz7XFZCKyXescII9f2lTn2gRCMjsrRZM/NbWQi47TtMPeedY7wgM8S0qgikKe83rVmsA5ZfiJ9C15Pes15x951mu2HsDCDzT1MZeM/QCarnJ8v7Dk9bim4HRcjifQYOwHSl5kIVfsB9Cyn52nS1yfLqo/phJoMPaDOO0P+/TbD6DkUCzEbylB4FBMgqagvYMJNBj7gfJb+KYO2Q+g5Ifl5lHVAsLqMhYymSS9/rbcPKpaQD4fk9+tygV87NrAc/KTcATQ9DniNOfVmxsF3m4WMiIcATS9jdcSakxQh8snwhFA0SBHtjZzI+2d5Tl5UzgCKLrFQrrNjTTdYCHnhCOAovPMqdfG6DGv6ieEI4D221nIgLmRoldstE84AmiviTkNmxspCjhCbBSOAEG6gYVoi003+hE1h3bNYcsLM/4mjg5KOAYoqeOZkm6o3Fn7+/kRvhSOAUoOxzfZa7KIDvRIOAYoOWAcTYvi9XXhGJA7vjBZ3/IrqJJnhGOApm7jjAOKnnKe5dzRGDS18dQaNM8ytb9LOAYE1Giclefz/tnMeuEYMOfVG9VJ+UosrA4THNysNGBauRZqY5oQjgK5o75yewmF3Qp6IRwF8rs7dKBMJ+rkTneEo4CiuxUPX8NdRc6zLglHAS0vl9sB/W2P1ZPCUUBLn2/2bVF519s/LBwFAtla6ZRA8Bc8wIy3TTgKTPvbWci70p2iz5EcOJnSBk3JhaVFuHjUVqkVHcX9BAM1EPcWNSmhAAAAAElFTkSuQmCC">
                            <span>
                                (<span class="cart-number">0</span>)
                            </span>
                        </a>
                    </div>-->
                    <div class="header-action action-hamburger lg-hidden">
                        <button type="button" class="action-button hamburger-icon" id="js-toggle_navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
			</div>
            <div class="header-navigation" id="header-navigation">
                <ul class="list-unstyled mb-0">
                    <li class="navigation-item">
                        <a class="navigation-link" href="{{ route('catalog.homepage') }}">Trang chủ</a>
                    </li>
                    <li class="navigation-item">
                        <a class="navigation-link" href="{{ Illuminate\Support\Facades\Route::has('catalog.article') ? route('catalog.article', ['gioi-thieu', 'gioi-thieu']) : '#' }}">Giới thiệu</a>
                    </li>
                    <li class="navigation-item">
                        <a class="navigation-link" @if(request()->is('/')) href="#activity" @else href="{{ route('catalog.homepage') }}#activity" @endif>Hoạt động</a>
                    </li>
                    <li class="navigation-item">
                        <a class="navigation-link" href="{{ Illuminate\Support\Facades\Route::has('catalog.article') ? route('catalog.article', ['chinh-sach', 'quy-dinh']) : '#' }}">Quy định</a>
                    </li>
                    <li class="navigation-item">
                        <a class="navigation-link" href="javascript:;">
                            <span>Sản phẩm</span>							                                    
                            <i class="fal fa-angle-down"></i>
                        </a>
                        @if(count($categories) > 0)
                            <ul class="list-unstyled mb-0 navigation-sub">
                                <li><a href="{{ Illuminate\Support\Facades\Route::has('catalog.products') ? route('catalog.products') : '#' }}" title="Tất cả sản phẩm">Tất cả sản phẩm</a></li>
                                @foreach($categories as $root)
                                    <li><a href="{{ Illuminate\Support\Facades\Route::has('catalog.productCategory') ? route('catalog.productCategory', $root->slug) : '#' }}">{{ $root->name }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                    <li class="navigation-item">
                        <a class="navigation-link" @if(request()->is('/')) href="#blog" @else href="{{ route('catalog.homepage') }}#blog" @endif>Hướng dẫn</a>
                    </li> 
                    <li class="navigation-item">
                        <a class="navigation-link"  @if(request()->is('/')) href="#comments" @else href="{{ route('catalog.homepage') }}#comments" @endif>Phản hồi</a>
                    </li> 
                    <li class="navigation-item">
                        <a class="navigation-link"  @if(request()->is('/')) href="#contact" @else href="{{ route('catalog.homepage') }}#contact" @endif>Liên hệ</a>
                    </li> 
                    {{-- <div class="header-action ms-auto">
                        <a href="javascript:void(0)" class="js-toggle_search">
                            <i class="fal fa-search"></i>
                        </a>
                    </div>
                    <li class="header-action header-favourite xs-hidden">
                        <a href="/danh-sach-yeu-thich">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.3667 3.84172C16.941 3.41589 16.4357 3.0781 15.8795 2.84763C15.3232 2.61716 14.7271 2.49854 14.125 2.49854C13.5229 2.49854 12.9268 2.61716 12.3705 2.84763C11.8143 3.0781 11.309 3.41589 10.8833 3.84172L10 4.72506L9.11666 3.84172C8.25692 2.98198 7.09086 2.49898 5.875 2.49898C4.65914 2.49898 3.49307 2.98198 2.63333 3.84172C1.77359 4.70147 1.29059 5.86753 1.29059 7.08339C1.29059 8.29925 1.77359 9.46531 2.63333 10.3251L3.51666 11.2084L10 17.6917L16.4833 11.2084L17.3667 10.3251C17.7925 9.89943 18.1303 9.39407 18.3608 8.83785C18.5912 8.28164 18.7099 7.68546 18.7099 7.08339C18.7099 6.48132 18.5912 5.88514 18.3608 5.32893C18.1303 4.77271 17.7925 4.26735 17.3667 3.84172Z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </a>
                    </li> --}}
                    <!-- <li class="header-action header-user xs-hidden">
                        <a href="javascript:void(0)">
                            @if(!session()->exists('userLogin'))
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.6667 17.5V15.8333C16.6667 14.9493 16.3155 14.1014 15.6903 13.4763C15.0652 12.8512 14.2174 12.5 13.3333 12.5H6.66666C5.78261 12.5 4.93476 12.8512 4.30964 13.4763C3.68452 14.1014 3.33333 14.9493 3.33333 15.8333V17.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M10 9.16667C11.841 9.16667 13.3333 7.67428 13.3333 5.83333C13.3333 3.99238 11.841 2.5 10 2.5C8.15906 2.5 6.66667 3.99238 6.66667 5.83333C6.66667 7.67428 8.15906 9.16667 10 9.16667Z" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span>Đăng nhập</span>
                            @else
                                <h3 class="header-welcome">
                                    <span>Xin chào,</span>
                                    <span class="welcome-text">{{ $userLogin->lastname }} {{ $userLogin->firstname }}</span>
                                </h3>
                            @endif
                        </a>
                        <div class="header-user_dropdown">
                            @if(!session()->exists('userLogin'))
                                <div class="button">
                                    <a href="#" class="button-theme button-theme_primary" data-title="Đăng nhập">
                                        <span>Đăng nhập</span>
                                    </a>
                                </div>
                                <div class="text">
                                    Khách mới?
                                    <a href="#">Đăng ký</a>
                                </div>
                            @else
                                <ul class="list-unstyled mb-0">
                                    <li>
                                        <div class="welcome">
                                            <span class="lg-hidden">Xin chào,</span>
                                            <span class="welcome-text">{{ $userLogin->lastname }} {{ $userLogin->firstname }}</span>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.index') }}">
                                            Cập nhật thông tin tài khoản
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.getInvoice') }}">
                                            Quản lý đơn hàng
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.getResetPassword') }}">
                                            Đổi mật khẩu
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('catalog.getClientLogout') }}">
                                            Đăng xuất
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </li>
                    <li class="header-action header-cart xs-hidden">
                        <a href="javascript:void(0)" class="js-toggle_cart">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAADe0lEQVR4nO1aPUwUQRQeMaGRShuxEis18acRCxULItGIjXKxkArOfbOHMWKlFVr4UyhW2kmh+BOxEittpBMLxYRETAAj3MwCiTaARhPzmd1996Ph7maWQyfGL5nkcjvvzfftzr55b2aF+I+lgdFULbLecWh6AE1jUHIhauFvLe9H10ZTtcJlIPBTUHISWqJsUzQBLY8J1wCkVkPJ3gJZeg1Fp6D9LQja10Qt/B39R2+KBF0LbYUrQEHEV2RlByBWleyLnhoomY76shjhzHTS0VP4AkV7jO2UtzcvRntHV5alyYudeyeyssPaXtHJ+KnI8b8aABBFJ34n0FNjbR9OMy1HIh+Bn1oZliZEtHwYk5BdiX0oeZpvxr3qsrMhoel9PDW8zcvwsZWFjFWXnQ0JRfMRidlMXWIfs5k6jl7z1WVnQ4LXA1f8/PtCoOVixXTjz7XFZCKyXescII9f2lTn2gRCMjsrRZM/NbWQi47TtMPeedY7wgM8S0qgikKe83rVmsA5ZfiJ9C15Pes15x951mu2HsDCDzT1MZeM/QCarnJ8v7Dk9bim4HRcjifQYOwHSl5kIVfsB9Cyn52nS1yfLqo/phJoMPaDOO0P+/TbD6DkUCzEbylB4FBMgqagvYMJNBj7gfJb+KYO2Q+g5Ifl5lHVAsLqMhYymSS9/rbcPKpaQD4fk9+tygV87NrAc/KTcATQ9DniNOfVmxsF3m4WMiIcATS9jdcSakxQh8snwhFA0SBHtjZzI+2d5Tl5UzgCKLrFQrrNjTTdYCHnhCOAovPMqdfG6DGv6ieEI4D221nIgLmRoldstE84AmiviTkNmxspCjhCbBSOAEG6gYVoi003+hE1h3bNYcsLM/4mjg5KOAYoqeOZkm6o3Fn7+/kRvhSOAUoOxzfZa7KIDvRIOAYoOWAcTYvi9XXhGJA7vjBZ3/IrqJJnhGOApm7jjAOKnnKe5dzRGDS18dQaNM8ytb9LOAYE1Giclefz/tnMeuEYMOfVG9VJ+UosrA4THNysNGBauRZqY5oQjgK5o75yewmF3Qp6IRwF8rs7dKBMJ+rkTneEo4CiuxUPX8NdRc6zLglHAS0vl9sB/W2P1ZPCUUBLn2/2bVF519s/LBwFAtla6ZRA8Bc8wIy3TTgKTPvbWci70p2iz5EcOJnSBk3JhaVFuHjUVqkVHcX9BAM1EPcWNSmhAAAAAElFTkSuQmCC">
                            <span>
                                Giỏ hàng (<span class="cart-number">0</span>)
                            </span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="header-search" id="header-search">
        <div class="container px-3">
            <div class="row">
                <div class="col-12">
                    <form action="" id="frmSearch" class="frmSearch-form">
                        <input type="text" class="frmSearch-input" placeholder="Hôm nay bạn cần tìm sản phẩm gì...?">
                        <button type="submit" class="frmSearch-button">
                            <i class="fal fa-search"></i>
                        </button>
                    </form>
                    <div class="header-search_result" id="frmSearch-result"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-overlay" id="header-overlay"></div>
</header>