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
                            <p class="clientPanel__heading-desc">Danh sách địa chỉ nhận hàng của bạn</p>
                       </div>
                       <div class="clientPanel__body">
                            <a href="#" type="button" class="btn btn-primary btn-address" data-bs-toggle="modal" data-bs-target="#add_address_modal"><i class="fa fa-plus"></i> Thêm địa chỉ mới</a>
                            <div class="addressBox" id="address_list"></div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_address_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Địa chỉ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="add_address_form" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label><strong style="color: red;">*</strong>Họ và tên</label>
                            <input type="text" class="form-control" placeholder="Nhập họ và tên người nhận" name="name">
                        </div>
                        <div class="form-group">
                            <label><strong style="color: red;">*</strong>Số điện thoại</label>
                            <input type="number" class="form-control" placeholder="Nhập số điện thoại người nhận" name="phone">
                        </div>
                        <div class="form-group">
                            <label><strong style="color: red;">*</strong>Tỉnh/Thành Phố</label>
                            <select name="province" class="form-control province">
                                <option value="">-- Chọn Tỉnh/Thành Phố --</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->matp }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong style="color: red;">*</strong>Quận/Huyện</label>
                            <select name="district" class="form-control district">
                                <option value="">-- Chọn Quận/Huyện --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong style="color: red;">*</strong>Xã/Thị trấn</label>
                            <select name="ward" class="form-control ward">
                                <option value="">-- Chọn Xã/Thị trấn --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ cụ thể</label>
                            <textarea name="address" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Trở lại</button>
                        <button type="submit" class="btn btn-primary">Hoàn thành</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(function() {
        addressList();
    });

    $('body').on('click', '.delete_address', function(e) {
        e.preventDefault();
        var address_id = $(this).attr('data-id');
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa địa chỉ này. Xóa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E74C3C',
            cancelButtonColor: '#808B96',
            confirmButtonText: 'Có, tôi đồng ý!',
            cancelButtonText: 'Quay lại',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("client.deleteAddress") }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        address_id: address_id
                    },
                    success: function(response) {
                        if(response.status == 200) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Đã xóa địa chỉ nhận hàng thành công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            addressList();z
                        }
                    }
                });
            }
        })
    });

    $("#add_address_form").validate({
        rules: {
            name: 'required',
            phone: 'required',
            province: 'required',
            district: 'required',
            ward: 'required'
        },
        messages: {
            name: 'Họ và tên không được để trống!',
            phone: 'Số điện thoại không được để trống!',
            province: 'Vui lòng chọn tỉnh/thành phố!',
            district: 'Vui lòng chọn quận/huyện!',
            ward: 'Vui lòng chọn xã/thị trấn!',
        },
        submitHandler: function(form) {
            $.ajax({
                url: '{{ route("client.addAddress") }}',
                method: 'post',
                dataType: 'json',
                data: $('#add_address_form').serialize(),
                success: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Tạo địa chỉ nhận hàng thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    resetForm();
                    $('#add_address_modal').modal('hide');
                    addressList();
                }
            });
        }
    });

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

    function addressList() {
        $.ajax({
            url: '{{ route("client.addressList") }}',
            method: 'post',
            dataType: 'json',
            data: {
                '_token': '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.status == 200)
                    $('#address_list').html(response.data);
            }
        });
    }
    function resetForm() {
        $('#add_address_form')[0].reset();
        $('.district').html('<option value="">-- Chọn Quận/Huyện --</option>');
        $('.ward').html('<option value="">-- Chọn Xã/Thị trấn --</option>');
    }
</script>
@endsection