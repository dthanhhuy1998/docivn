@if(Auth::user())
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="@if(!empty(Auth::user()->image)) {{ asset('storage/app/' . Auth::user()->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" class="img-circle" alt="Avatar">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->lastname }} {{ Auth::user()->firstname }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Trực tuyến</a>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">BẢNG ĐIỀU KHIỂN</li>
                <li>
                    <a href="{{ route('catalog.homepage') }}" target="_blank">
                        <i class="fa fa-sign-out"></i> <span>Đi đến trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.index') }}">
                        <i class="fa fa-th"></i> <span>Trang chính</span>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-cubes"></i> <span>Sản phẩm</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.product.category.getList') }}"><i class="fa fa-circle-o"></i> Danh mục</a></li>
                        <li><a href="{{ route('admin.product.getList') }}"><i class="fa fa-circle-o"></i> Danh sách sản phẩm</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-newspaper-o"></i> <span>Quản lý bài viết</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.article.category.getList') }}"><i class="fa fa-circle-o"></i> Danh mục</a></li>
                        <li><a href="{{ route('admin.article.getList') }}"><i class="fa fa-circle-o"></i> Danh sách bài viết</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('admin.video.getList') }}">
                        <i class="fa fa-video-camera"></i> <span>Videos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.gallery.index') }}">
                        <i class="fa fa-photo"></i> <span>Album ảnh</span>
                    </a>
                </li>
                <!-- <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>Khách hàng</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.customer.getList') }}"><i class="fa fa-circle-o"></i> Danh sách</a></li>
                    </ul>
                </li> -->
                <!-- <li class="treeview">
                    <a href="#">
                        <i class="fa fa-print"></i> <span>Đơn hàng</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.invoice.getList') }}"><i class="fa fa-circle-o"></i> Danh sách</a></li>
                    </ul> -->
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-street-view"></i> <span>Quản lý Seller</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('admin.seller.getAdd') }}"><i class="fa fa-circle-o"></i> Tạo Seller</a></li>
                        <li><a href="{{ route('admin.seller.getList') }}"><i class="fa fa-circle-o"></i> Danh sách Seller</a></li>
                    </ul>
                </li>
                @if(Auth::user()->user_group_id == 1)
                    <!-- <li>
                        <a href="{{ route('admin.partner.getList') }}"><i class="fa fa-link"></i> <span>Đối tác liên kết</span></a>
                    </li> -->
                    <!--<li>-->
                    <!--    <a href="{{ route('admin.comment.getList') }}"><i class="fa fa-comment"></i> <span>Đóng góp ý kiến</span></a>-->
                    <!--</li>-->
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-paint-brush"></i> <span>Giao diện</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.slide.getList') }}"><i class="fa fa-circle-o"></i> Slide quảng cáo</a></li>
                            <li><a href="{{ route('admin.slide.product.getList') }}"><i class="fa fa-circle-o"></i> Slide sản phẩm</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i> <span>Hệ thống</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('admin.system.config.getUpdate') }}">
                                    <i class="fa fa-circle-o"></i> Thiết lập
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-circle-o"></i> Tài khoản
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    @if(Auth::user()->user_group_id == 1)
                                        <li><a href="{{ route('admin.user.getList') }}"><i class="fa fa-circle-o"></i> Danh sách tài khoản</a></li>
                                    @endif
                                    <li><a href="{{ route('admin.user.getResetPass', [Auth::user()->id]) }}"><i class="fa fa-circle-o"></i> Đổi mật khẩu</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
@endif