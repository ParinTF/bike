@extends('layouts.master')
@section('title') BikeShop | รายการสินค้า @stop
@section('breadcrumb-page', 'ประเภทสินค้า') {{-- กำหนดชื่อ breadcrumb สำหรับหน้าแสดงรายการสินค้า --}}
@section('content')
    <div class="container">
        <h1>รายการสินค้า </h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title"><strong>รายการ</strong></div>
            </div>
            <div class="panel-body">
                <!-- search form -->
                <form action="{{ URL::to('category/search') }}" method="post" class="form-inline">
                    {{ csrf_field() }}
                    <input type="text" name="q" class="form-control" placeholder="...">
                    <button type="submit" class="btn btn-primary">ค้นหา</button>
                    <a href="{{ URL::to('category/edit') }}" class="btn btn-success pull-right">เพิ่มสินค้า
                    </a>
                </form>

            </div>

            <table class="table table-bordered bs_table">
                <thead>
                    <tr>
                        <th>รหัสประเภท</th>
                        <th>ประเภท</th>

                        <th>การทํางาน</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($category as $p)
                        <tr>

                            <td>{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>

                            <td class="bs_center">
                                <a href="{{ URL::to('category/edit/' . $p->id) }}" class="btn btn-info"><i
                                        class="fa fa-edit"></i> แก้ไข</a>
                                <a href="{{ URL::to('category/remove/' . $p->id) }}" class="btn btn-danger btn-delete"
                                    id-delete="{{ $p->id }}">
                                    <i class="fa fa-trash"></i> ลบ</a>
                            </td>


                        </tr>
                    @endforeach

                </tbody>

            </table>
            </table>
            <div class="panel-footer">
                {{ $category->links() }}
                <span>แสดงข้อมูลจํานวน {{ count($category) }} รายการ</span>
            </div>
        </div>
    @endsection

    <script>
        // ใช้เทคนิค jQuery
        $('.btn-delete').on('click', function() {
            if (confirm("คุณต้องการลบข้อมูลสินค้าหรือไม่?")) {
                var url = "{{ URL::to('category/remove') }}" +
                    '/' + $(this).attr('id-delete');
                window.location.href = url;
            }
        });
    </script>
