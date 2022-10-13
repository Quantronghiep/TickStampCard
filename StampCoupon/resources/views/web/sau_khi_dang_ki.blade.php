@extends('web.layouts')
@section('content')


    <div class="mt-10 mx-auto">
        <div class="notice"></div>

        <div class="grid grid-cols-5 gap-4" id="result">
            @if (!empty($max_stamp) && !empty($imageStamp))
                @for ($i = 0; $i < $max_stamp; $i++)
                    @if (!empty($amount_stamp) && $i < $amount_stamp)
                        <img class="w-10 h-10 rounded-full border-2 gap-x-2"
                            src="{{ asset('images/' . $imageStamp[$i]->image_after) }}" alt="">
                    @else
                        <img class="w-10 h-10 rounded-full border-2 gap-x-2"
                            src="{{ asset('images/' . $imageStamp[$i]->image_before) }}" alt="">
                    @endif
                @endfor
            @endif

        </div>
    </div>

@endsection
