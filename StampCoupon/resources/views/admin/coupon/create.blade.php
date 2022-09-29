@extends('admin.layouts.master')
@section('title', 'Thêm mới Coupon')
@section('content')
    <h1>Create new coupon</h1>
    {{--    action='/application' --}}
    <form method="post" action="{{ route('coupon.store') }}" enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label class="">Coupon name</label>
            <input type="text" class="form-input" name="name" value="{{ Request::old('name') }}" />
        </div>
        <div class="form-group">
            <label class="">Coupon image</label>
            <input type="file" class="form-input" name="image" value="{{ Request::old('image') }}" />
            <img src="#" id="img-preview" style="display: none" width="100" height="100" />
        </div>
        <div class="form-group">
            <label class="">Description</label>
            <input type="text" class="form-input" name="description" value="{{ Request::old('description') }}" />
        </div>
        <div class="form-group">
            <label class="">Số lượng để nhận coupon</label>
            <input type="number" class="form-input" name="number_accumulation"
                value="{{ Request::old('number_accumulation') }}" />
        </div>
        <div class="form-group">
            <label class="">Note using</label>
            <textarea rows="9" cols="70" name="note_using">{{ Request::old('note_using') }}</textarea>
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
