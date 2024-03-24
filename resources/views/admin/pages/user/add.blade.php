@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Tài khoản</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li class="active">Tài khoản</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="{{ route('admin.user.postAdd') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                        <a href="{{ route('admin.user.getList') }}" class="btn btn-default btn-sm" title="Hủy bỏ"><i class="fa fa-undo"></i> Quay lại</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-plus"></i> {{ $actionTitle }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('username') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Tên tài khoản</label>
                                <input type="text" class="form-control" placeholder="Nhập tên tài khoản" value="{{ old('username') }}" name="username">
                                @error('username')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nhóm người dùng</label>
                                <select name="user_group_id" class="form-control">
                                    @foreach($userGroups as $userGroup)
                                        <option value="{{ $userGroup->id }}">{{ $userGroup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group @error('lastname') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Họ</label>
                                <input type="text" class="form-control" placeholder="Nhập họ" value="{{ old('lastname') }}" name="lastname">
                                @error('lastname')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('firstname') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Tên</label>
                                <input type="text" class="form-control" placeholder="Nhập tên" value="{{ old('firstname') }}" name="firstname">
                                @error('firstname')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Nhập email"  value="{{ old('user_email') }}" name="user_email">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="preview-image">
                                    <img src="{{ asset('storage/app/uploads/default.png') }}" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" name="file">
                            </div>
                            <div class="form-group @error('user_password') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Mật khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập mật khẩu" value="{{ old('user_password') }}" name="user_password">
                                @error('user_password')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('password_confirm') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" value="{{ old('password_confirm') }}" name="password_confirm">
                                @error('password_confirm')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="1">Kích hoạt</option>
                                    <option value="0">Vô hiệu hóa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection