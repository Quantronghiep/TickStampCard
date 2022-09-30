@extends('admin.layouts.master')
@section('title', 'Thêm mới Stamp')
@section('content')
    <h1>Create new stamp</h1>
    {{--    action='/application' --}}
    <form method="post" action="{{ route('stamp.store') }}" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label class="">Max stamp</label>
            <input type="number" class="form-input" name="max_stamp" value="{{ Request::old('max_stamp') }}" />
        </div>
    
        <div class="form-group">
            <label class="">Allow tick stamp many in one day : </label>
            <input type="radio" name="allow_many" value="1" {{ (Request::old('allow_many')=="1")? "checked" : "" }} /> Yes
            <input type="radio" name="allow_many" value="0" {{ (Request::old('allow_many')=="0")? "checked" : "" }} /> No
        </div>
        <div class="form-group">
            <label class="">Image before</label>
            <input type="file" class="form-input" name="image_before" value="{{ Request::old('image_before') }}" />
            <img src="#" id="img-preview" style="display: none" width="100" height="100" />
        </div>
        <div class="form-group">
            <label class="">Image after</label>
            <input type="file" class="form-input" name="image_after" value="{{ Request::old('image_after') }}" />
            <img src="#" id="img-preview" style="display: none" width="100" height="100" />
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
    @if (Session::has('error'))
        <li class="alert alert-danger">{{ Session::get('error') }}</li>
    @endif
    @if(session('error'))
    <li class="alert alert-danger">{{session('error')}}</li>
@endif
@endsection
