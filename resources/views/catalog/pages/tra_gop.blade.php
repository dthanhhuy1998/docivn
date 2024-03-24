@extends('catalog.common.layout')

@section('content')
    <!-- ./end Banner title -->
    <nav class="breadcrumb__wrap">
        <div class="container">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item"><a href="{{ route('catalog.homepage') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Trả góp</li>
            </ol>
        </div>
    </nav>
    <div class="article-wrap">
        <div class="container">
            <div class="cart" style="margin-bottom: 15px;">
                @if(session('success_msg'))
                <div class="alert alert-success" role="alert">
                    {{ session('success_msg') }}
                </div>
                @endif
            </div>
            <div class="installment-container">
                <h2 class="installment__title">
                    <span>Mua trả góp</span>
                    <strong>{{ $product->productDescription->name }}</strong>,
                    giá bán <strong class="text-red">{{ number_format($product->price) }} VNĐ</strong>
                </h2>

                <ul class="nav nav-pills installment" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-finance-tab" data-bs-toggle="pill" data-bs-target="#pills-finance" type="button" role="tab" aria-controls="pills-finance" aria-selected="true">
                            <span>CÔNG TY TÀI CHÍNH</span>
                            <span>Duyệt online trong 4 giờ</span>
                        </button>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-credit-tab" data-bs-toggle="pill" data-bs-target="#pills-credit" type="button" role="tab" aria-controls="pills-credit" aria-selected="false">
                            <span>QUA THẺ TÍNH DỤNG</span>
                            <span>Không cần xét duyệt</span>
                        </button>
                    </li> -->
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-finance" role="tabpanel" aria-labelledby="pills-finance-tab">
                        <form action="" class="form-percent">
                            <div class="form-group">
                                <label for="">CHỌN NHÀ CHO VAY</label>
                                <select name="vendor">
                                    <option value="hd_saigon">HDSAIGON</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">TRẢ TRƯỚC</label>
                                <select id="percent" name="interestPercent">
                                    <option value="20">Trả trước 20%</option>
                                    <option value="30">Trả trước 30%</option>
                                    <option value="40">Trả trước 40%</option>
                                    <option value="50">Trả trước 50%</option>
                                    <option value="60">Trả trước 60%</option>
                                    <option value="70">Trả trước 70%</option>
                                    <option value="80">Trả trước 80%</option>
                                </select>
                            </div>
                        </form>
                        <div class="tra-gop-table">
                            <h2 class="tra-gop-table-heading">Trả góp qua công ty tài chính - HD SaiGon</h2>
                            <table id="tra_gop_data">
                                <thead>
                                    <tr>
                                        <td class="row-head">Gói trả góp</td>
                                        <td><strong>6 tháng (Lãi 0%)</strong></td>
                                        <td><strong>9 tháng</strong></td>
                                        <td><strong>12 tháng</strong></td>
                                        <td><strong>18 tháng</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="row-head">Gói sản phẩm</td>
                                        <td class="text-red">{{ number_format($product->price) }} đ</td>
                                        <td class="text-red">{{ number_format($product->price) }} đ</td>
                                        <td class="text-red">{{ number_format($product->price) }} đ</td>
                                        <td class="text-red">{{ number_format($product->price) }} đ</td>
                                    </tr>
                                    <tr>
                                        <td class="row-head">Trả trước</td>
                                        <td class="text-red">{{ number_format(tra_truoc($product->price, 20)) }} đ</td>
                                        <td class="text-red">{{ number_format(tra_truoc($product->price, 20)) }} đ</td>
                                        <td class="text-red">{{ number_format(tra_truoc($product->price, 20)) }} đ</td>
                                        <td class="text-red">{{ number_format(tra_truoc($product->price, 20)) }} đ</td>
                                    </tr>
                                    <tr>
                                        <td class="row-head">Số tiền vay</td>
                                        <td class="text-red">{{ number_format(so_tien_vay($product->price, tra_truoc($product->price, 20))) }} đ</td>
                                        <td class="text-red">{{ number_format(so_tien_vay($product->price, tra_truoc($product->price, 20))) }} đ</td>
                                        <td class="text-red">{{ number_format(so_tien_vay($product->price, tra_truoc($product->price, 20))) }} đ</td>
                                        <td class="text-red">{{ number_format(so_tien_vay($product->price, tra_truoc($product->price, 20))) }} đ</td>
                                    </tr>
                                    <tr>
                                        <td class="row-head">Góp mỗi tháng</td>
                                        <td class="text-red">{{ number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 6)) }} đ</td>
                                        <td class="text-red">{{ number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 9)) }} đ</td>
                                        <td class="text-red">{{ number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 12)) }} đ</td>
                                        <td class="text-red">{{ number_format(tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 18)) }} đ</td>
                                    </tr>
                                    <tr>
                                        <td class="row-head">Chênh lệch với giá mua thẳng (<strong style="color: red">*</strong>)</td>
                                        <td>{{ number_format((((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 6)*6) + tra_truoc($product->price, 20)) - $product->price) + (so_tien_vay($product->price, tra_truoc($product->price, 20))*0.085)) }} đ</td>
                                        <td>{{ number_format(((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 9)*9) + tra_truoc($product->price, 20)) - $product->price) }} đ</td>
                                        <td>{{ number_format(((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 12)*12) + tra_truoc($product->price, 20)) - $product->price) }} đ</td>
                                        <td>{{ number_format(((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 18)*18) + tra_truoc($product->price, 20)) - $product->price) }} đ</td>
                                    </tr>
                                    <tr>
                                        <td class="row-head">Giá sản phẩm khi mua trả góp</td>
                                        <td class="text-red">{{ number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 6)*6) + tra_truoc($product->price, 20)) }}  đ</td>
                                        <td class="text-red">{{ number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 9)*9) + tra_truoc($product->price, 20)) }} đ</td>
                                        <td class="text-red">{{ number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 12)*12) + tra_truoc($product->price, 20)) }} đ</td>
                                        <td class="text-red">{{ number_format((tien_gop(so_tien_vay($product->price, tra_truoc($product->price, 20)), 18)*18) + tra_truoc($product->price, 20)) }} đ</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><button type="submit" class="choose-bank" data="20,6">CHỌN MUA</button></td>
                                        <td><button type="submit" class="choose-bank" data="20,9">CHỌN MUA</button></td>
                                        <td><button type="submit" class="choose-bank" data="20,12">CHỌN MUA</button></td>
                                        <td><button type="submit" class="choose-bank" data="20,18">CHỌN MUA</button></td>
                                    </tr>
                                </tbody>
                                <div class="overlay">
                                    <img src="{{ asset('public/catalog/assets/img/refresh.gif') }}" alt="Refresh">
                                </div>
                            </table>
                            (<strong style="color: red">*</strong>): Phí làm hồ sơ
                        </div>
                        <form class="tra-gop-form" id="tra_gop_form" method="post">
                            <h2 class="tra-gop-form-heading">Gửi yêu cầu trả góp</h2>
                            <input type="hidden" name="pName" value="{{ $product->productDescription->name }}">
                            <input type="hidden" name="pImage" value="{{ $product->image }}">
                            <div class="form-group">
                                <label>Họ & tên</label>
                                <input type="text" placeholder="Nhập họ tên của bạn" name="name">
                            </div>
                            <div class="form-group">
                                <label>CMND</label>
                                <input type="number" placeholder="Nhập số CMND của bạn" name="cardId">
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="number" placeholder="Nhập số điện thoại của bạn" name="phone">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" placeholder="Nhập email của bạn" name="email">
                            </div>
                            <div class="form-group">
                                <label>Tỉnh thành</label>
                                <select name="province">
                                    <option value="">-- Chọn tỉnh thành --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->matp }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Ghi chú</label>
                                <textarea name="note" rows="5" placeholder="Nhập nội dung ghi chú"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-request">GỬI YÊU CẦU</button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="tab-pane fade" id="pills-credit" role="tabpanel" aria-labelledby="pills-credit-tab">thẻ tín dụng</div> -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('#percent').on('change', function(e) {
        $.ajax({
            url: '{{ route("catalog.tienGopThang") }}',
            method: 'post',
            dataType: 'json',
            data: {
                '_token': '{{ csrf_token() }}',
                percent: $(this).val()
            },
            beforeSend: function() {
                $('.overlay').addClass('active');
            },
            success: function(res) {
                if(res.status == 200) {
                    $('.overlay').removeClass('active');
                    $('#tra_gop_data').html(res.data);
                }
            }
        })
    });

    $('body').on('click', '.choose-bank', function(e) {
        e.preventDefault();
        $('.choose-bank.active').removeClass('active');
        $(this).addClass('active');
    });

    $("#tra_gop_form").validate({
        rules: {
            name: 'required',
            phone: 'required',
            province: 'required',
        },
        messages: {
            name: 'Họ và tên không được để trống!',
            phone: 'Số điện thoại không được để trống!',
            province: 'Vui lòng chọn tỉnh!',
        },
        submitHandler: function(form) {
            $.ajax({
                url: '{{ route("catalog.postTraGop") }}',
                method: 'post',
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    p_name: $("input[name='pName']").val(),
                    p_image: $("input[name='pImage']").val(),
                    name: $("input[name='name']").val(),
                    card_id: $("input[name='cardId']").val(),
                    phone: $("input[name='phone']").val(),
                    email: $("input[name='email']").val(),
                    province: $("select[name='province']").val(),
                    note: $("textarea[name='note']").val(),
                    tra_gop: $('.choose-bank.active').attr('data')
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Bạn đã yêu cầu mua trả góp thành công',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.href='{{ route("catalog.homepage") }}';
                }
            })
        }
    });

    // $('.choose-bank.active').attr('data')
</script>
@endsection