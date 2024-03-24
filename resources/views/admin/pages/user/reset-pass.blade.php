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
        <form action="{{ route('admin.user.postResetPass') }}" role="form" method="post">
            @csrf
            <input type="hidden" value="{{ $user->id }}" name="id">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-sm mr-1" title="Lưu lại"><i class="fa fa-save"></i> Lưu lại</button>
                        <a href="{{ route('admin.user.getList') }}" class="btn btn-default btn-sm" title="Hủy bỏ"><i class="fa fa-undo"></i> Quay lại</a>
                    </div>
                </div>
                <div class="col-md-4">
                     <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <img class="profile-user-img img-responsive img-circle" src="@if(!empty($user->image)) {{ asset('storage/app/' . Auth::user()->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar">
                            <h3 class="profile-username text-center">{{ $user->lastname }} {{ $user->firstname }}</h3>
                            <p class="text-muted text-center">{{ $user->userGroup->name }}</p>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Tên tài khoản</b> <a class="pull-right">{{ $user->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="pull-right">{{ $user->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Ngày tạo</b> <a class="pull-right">{{ datetime_vi($user->created_at) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tình trạng</b>
                                    @if($user->status == 1)
                                        <a class="pull-right"><small class="label bg-green">Kích hoạt</small></a>
                                    @else
                                        <a class="pull-right"><small class="label bg-red">Vô hiệu hóa</small></a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-lock"></i> {{ $titlePage }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('user_password') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Mật khẩu mới</label>
                                <input type="password" class="form-control" placeholder="Nhập mật khẩu mới" value="{{ old('user_password') }}" name="user_password">
                                @error('user_password')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('password_confirm') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" value="{{ old('password_confirm') }}" name="password_confirm">
                                @error('password_confirm')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- /.content -->
@endsection