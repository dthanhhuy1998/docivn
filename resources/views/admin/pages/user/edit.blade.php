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
        <form action="{{ route('admin.user.postEdit') }}" role="form" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $user->id }}" name="id">
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
                            <h3 class="box-title"><i class="fa fa-edit"></i> {{ $actionTitle }}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group @error('username') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Tên tài khoản</label>
                                <input type="text" class="form-control" placeholder="Nhập tên tài khoản" value="{{ $user->username }}" name="username">
                                @error('username')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nhóm người dùng</label>
                                <select name="user_group_id" class="form-control">
                                    @foreach($userGroups as $userGroup)
                                        <option
                                            value="{{ $userGroup->id }}"
                                            @if($user->user_group_id == $userGroup->id)
                                                selected
                                            @endif
                                        >{{ $userGroup->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group @error('lastname') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Họ</label>
                                <input type="text" class="form-control" placeholder="Nhập họ" value="{{ $user->lastname }}" name="lastname">
                                @error('lastname')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('firstname') has-error @enderror">
                                <label><strong class="color-red font-15">*</strong> Tên</label>
                                <input type="text" class="form-control" placeholder="Nhập tên" value="{{ $user->firstname }}" name="firstname">
                                @error('firstname')
                                    <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" placeholder="Nhập email"  value="{{ $user->email }}" name="user_email">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="preview-image">
                                    <img src="@if(!empty($user->image)) {{ asset('storage/app/' . $user->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Avatar" id="preview">
                                </div>
                                <input type="file" onchange="filePreview(event)" name="file">
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <select name="status" class="form-control">
                                    <option value="1" @if($user->status == 1) selected @endif>Kích hoạt</option>
                                    <option value="0" @if($user->status == 0) selected @endif>Vô hiệu hóa</option>
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