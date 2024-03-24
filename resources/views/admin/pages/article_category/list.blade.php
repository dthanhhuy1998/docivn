@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $pageTitle }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li><a href="#"><i class="fa fa-th"></i> Bài viết</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.article.category.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Thêm mới"><i class="fa fa-plus"></i> Thêm mới</a>
                </div>
            </div>
            <div class="col-md-12">
                @if(session('success_msg'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                    <h4><i class="icon fa fa-check"></i> Thành công</h4>
                    {{ session('success_msg') }}
                </div>
                @endif
                @if(session('warning_msg'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                    <h4><i class="icon fa fa-exclamation"></i> Cảnh báo</h4>
                    {{ session('warning_msg') }}
                </div>
                @endif
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-list"></i> {{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên danh mục</th>
                                    <th>Vị trí</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($articleCategories as $articleCategory)
                                    @php $count++; @endphp
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $articleCategory->name }}</td>
                                        <td>{{ $articleCategory->sort_order }}</td>
                                        <td>{{ $articleCategory->created_at }}</td>
                                        <td>
                                            @if($articleCategory->status == 1)
                                                <small class="label bg-green">Hiển thị</small>
                                            @else
                                                <small class="label bg-red">Vô hiệu hóa</small>
                                            @endif
                                        </td>
                                        <td width="10%">
                                            <a href="{{ route('admin.article.category.getEdit', [$articleCategory->id]) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.article.category.getDelete', [$articleCategory->id]) }}" class="btn btn-danger btn-sm" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa danh mục này. Xóa?');"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @if(count($articleCategory->subCategories) > 0)
                                        @foreach($articleCategory->subCategories as $subCategory)
                                            @php $count++; @endphp
                                            <tr>
                                                <td>{{ $count }}</td>
                                                <td>|-- {{ $subCategory->name }}</td>
                                                <td>{{ $subCategory->sort_order }}</td>
                                                <td>{{ $subCategory->created_at }}</td>
                                                <td>
                                                    @if($subCategory->status == 1)
                                                        <small class="label bg-green">Hiển thị</small>
                                                    @else
                                                        <small class="label bg-red">Vô hiệu hóa</small>
                                                    @endif
                                                </td>
                                                <td width="10%">
                                                    <a href="{{ route('admin.article.category.getEdit', [$subCategory->id]) }}" class="btn btn-primary btn-sm" title="Chỉnh sửa"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('admin.article.category.getDelete', [$subCategory->id]) }}" class="btn btn-danger btn-sm" title="Xóa bỏ" onclick="return confirm('Bạn có chắn chắn muốn xóa danh mục này. Xóa?');"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

<?php
    function showCategories($categories, $parent_id = 0, $char = '') {
        foreach($categories as $key => $item) {
            if($item->parent_id == $parent_id) {

                echo '<option value="'.$item->id.'">'.$item->name.'</option>';

                unset($categories[$key]);

                showCategories($categories, $item->id, $char = '--');
            }
        }
    }

?>


@section('script')
<script>
  $(function () {
    $('#datatable').DataTable();
  })
</script>
@endsection