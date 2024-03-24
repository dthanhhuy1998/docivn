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
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group">
                    <a href="{{ route('admin.video.getAdd') }}" class="btn btn-primary btn-sm mr-1" title="Thêm video mới"><i class="fa fa-plus"></i> Thêm video mới</a>
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
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $pageTitle }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table @if(count($videos) > 0) id="datatable" @endif class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="20">STT</th>
                                    <th width="15%">Thumbnail</th>
                                    <th width="20%">Tiêu đề</th>
                                    <th>Mô tả</th>
                                    <th>Đường dẫn</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($videos) > 0)
                                    @php $count = 0; @endphp
                                    @foreach($videos as $video)
                                        @php $count++; @endphp
                                        <tr>
                                            <td>{{ $count }}</td>
                                            <td>
                                                <div class="preview-image" style="width: 200px; height: auto;">
                                                    <img src="@if(!empty($video->thumbnail)) {{ asset('storage/app/'.$video->thumbnail) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                                </div>
                                            </td>
                                            <td>{{ $video->title }}</td>
                                            <td>{!! $video->description !!}</td>
                                            <td>
                                                <a href="{{ $video->youtube }}" class="btn btn-info btn-sm" target="blank"><i class="fa fa-link"></i> {{ $video->youtube }}</a>
                                            </td>
                                            <td>{{ date_format(date_create($video->created_at), 'd/m/Y H:i') }}</td>
                                            <td>
                                                @if($video->status == 1)
                                                    <small class="label pull-right bg-green">Hiển thị</small>
                                                @else
                                                    <small class="label pull-right bg-red">Không hiển thị</small>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.video.getEdit', $video->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                <a 
                                                    href="{{ route('admin.video.getDelete', $video->id) }}" 
                                                    class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa video này?');"
                                                >
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" align="center"><span class="text-red">Không có video nào!</span></td>
                                    </tr>
                                @endif
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

@section('script')
<script>
  $(function () {
    $('#datatable').DataTable();
  })
</script>
@endsection