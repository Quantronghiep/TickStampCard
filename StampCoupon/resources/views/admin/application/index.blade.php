@extends('admin.layouts.master')
@section('title','Quản lý Application')
@section('content')

@include('admin.layouts.content_header')

@if(session('success'))
    <h6 class="alert alert-success">{{session('success')}}</h6>
@endif

<!--form search-->
<form action="" method="GET">
    <div class="form-group">
        <label for="title">Nhập tên app</label>
        <input type="text" name="name" value="" id="title"
               class="form-control"/>
    </div>
    <input type="hidden" name="controller" value="product"/>
    <input type="hidden" name="action" value="index"/>
    <input type="submit" name="search" value="Tìm kiếm" class="btn btn-primary"/>
    <a href="index.php?controller=product" class="btn btn-default">Xóa filter</a>
</form>


<h2>Danh sách application</h2>
    <a href="{{route('application.create')}}" class="btn btn-success">
        <i class="fa fa-plus"></i> Thêm mới
    </a>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Application name</th>
        <th>Logo</th>
        <th>Created_at</th>
        <th>Updated_at</th>
        <th></th>
    </tr>
    @foreach ($apps as $app)
            <tr>    
                <td>{{$app->id}}</td>
                <td>{{$app->app_name}}</td>
                <td>
                    @if(!empty($app->logo))
                    <img height="80" src="{{ asset('images/' . $app->logo) }}"/>
                    @endif
                </td>
                <td>{{ date('d-m-Y H:i:s', strtotime($app->created_at)) }}</td>
                <td>{{  !empty($app->updated_at) ? date('d-m-Y H:i:s', strtotime($app->updated_at)) : '--' }}</td>
                <td>
                    <a href="/application/{{ $app->id }}">Detail</a>
                    <a href="/admin/application/{{ $app->id }}/edit">Edit</a>
                    <form action="{{url('admin/application/'.$app->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"  onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')">Delete</button>
                    </form>

                </td>
            </tr>
        @endforeach

</table>
@endsection