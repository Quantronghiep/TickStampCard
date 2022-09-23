@extends('admin.layouts.master')
@section('title','Thêm mới Admin')
@section('content')
<h1>Create new admin</h1>
{{--    action='/application'--}}
    <form method="post" action="{{ route('admin.store') }}" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label class="">Email admin</label>
            <input type="email" class="form-input" name="email" value="{{ Request::old('email') }}"/>
        </div>
        <div class="form-group">
            <label class="">Password</label>
            <input type="password" class="form-input" name="password" value="{{ Request::old('password') }}"/>
        </div>
        <div class="form-group">
            <label for="app_id">App quản lý</label>
            <select name="app_id" class="form-control" id="app_id">
                @foreach($apps as $app)
                <option value="{{ $app->id }}" >
                    {{ $app->app_name }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection