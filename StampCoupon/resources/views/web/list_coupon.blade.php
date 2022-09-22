@extends('web.layouts')
@section('content')
    <div class="text-xl text-center">List Coupon</div>
    <div class="border-2 bg-black my-2"></div>
    <a href="{{route('web.detail')}}" class="flex border-2 border-pink-300">
        <img class="w-20 h-20 border-r-2 border-pink-300" src="{{asset('images/gift.png')}}" alt="">
        <div>
            <div class="text-base text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Modi alias corporis labore quae?</div>
            
        </div>

    </a>
@endsection