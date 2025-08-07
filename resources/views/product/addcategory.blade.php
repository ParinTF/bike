@extends('layouts.master') @section('title') BikeShop | แก้ไขข้อมูลสินค้า @stop
@section('breadcrumb-page', 'เพิ่มประเภทสินค้า') {{-- กำหนดชื่อ breadcrumb สำหรับหน้าเพิ่มประเภทสินค้า --}}
@section('content')
    <h1>เพิ่มสินค้า </h1>
    <ul class="breadcrumb">
        <li><a href="{{ URL::to('category') }}">หน้าแรก</a></li>
        <li class="active">เพิ่มสินค้า </li>
    </ul>
    {!! Form::open([
        'action' => 'App\Http\Controllers\CategoryController@insert',
        'method' => 'post',
        'enctype' => 'multipart/form-data',
    ]) !!}
    <table>

        <tr>
            <td>{{ Form::label('name', 'ชื่อประเภทสินค้า ') }}</td>
            <td>{{ Form::text('name', Request::old('code'), ['class' => 'form-control']) }}</td>
        </tr>



    </table>
    <div class="panel-footer">
        <button type="reset" class="btn btn-danger">ยกเลิก</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> บันทึก</button>
    </div>
    {!! Form::close() !!}
@endsection
