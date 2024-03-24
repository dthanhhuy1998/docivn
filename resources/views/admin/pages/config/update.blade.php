@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $pageTitle }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> Trang chính</a></li>
            <li class="active">{{ $pageTitle }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
               
                @if(session('warning_msg'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                    <h4><i class="icon fa fa-exclamation"></i> Cảnh báo</h4>
                    {{ session('warning_msg') }}
                </div>
                @endif
            </div>
            <div class="col-md-12">
                <form action="{{ route('admin.system.config.postUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu cấu hình</button>
                    </div>
                    @if(session('success_msg'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                            <h4><i class="icon fa fa-check"></i> Thành công</h4>
                            {{ session('success_msg') }}
                        </div>
                    @endif
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Chung</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Giao diện</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Mạng xã hội</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Khác</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="form-group">
                                    <label>Tiêu đề trang</label>
                                    <input type="text" class="form-control" name="heading" placeholder="Nhập tiêu đề trang" value="{{ $heading }}">
                                </div>
                                <div class="form-group">
                                    <label>Favicon</label>
                                    <div class="preview-image">
                                        <img src="{{ asset('storage/app/'.$favicon) }}" alt="Image" id="favicon-preview">
                                    </div>
                                    <input type="file" class="form-control" name="favicon" id="favicon">
                                </div>
                                
                                <div class="form-group">
                                    <label>Logo</label>
                                    <div class="preview-image">
                                        <img src="{{ asset('storage/app/'.$logo) }}" alt="Image" id="logo-preview">
                                    </div>
                                    <input type="file" class="form-control" name="logo" id="logo">
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="description" class="form-control textarea">{{ $description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Từ khóa</label>
                                    <input type="text" class="form-control" name="keyword" placeholder="Nhập danh sách từ khóa" value="{{ $keyword }}">
                                </div>
                                <div class="form-group">
                                    <label>Nội dung chân trang</label>
                                    <textarea name="contact" class="form-control" id="editor1">{{ $contact }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Điện thoại</label>
                                    <input type="text" class="form-control" name="phone" placeholder="+84" value="{{ $phone }}">
                                </div>
                                <div class="form-group">
                                    <label>Copy right</label>
                                    <input type="text" class="form-control" name="copyright" placeholder="Nhập thông báo về bản quyền" value="{{ $copyright }}">
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="form-group">
                                    <p>Tất những đoạn code dưới đây sẽ được cài đặt vào phần dưới của thẻ <span class="label label-primary">&lt;header&gt;</span></p>
                                    <textarea name="code_header" class="form-control" rows="8" placeholder="Dán đoạn <srcipt> phần header vào đây">{{ $codeHeader }}</textarea>
                                </div>
                                <div class="form-group">
                                    <p>Tất những đoạn code dưới đây sẽ được cài đặt vào phần trong của thẻ <span class="label label-primary">&lt;body&gt;</span></p>
                                    <textarea name="code_footer" class="form-control" rows="8" placeholder="Dán đoạn <srcipt> phần body vào đây">{{ $codeFooter }}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="form-group">
                                    <label>Gmail</label>
                                    <input type="text" class="form-control" name="gmail" placeholder="example@gmail.com" value="{{ $gmail }}">
                                </div>
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="text" class="form-control" name="facebook" placeholder="URL Fanpage của bạn" value="{{ $facebook }}">
                                </div>
                                <div class="form-group">
                                    <label>Youtube</label>
                                    <input type="text" class="form-control" name="youtube" placeholder="URL Profile kênh Youtube của bạn" value="{{ $youtube }}">
                                </div>
                                <div class="form-group">
                                    <label>Zalo</label>
                                    <input type="text" class="form-control" name="zalo" placeholder="Số điện thoại Zalo" value="{{ $zalo }}">
                                </div>
                                <div class="form-group">
                                    <label>Instagram</label>
                                    <input type="text" class="form-control" name="instagram" placeholder="URL Instagram của bạn" value="{{ $instagram }}">
                                </div>
                                <div class="form-group">
                                    <label>Tiktok</label>
                                    <input type="text" class="form-control" name="tiktok" placeholder="URL Tiktok của bạn" value="{{ $tiktok }}">
                                </div>
                                <div class="form-group">
                                    <label>Twitter</label>
                                    <input type="text" class="form-control" name="twitter" placeholder="URL Twitter của bạn" value="{{ $twitter }}">
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4">
                                <div class="form-group">
                                    <label>Mail nhận góp ý</label>
                                    <input type="email" class="form-control" name="mailReceiveFeedback" placeholder="example@gmail.com" value="{{ $mailReceiveFeedback }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('script')
<!-- CK Editor -->
<script src="{{ asset('public/admin/assets/bower_components/ckeditor/ckeditor.js') }}"></script>
<script>
  $(function () {
    $('.textarea').wysihtml5();
    CKEDITOR.replace( 'editor1' );
  });

    // run function
    previewImage('favicon');
    previewImage('logo');

    // preview image
    function previewImage(element) {
        const image_input = document.getElementById(element);
        const image = document.getElementById(element + '-preview');
        image_input.addEventListener('change', (e) => {
            if (e.target.files.length) {
                const src = URL.createObjectURL(e.target.files[0]);
                image.src = src;
            }
        });
    }
</script>
@endsection