@extends('admin.common.layout')

@section('title')
    {!! $headingTitle !!}
@endsection

@section('content')
   <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ $titlePage }}</h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.index') }}"><i class="fa fa-home"></i> Trang chính</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ number_format($productTotal) }}</h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cubes"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ number_format($articleTotal) }}</h3>
                        <p>Bài viết</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ number_format($online) }}</h3>
                        <p>Đang truy cập</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-line-chart"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ number_format($accessTotal) }}</h3>
                        <p>Tổng truy cập</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <section class="col-md-12">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-bar-chart"></i> Thống kê truy cập</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="myChart" height="90"></canvas>
                    </div>
                </div>
            </section>
            <section class="col-md-7">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-cubes"></i> Sản phẩm quan tâm nhiều nhất</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="product_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Lượt xem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($pFavorites as $product)
                                    @php $count++; @endphp
                                    <tr>
                                        <td class="text-right" width="3%">{{ $count }}</td>
                                        <td width="10%" align="center">
                                            <div class="preview-image" style="width: 60px; height: 60px;">
                                                <img src="@if(!empty($product->image)) {{ asset('storage/app/' . $product->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                            </div>
                                        </td>
                                        <td>{{ $product->productDescription->name }}</td>
                                        <td with="10%" align="center">{{ $product->viewed }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
            <section class="col-md-5">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Bài viết xem nhiều</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="post_table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="3%">#</th>
                                    <th>Ảnh</th>
                                    <th>Bài viết</th>
                                    <th width="10%">Lượt xem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count = 0; @endphp
                                @foreach($aFavorites as $post)
                                    @php $count++; @endphp
                                    <tr>
                                        <td class="text-right" width="3%">{{ $count }}</td>
                                        <td width="10%" align="center">
                                            <div class="preview-image" style="width: 60px; height: 60px;">
                                                <img src="@if(!empty($post->image)) {{ asset('storage/app/' . $post->image) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Image">
                                            </div>
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td width="10%" align="center">{{ $post->view }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </section>
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

<script>
  $(function () {
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: JSON.parse('{!! $visitsLabelJSON !!}'),
            datasets: [{
                label: 'Truy cập 15 ngày vừa qua',
                data: JSON.parse('{{ $countVisitedJSON }}'),
                backgroundColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
  });
  
$('#product_table').DataTable();
$('#post_table').DataTable();
</script>
@endsection