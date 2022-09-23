@extends('admin.layouts.master')
@section('title','Quản lý Admin')
@section('content')
@include('admin.layouts.content_header')

@if(session('success'))
    <h6 class="alert alert-success">{{session('success')}}</h6>
@endif

<form method="GET" action="">
    <div class="form-group">
        <label for="username">Email admin</label>
        <input type="text" name="name" id="username"
               value="<?php echo isset($_GET['name']) ? $_GET['name'] : '' ?>" class="form-control"/>
        <input type="hidden" name="controller" value="user"/>
        <input type="hidden" name="action" value="index"/>
    </div>
    <div class="form-group">
        <input type="submit" value="Tìm kiếm" name="search" class="btn btn-primary"/>
        <a href="index.php?controller=user" class="btn btn-default">Back</a>
    </div>
</form>

<h2>Danh sách admin</h2>
<a href="{{route('admin.create')}}" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới
</a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Email admin</th>
        <th>Password</th>
        <th>App quản lý</th>
        <th>Created_at</th>
        <th>Updated_at</th>
    </tr>
    @if (!empty($admins))
        @foreach ($admins as $admin)
            <tr>
                <td>{{$admin->id}}</td>
                <td>{{$admin->email}}</td>
                <td>{{ $admin->password }}</td>
                <td>{{$admin->app_name}}</td>
                <td>{{ date('d-m-Y H:i:s', strtotime($admin->created_at))}}</td>
                <td>{{ !empty($admin->updated_at) ? date('d-m-Y H:i:s', strtotime($admin->updated_at)) : '--' }}</td>

                <td>
                    <a href="/admin/{{ $admin->id }}">Detail</a>
                    <a href="/admin/admin/{{ $admin->id }}/edit">Edit</a>
                    <form action="{{url('admin/admin/'.$admin->id)}}" method="post">
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