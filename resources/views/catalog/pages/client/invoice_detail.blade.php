
<!doctype html>
<html lang="vi">
<head>
	<meta http-equiv="content-language" content="vi"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="msapplication-TileColor" content="#f5f5f5">
    <meta name="theme-color" content="#f5f5f5">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="shortcut icon" type="image/png" href="{{ $favicon }}"/>
    <noscript>
    <style>
        body {
            display: none !important;
        }
    </style>
    </noscript>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta name="robots" content="index"/>
    <meta name="revisit-after" content="1 days"/>

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

	<link rel="stylesheet" href="{{ asset('public/catalog/assets/view/theme_user/invoice/css/reboot.css') }}">
	<link rel="stylesheet" href="{{ asset('public/catalog/assets/view/theme_user/invoice/fonts/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('public/catalog/assets/view/theme_user/invoice/css/style.css') }}">
</head>
<body>
    <div class="invoice-main">
        <div class="invoice-header">
            <div class="invoice-button">
                <button type="button" onclick="window.print()">
                    <i class="far fa-print"></i>
                    In hóa đơn
                </button>
            </div>
            <div class="invoice-company">
                <div class="invoice-company_logo">
                    <img src="{{ $logo }}" alt="Dociperfume.vn | Nước hoa DOCI Perfume chính hãng">
                </div>
                <div class="invoice-company_name">
                    <h1>{{ env('APP_NAME') }} | Nước hoa DOCI Perfume chính hãng</h1>
                </div>
                <div class="invoice-company_desc">
                    <div class="desc-item">
                        <i class="fas fa-phone-alt"></i>
                        Hotline: {{ $phone }}				
                    </div>
                    <div class="desc-item">
                        <i class="fas fa-envelope"></i>
                        Email: {{ $gmail }}</div>
                    <div class="desc-item desc-item_full">
                        <i class="fas fa-map-marker-alt"></i>
                        Địa chỉ: Đang cập nhật.....				
                    </div>
                </div>
            </div>
        </div>
        <div class="invoice-body">
            <div class="invoice-information">
                <div class="invoice-information_item invoice-information_name">
                    Khách hàng:
                </div>
                <div class="invoice-information_item">
                    Họ & tên: <b>{{ $invoice->customer_name }}</b>
                </div>
                <div class="invoice-information_item">
                    Số điện thoại: <b>{{ $invoice->customer_phone }}</b>
                </div>
                                    <div class="invoice-information_item">
                        Email: <b>{{ $invoice->customer_email }}</b>
                    </div>
                    <div class="invoice-information_item">
                        Địa chỉ: <b>{{ $invoice->address }}</b>
                    </div>
                            </div>
            <div class="invoice-status">
                <div class="invoice-status_inner">
                    <div class="invoice-status_item invoice-status_name">
                        Đơn hàng:
                    </div>
                    <div class="invoice-status_item">
                        Mã đơn hàng: <b>HD{{ $invoice->id }}</b>
                    </div>
                    <div class="invoice-status_item">
                        Ngày mua: <b>{{ date_format(date_create(), 'H:i:s d-m-Y') }}</b>
                    </div>
                    <div class="invoice-status_item">
                        Trạng thái: <strong class="{{  $invoice->getStatus->style }}">{{  $invoice->getStatus->text }}</strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="invoice-footer">
            <div class="invoice-table">
                <div class="invoice-table_header">
                    <div class="invoice-table_column invoice-table_stt">#</div>
                    <div class="invoice-table_column invoice-table_title">Sản phẩm</div>
                    <div class="invoice-table_column invoice-table_qty">Số lượng</div>
                    <div class="invoice-table_column invoice-table_price">Đơn giá</div>
                    <div class="invoice-table_column invoice-table_price">Thành tiền</div>
                </div>
                @if(count($details) > 0)
                <div class="invoice-table_body">
                    @php 
                        $count = 0; 
                        $priceTotal = 0;
                    @endphp
                    @foreach($details as $item)
                        @php  
                            $count++;
                            $priceTotal += $item->product_qty*$item->product_price; 
                        @endphp
                        <div class="invoice-table_item">
                            <div class="invoice-table_column invoice-table_stt">{{ $count }}</div>
                            <div class="invoice-table_column invoice-table_title">
                                {{ $item->product->productDescription->name }}
                                <small>
                                    Dung tích: <b>25ml</b>
                                </small>
                            </div>
                            <div class="invoice-table_column invoice-table_qty">
                                x{{ number_format($item->product_qty) }}						
                            </div>
                            <div class="invoice-table_column invoice-table_price">
                                {{ number_format($item->product_price) }}đ						
                            </div>
                            <div class="invoice-table_column invoice-table_price">
                                {{ number_format($item->product_qty*$item->product_price) }}đ						
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="invoice-total">
                    <div class="invoice-total_item">
                        <div class="text">Tạm tính:</div>
                        <div class="value">{{ number_format($priceTotal) }}đ</div>
                    </div>
                    <div class="invoice-total_item">
                        <div class="text">Vận chuyển:</div>
                        <div class="value">Miễn phí</div>
                    </div>
                    <div class="invoice-total_item invoice-total_item__large">
                        <div class="text">Tổng tiền:</div>
                        <div class="value">{{ number_format($priceTotal) }}đ</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>