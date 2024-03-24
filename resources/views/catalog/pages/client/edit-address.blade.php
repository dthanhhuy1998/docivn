@extends('catalog.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Banner Title -->
   <div class="banner" style="background-image: url('{{ asset('public/catalog/assets//img/bg1.jpg') }}')">
        <h1 class="banner-title">{{ $pageTitle }}</h1>
    </div>
    <!-- ./end Banner title -->
    <nav class="breadcrumb__wrap">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
            </ol>
        </div>
    </nav>
    <div class="client-wrap">
        <div class="container">
           <div class="row">
               <div class="col-md-3">
                   @include('catalog.common.sidebar-client')
               </div>
               <div class="col-md-9">
                   <div class="clientPanel">
                       <div class="clientPanel__heading">
                            <h2 class="clientPanel__heading-title">{{ $pageTitle }}</h2>
                       </div>
                       <div class="clientPanel__body">
                             <div class="form-group">
                                <a href="{{ route('client.getAddress') }}" class="btn btn-sm btn-light mt-3"><i class="fa fa-angle-left"></i> Quay lại</a>
                            </div>
                            <form action="{{ route('client.address.postEditAddress') }}" class="accountForm" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(session('success_msg'))
                                        <div class="alert alert-success with-border" role="alert">
                                            <h4 class="alert__title"><i class="fa fa-check-circle"></i> Thành công</h4>
                                            <p class="alert__message">
                                                <span>{{ session('success_msg') }}</span>
                                            </p>
                                        </div>
                                        @endif
                                        @if (session('error_msg'))
                                        <div class="alert alert-danger with-border" role="alert">
                                            <h4 class="alert__title"><i class="fa fa-exclamation-triangle"></i> Lỗi!</h4>
                                            <p class="alert__message">
                                                <span>{{ session('error_msg') }}</span>
                                            </p>
                                        </div>
                                        @endif
                                        @if ($errors->any())
                                        <div class="alert alert-danger with-border" role="alert">
                                            <h4 class="alert__title"><i class="fa fa-exclamation-triangle"></i> Lỗi!</h4>
                                            <p class="alert__message">
                                                @foreach ($errors->all() as $error)
                                                    <span>{{ $error }}</span>
                                                @endforeach
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" value="{{ $address->id }}" name="id">
                                        <div class="form-group">
                                            <label><strong style="color: red;">*</strong>Họ và tên</label>
                                            <input type="text" class="form-control" placeholder="Nhập họ và tên người nhận" name="name" value="{{ $address->customer_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><strong style="color: red;">*</strong>Số điện thoại</label>
                                            <input type="number" class="form-control" placeholder="Nhập số điện thoại người nhận" name="phone" value="{{ $address->customer_phone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong style="color: red;">*</strong>Tỉnh/Thành Phố</label>
                                            <select name="province" class="form-control province">
                                                @foreach($provinces as $province)
                                                    <option
                                                        value="{{ $province->matp }}"
                                                        @if($address->province_id == $province->matp)
                                                            selected="selected"
                                                        @endif
                                                    >{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong style="color: red;">*</strong>Quận/Huyện</label>
                                            <select name="district" class="form-control district">
                                                <option value="{{ $address->district->maqh }}">{{ $address->district->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong style="color: red;">*</strong>Xã/Thị trấn</label>
                                            <select name="ward" class="form-control ward">
                                                <option value="{{ $address->ward->xaid }}">{{ $address->ward->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Địa chỉ cụ thể</label>
                                            <textarea name="address" rows="3" class="form-control">{{ $address->address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Lưu thông tin địa chỉ nhận hàng</button>
                                    </div>
                                </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $('.province').on('change', function(e) {
        let provinceId = $(this).val();
        if(provinceId != '') {
            $.ajax({
                url: '{{ route("ajax.getDistrictByProvinceId") }}',
                method: 'post',
                dataType: 'json',
                data: {
                    '_token': '{{ csrf_token() }}',
                    provinceId: provinceId
                },
                success: function(response) {
                    if(response.status == 200)
                        $('.district').html(response.data);
                }
            });
        } else {
            $('.district').html('<option value="">-- Chọn Quận/Huyện --</option>');
            $('.ward').html('<option value="">-- Chọn Xã/Thị trấn --</option>');
        }
    });

    $('.district').on('change', function(e) {
        let districtId = $(this).val();
        $.ajax({
            url: '{{ route("ajax.getWardByDistrictId") }}',
            method: 'post',
            dataType: 'json',
            data: {
                '_token': '{{ csrf_token() }}',
                districtId: districtId
            },
            success: function(response) {
                if(response.status == 200)
                    $('.ward').html(response.data);
            }
        });
    });
</script>
@endsection