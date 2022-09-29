@extends('admin.layouts.master')
@section('title','Edit Coupon')
@section('content')
<h1>Edit coupon name : {{ $coupon->name }}</h1>
{{--    action='/application'--}}
    <form method="post" action="{{url('admin/coupon/'.$coupon->id)}}" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="">Coupon name</label>
            <input type="text" class="form-input" name="name" value="{{ $coupon->name }}"/>
        </div>
        <div class="form-group">
            <label class="">Coupon image</label>
            <input type="file" class="form-input" name="image" value="{{ Request::old('image') }}"/>
            @if(!empty($coupon->image))
            <img height="80" src="{{ asset('images/' . $coupon->image) }}"/>
            @endif
            <img src="#" id="img-preview" style="display: none" width="100" height="100"/>
        </div>
        <div class="form-group">
            <label class="">Description</label>
            <input type="text" class="form-input" name="description" value="{{ $coupon->description }}"/>
        </div>
        <div class="form-group">
            <label class="">Số lượng để nhận coupon</label>
            <input type="number" class="form-input" name="number_accumulation" value="{{ $coupon->number_accumulation }}"/>
        </div>
        <div class="form-group">
            <label class="">Note using</label>
            <textarea rows="9" cols="70" name="note_using" >{{  $coupon->note_using }}</textarea>
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