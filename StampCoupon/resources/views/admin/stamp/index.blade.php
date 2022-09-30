@extends('admin.layouts.master')
@section('title','Quản lý Stamp')
@section('content')
@include('admin.layouts.content_header')

@if(session('success'))
    <h6 class="alert alert-success">{{session('success')}}</h6>
@endif

<h2>Danh sách stamp</h2>
<a href="{{route('stamp.create')}}" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới Stamp
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Max stamp</th>
        <th>Allow tick stamp many in one day</th>
        <th>Image before</th>
        <th>Image after</th>
        <th>App</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    @if (!empty($stamps))
        @foreach ($stamps as $stamp)
            <tr>
                <td>{{$stamp->id}}</td>
                <td>{{$stamp->max_stamp}}</td>
                <td>
                    {{ $stamp->allow_many == 1 ? "Yes" : "No"}}
                </td>
                <td>
                    @if(!empty($stamp->image_before))
                    <img height="80" src="{{ asset('images/' . $stamp->image_before) }}"/>
                    @endif
                </td>
                <td>
                    @if(!empty($stamp->image_after))
                    <img height="80" src="{{ asset('images/' . $stamp->image_after) }}"/>
                    @endif
                </td>
                <td>{{ $stamp->app_name }}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($stamp->created_at))}}</td>
                <td>{{ !empty($stamp->updated_at) ? date('d-m-Y H:i:s', strtotime($stamp->updated_at)) : '--' }}</td>

                <td>
                    <a href="/stamp/{{ $stamp->id }}">Detail</a>
                    <a href="/admin/stamp/{{ $stamp->id }}/edit">Edit</a>
                    <form action="{{url('admin/stamp/'.$stamp->id)}}" method="post">
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