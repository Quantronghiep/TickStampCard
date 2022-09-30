@extends('admin.layouts.master')
@section('title', 'Thêm mới Stamp')
@section('content')
<h1>Edit stamp id = : {{ $stamp->id }}</h1>
    {{--    action='/application' --}}
    <form method="post" action="{{url('admin/stamp/'.$stamp->id)}}" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="">Max stamp</label>
            <input type="number" class="form-input" name="max_stamp" value="{{ $stamp->max_stamp }}" />
        </div>
    
        <div class="form-group">
            <label class="">Allow tick stamp many in one day : </label>
            <input type="radio" name="allow_many" value="1" {{ ( $stamp->allow_many =="1")? "checked" : "" }} /> Yes
            <input type="radio" name="allow_many" value="0" {{ ( $stamp->allow_many =="0")? "checked" : "" }} /> No
        </div>
        <div class="form-group">
            <label class="">Image before</label>
            <input type="file" class="form-input" name="image_before" value="{{ Request::old('image_before') }}" />
            @if(!empty($stamp->image_before))
            <img height="80" src="{{ asset('images/' . $stamp->image_before) }}"/>
            @endif
            <img src="#" id="img-preview" style="display: none" width="100" height="100" />
        </div>
        <div class="form-group">
            <label class="">Image after</label>
            <input type="file" class="form-input" name="image_after" value="{{ Request::old('image_after') }}" />
            @if(!empty($stamp->image_after))
            <img height="80" src="{{ asset('images/' . $stamp->image_after) }}"/>
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
