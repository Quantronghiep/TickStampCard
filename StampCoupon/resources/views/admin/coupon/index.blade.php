@extends('admin.layouts.master')
@section('title','Quản lý Coupon')
@section('content')
@include('admin.layouts.content_header')

@if(session('success'))
    <h6 class="alert alert-success">{{session('success')}}</h6>
@endif

<h2>Danh sách coupon</h2>
<a href="{{route('coupon.create')}}" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới coupon
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Name coupon</th>
        <th>Image</th>
        <th>Số lượng cần tích</th>
        <th>Description</th>
        <th>Note using</th>
        <th>App</th>
        <th>Created_at</th>
        <th>Updated_at</th>
    </tr>
    @if (!empty($coupons))
        @foreach ($coupons as $coupon)
            <tr>
                <td>{{$coupon->id}}</td>
                <td>{{$coupon->name}}</td>
                <td>
                    @if(!empty($coupon->image))
                    <img height="80" src="{{ asset('images/' . $coupon->image) }}"/>
                    @endif
                </td>
                <td>{{$coupon->number_accumulation}}</td>
                <td>{{$coupon->description}}</td>
                <td>{{ $coupon->note_using }}</td>
                <td>{{ $coupon->app_name }}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($coupon->created_at))}}</td>
                <td>{{ !empty($coupon->updated_at) ? date('d-m-Y H:i:s', strtotime($coupon->updated_at)) : '--' }}</td>

                <td>
                    <a href="/coupon/{{ $coupon->id }}">Detail</a>
                    <a href="/admin/coupon/{{ $coupon->id }}/edit">Edit</a>
                    <form action="{{url('admin/coupon/'.$coupon->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"  onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')">Delete</button>
                    </form>

                </td>
            </tr>
        @endforeach

    @endif
</table>

@endsection