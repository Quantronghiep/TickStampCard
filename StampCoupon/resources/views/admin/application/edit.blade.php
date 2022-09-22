@extends('admin.layouts.master')
@section('title','Edit Application')
@section('content')

<h1>Edit app name : {{ $app->app_name }}</h1>
<form method="post" action="{{url('admin/application/'.$app->id)}}" enctype="multipart/form-data">

    @csrf
    @method('PUT')
    <div class="form-group">
        <label class="">Application name</label>
        <input type="text" class="form-input" name="app_name" value="{{ $app->app_name }}"/>
    </div>
    <div class="form-group">
        <label class="">Application image</label>
        <input type="file" class="form-input" name="logo" value="{{ Request::old('logo') }}"/>
        @if(!empty($app->logo))
        <img height="80" src="{{ asset('images/' . $app->logo) }}"/>
        @endif
        <img src="#" id="img-preview" style="display: none" width="100" height="100"/>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@endsection