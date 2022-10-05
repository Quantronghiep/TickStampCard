@extends('web.layouts')
@section('content')

<div class="mt-10 mx-auto">


    <div class="grid grid-cols-5 gap-4">
        @for($i=1 ; $i<=20 ; $i++)
        <img class="w-10 h-10 rounded-full border-2 gap-x-2" src="{{asset('images/number.png')}}" alt="">
        @endfor
        
      </div>
   
    
</div>

@endsection