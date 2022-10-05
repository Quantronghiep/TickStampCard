@extends('admin.layouts.master')
@section('title', 'Thêm mới Image')
@section('content')
<h1>Edit image stamp id =  {{ $image->id }} & stamp_id = {{$image->stamp_id}}</h1>
    {{--    action='/application' --}}
    <form method="post" action="{{url('admin/image/'.$image->id)}}" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="">Image before</label>
            <input type="file" class="form-input" name="image_before" value="{{ Request::old('image_before') }}" />
            @if(!empty($image->image_before))
            <img height="80" src="{{ asset('images/' . $image->image_before) }}"/>
            @endif
            <img src="#" id="img-preview" style="display: none" width="100" height="100" />
        </div>
        <div class="form-group">
            <label class="">Image after</label>
            <input type="file" class="form-input" name="image_after" value="{{ Request::old('image_after') }}" />
            @if(!empty($image->image_after))
            <img height="80" src="{{ asset('images/' . $image->image_after) }}"/>
            @endif
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
