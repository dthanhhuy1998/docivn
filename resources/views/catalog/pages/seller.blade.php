<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    body {
      background: #fbc2eb;
      /* Chrome 10-25, Safari 5.1-6 */
      background: -webkit-linear-gradient(to top left, #83501A 8%, #FFFEA8 77%);
      /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      background: linear-gradient(to top left, #83501A 8%, #FFFEA8 77%);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
  
  .card-img-top{
      height:380px;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
  }
  
  .card-no-border .card {
      border-color: #d7dfe3;
      border-radius: 4px;
      margin-bottom: 30px;
      -webkit-box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
      box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05)
  }
  
  .card-body {
      -ms-flex: 1 1 auto;
      flex: 1 1 auto;
      padding: 1.25rem
  }
  
  .pro-img {
      margin-top: -80px;
      margin-bottom: 20px
  }
  
  .little-profile .pro-img img {
      width: 150px;
      height: 150px;
      -webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
      border-radius: 100%
  }
  
  html body .m-b-0 {
      margin-bottom: 0px
  }
  
  h3 {
      line-height: 30px;
      font-size: 21px
  }
  
  .btn-rounded.btn-md {
      padding: 12px 35px;
      font-size: 16px
  }
  
  html body .m-t-10 {
      margin-top: 10px
  }
  
  .btn-primary,
  .btn-primary.disabled {
      background: #7460ee;
      border: 1px solid #7460ee;
      -webkit-box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
      box-shadow: 0 2px 2px 0 rgba(116, 96, 238, 0.14), 0 3px 1px -2px rgba(116, 96, 238, 0.2), 0 1px 5px 0 rgba(116, 96, 238, 0.12);
      -webkit-transition: 0.2s ease-in;
      -o-transition: 0.2s ease-in;
      transition: 0.2s ease-in
  }
  
  .btn-rounded {
      border-radius: 60px;
      padding: 7px 18px
  }
  
  .m-t-20 {
      margin-top: 20px
  }
  
  .text-center {
      text-align: center !important
  }
  
  h1,
  h2,
  h3,
  h4,
  h5,
  h6 {
      color: #455a64;
      font-family: "Poppins", sans-serif;
      font-weight: 400
  }
  
  p {
      margin-top: 0;
      margin-bottom: 1rem
  }
  
  .card {
    width: 700px !important;
    border-radius: 12px;
  }
  
</style>
<body cz-shortcut-listen="true">
    <div class="card">
        <img class="card-img-top" src="@if(!empty($seller->Banner)) {{ asset('storage/app/'.$seller->Banner) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="Card image cap">
        <div class="card-body little-profile text-center">
            <div class="pro-img">
                <img src="@if(!empty($seller->AnhDaiDien)) {{ asset('storage/app/'.$seller->AnhDaiDien) }} @else {{ asset('storage/app/uploads/default.png') }} @endif" alt="user">
            </div>
            <h3 class="m-b-0">{{ $seller->TenSeller }}</h3>
            <p>{{ $seller->CapBac }}</p> 
            <p>Số điện thoại: {{ $seller->SoDienThoai }}</p>
            <p>Khu vực: {{ $seller->KhuVuc }}</p> 
            <a @if(!empty($seller->LinkFacebook)) href="{{ $seller->LinkFacebook }}" target="_blank" @else href="#" onclick="return false;"  @endif class="btn btn-primary" style="background-color: blue;">Facebook</a>
        </div>
    </div>
</body>
</html>