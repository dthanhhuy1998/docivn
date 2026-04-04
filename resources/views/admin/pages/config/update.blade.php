@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $pageTitle }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-th"></i> {{__('Dashboard')}}</a></li>
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
                    <h4><i class="icon fa fa-exclamation"></i> {{__('Warning')}}</h4>
                    {{ session('warning_msg') }}
                </div>
                @endif
            </div>
            <div class="col-md-12">
                <form action="{{ route('admin.system.config.postUpdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save Config')}}</button>
                    </div>
                    @if(session('success_msg'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" control-id="ControlID-6">×</button>
                            <h4><i class="icon fa fa-check"></i> {{__('Success')}}</h4>
                            {{ session('success_msg') }}
                        </div>
                    @endif
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">{{__('General')}}</a></li>
                            <li><a href="#tab_2" data-toggle="tab">{{__('Interface')}}</a></li>
                            <li><a href="#tab_3" data-toggle="tab">{{__('Social')}}</a></li>
                            <li><a href="#tab_4" data-toggle="tab">{{__('Other')}}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="form-group">
                                    <label>{{__('Title')}}</label>
                                    <input type="text" class="form-control" name="meta_title" placeholder="{{__('Enter :field', ['field' => __('Title')])}}" value="{{$configData['meta_title'] ?? ''}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Favicon')}}</label>
                                    <div class="preview-image">
                                        <img src="{{ isset($configData['favicon']) ? asset('public/storage/'.$configData['favicon']) : asset('public/images/no-image.png') }}" alt="Image" id="favicon-preview">
                                    </div>
                                    <input type="file" class="form-control" name="favicon" id="favicon">
                                </div>
                                
                                <div class="form-group">
                                    <label>{{__('Logo')}}</label>
                                    <div class="preview-image">
                                        <img src="{{ isset($configData['logo']) ? asset('public/storage/'.$configData['logo']) : asset('public/images/no-image.png') }}" alt="Image" id="logo-preview">
                                    </div>
                                    <input type="file" class="form-control" name="logo" id="logo">
                                </div>

                                <div class="form-group">
                                    <label>{{__('Logo Footer')}}</label>
                                    <div class="preview-image">
                                        <img src="{{ isset($configData['logo_footer']) ? asset('public/storage/'.$configData['logo_footer']) : asset('public/images/no-image.png') }}" alt="Image" id="logo-preview">
                                    </div>
                                    <input type="file" class="form-control" name="logo_footer" id="logo">
                                </div>

                                <div class="form-group">
                                    <label>{{__('Logo Tageline')}}</label>
                                    <div class="preview-image">
                                        <img src="{{ isset($configData['logo_tagline']) ? asset('public/storage/'.$configData['logo_tagline']) : asset('public/images/no-image.png') }}" alt="Image" id="logo-preview">
                                    </div>
                                    <input type="file" class="form-control" name="logo_tagline" id="logo">
                                </div>

                                <div class="form-group">
                                    <label>{{__('Description')}}</label>
                                    <textarea name="description" class="form-control textarea">{{ $configData['description'] ?? ''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Keyword')}}</label>
                                    <input type="text" class="form-control" name="keyword" placeholder="{{__('Enter :field', ['field' => __('Keyword')])}}" value="{{ $configData['keyword'] ?? ''}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Footer Content')}}</label>
                                    <textarea name="footer_content" class="form-control" id="editor1">{{$configData['footer_content'] ?? ''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Number Phone')}}</label>
                                    <input type="text" class="form-control" name="phone" placeholder="{{__('Enter :field', ['field' => __('Phone')])}}" value="{{ $configData['phone'] ?? ''}}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Copyright')}}</label>
                                    <input type="text" class="form-control" name="copyright" placeholder="{{__('Enter :field', ['field' => __('Copyright')])}}" value="{{ $configData['copyright'] ?? ''}}">
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="form-group">
                                    <p>{{__('All the code below will be installed at the bottom of the tag')}} <span class="label label-primary">&lt;header&gt;</span></p>
                                    <textarea name="code_header" class="form-control" rows="8" placeholder="{{__('Paste the <script> here')}}">{{ $configData['code_header'] ?? ''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <p>{{__('All the code below will be installed at the bottom of the tag')}} <span class="label label-primary">&lt;body&gt;</span></p>
                                    <textarea name="code_footer" class="form-control" rows="8" placeholder="{{__('Paste the <script> here')}}">{{ $configData['code_footer'] ?? ''}}</textarea>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="form-group">
                                    <label>{{__('Gmail')}}</label>
                                    <input type="text" class="form-control" name="gmail" placeholder="{{__('Enter :field', ['field' => __('Gmail')])}}" value="{{ $configData['gmail'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Facebook')}}</label>
                                    <input type="text" class="form-control" name="facebook" placeholder="{{__('Enter :field', ['field' => __('Facebook')])}}" value="{{ $configData['facebook'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Youtube')}}</label>
                                    <input type="text" class="form-control" name="youtube" placeholder="{{__('Enter :field', ['field' => __('Youtube')])}}" value="{{ $configData['youtube'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Zalo')}}</label>
                                    <input type="text" class="form-control" name="zalo" placeholder="{{__('Enter :field', ['field' => __('Zalo')])}}" value="{{ $configData['zalo'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Instagram')}}</label>
                                    <input type="text" class="form-control" name="instagram" placeholder="{{__('Enter :field', ['field' => __('Instagram')])}}" value="{{ $configData['instagram'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Tiktok')}}</label>
                                    <input type="text" class="form-control" name="tiktok" placeholder="{{__('Enter :field', ['field' => __('Tiktok')])}}" value="{{ $configData['tiktok'] ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>{{__('Twitter')}}</label>
                                    <input type="text" class="form-control" name="twitter" placeholder="{{__('Enter :field', ['field' => __('Twitter')])}}" value="{{ $configData['twitter'] ?? '' }}">
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4">
                                <div class="form-group">
                                    <label>{{__('Mail Receiver Feedback')}}</label>
                                    <input type="email" class="form-control" name="mail_receive_feedback" placeholder="{{__('Enter :field', ['field' => __('Mail Receiver Feedback')])}}" value="{{ $configData['mail_receive_feedback'] ?? '' }}">
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