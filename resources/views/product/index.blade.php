@extends('layouts.master')

@section('title') BikeShop | รายการสินค้า @stop

@section('content')
    <div class="container">

        <h1><i class="fa fa-shopping-cart"></i> รายการสินค้า</h1>

        {{-- ส่วนสำหรับแสดงข้อความแจ้งเตือน (Alert) --}}
        @if (session('ok'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <strong>{{ session('msg') }}</strong>
            </div>
        @endif


        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title"><strong>รายการ</strong></div>
            </div>

            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-8">
                        <form action="{{ URL::to('product/search') }}" method="post" class="form-inline">
                            @csrf

                            <div class="form-group">
                                <input type="text" name="q" class="form-control" placeholder="ค้นหาสินค้า...">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
                        </form>
                    </div>
                    <div class="col-sm-4 text-right">

                        <a href="{{ URL::to('product/edit') }}" class="btn btn-success">
                            <i class="fa fa-plus"></i> เพิ่มสินค้า
                        </a>
                    </div>
                </div>
            </div>


            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">รูปสินค้า</th>
                        <th>รหัส</th>
                        <th>ชื่อสินค้า</th>
                        <th>ประเภท</th>

                        <th class="text-right">คงเหลือ</th>
                        <th class="text-right">ราคาต่อหน่วย</th>
                        <th class="text-center">การทำงาน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                        <tr>

                            <td class="text-center"><img src="{{ $p->image_url }}" class="img-thumbnail"
                                    style="width: 60px;"></td>
                            <td>{{ $p->code }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->category->name }}</td>

                            <td class="text-right">{{ number_format($p->stock_qty, 0) }}</td>
                            <td class="text-right">{{ number_format($p->price, 2) }}</td>

                            <td class="text-center">
                                <a href="{{ URL::to('product/edit/' . $p->id) }}" class="btn btn-info btn-xs"><i
                                        class="fa fa-edit"></i> แก้ไข</a>
                                {{-- ส่วนของการลบข้อมูล --}}
                                <a href="#" class="btn btn-danger btn-xs btn-delete"
                                    id-delete="{{ $p->id }}"><i class="fa fa-trash"></i> ลบ</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>

                        <th colspan="4" class="text-right">รวม</th>
                        <th class="text-right">{{ number_format($products->sum('stock_qty'), 0) }}</th>
                        <th class="text-right">{{ number_format($products->sum('price'), 2) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>


            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-6">
                        <span>แสดงข้อมูลจำนวน {{ count($products) }} รายการ</span>
                    </div>
                    <div class="col-sm-6 text-right">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- แก้ไขโดยการครอบด้วย $(document).ready() --}}
    <script>
        $(document).ready(function() {
            // ใช้ jQuery เพื่อ handle event click ของปุ่มลบ
            $('.btn-delete').on('click', function(e) {
                e.preventDefault(); // ป้องกันไม่ให้ลิงก์ทำงานตามปกติ (วิ่งไปที่ #)
                
                // ดึงค่า id จาก attribute 'id-delete'
                var id = $(this).attr('id-delete');
                
                // แสดง dialog ยืนยันการลบ
                if (confirm("คุณต้องการลบข้อมูลสินค้าหรือไม่?")) {
                    // สร้าง URL สำหรับการลบ
                    var url = "{{ URL::to('product/remove') }}" + '/' + id;
                    // สั่งให้ browser วิ่งไปยัง URL ที่สร้างขึ้น
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
