@extends('admin.layouts.master')
@section('title', 'Thêm mới Image')
@section('content')
    <h1>Create new image</h1>
    {{--    action='/application' --}}
    <form method="post" action="{{ route('image.store') }}" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label for="app_id">Stamp id</label>
            <select name="stamp_id" class="form-control" id="stamp_id">
                @if (!empty($stamps))

                    @foreach ($stamps as $stamp)
                        <option value="{{ $stamp->id }}">
                            {{ $stamp->id}}
                        </option>
                    @endforeach
                @endif
            </select>
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
