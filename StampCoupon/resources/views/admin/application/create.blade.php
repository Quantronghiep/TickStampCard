@extends('admin.layouts.master')
@section('title','Thêm mới Application')
@section('content')
<h1>Create new application</h1>
{{--    action='/application'--}}
    <form method="post" action="{{ route('application.store') }}" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label class="">Application name</label>
            <input type="text" class="form-input" name="app_name" value="{{ Request::old('app_name') }}"/>
        </div>
        <div class="form-group">
            <label class="">Application image</label>
            <input type="file" class="form-input" name="logo" value="{{ Request::old('logo') }}"/>
            <img src="#" id="img-preview" style="display: none" width="100" height="100"/>
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