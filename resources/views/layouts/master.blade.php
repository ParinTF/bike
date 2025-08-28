<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "BikeShop | จําหน่ายอะไหล่จักรยานออนไลน์")</title>

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


</head>
<body>
    <h1 class="text-center" style="margin-top: 20px;">ปรินทร สุทธิคุณ 6506021621080</h1>

    <div class="container">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="navbar-header">
                <a class="navbar-brand" href="{{ url('/') }}">BikeShop</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {{-- แนะนำให้ใช้ route() ในอนาคตเพื่อการจัดการที่ง่ายกว่า --}}
                    <li><a href="{{ URL::to('home') }}">หน้าแรก</a></li>
                    <li><a href="{{ url('product') }}">ข้อมูลสินค้า</a></li>
                    <li><a href="{{ url('category') }}">ข้อมูลประเภท</a></li>
                    <li><a href="#">รายงาน</a></li>
                </ul>
            </div>
        </nav>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    @yield('breadcrumb-page', 'หน้าแรก') {{-- ถ้าหน้าลูกไม่ได้กำหนด จะแสดงคำว่า "ภาพรวม" --}}
                </li>
            </ol>
        </nav>

        {{-- ส่วนเนื้อหาหลัก --}}
        @yield("content")
    </div>




    @if(session('msg'))
        @if(session('ok'))
            <script>toastr.success("{{ session('msg') }}")</script>
        @else
            <script>toastr.error("{{ session('msg') }}")</script>
        @endif
    @endif

</body>
</html>