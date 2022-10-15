@extends('web.layouts')
@section('content')
    <div class="bg-rose-300 mt-10">
        <div class="flex">
            <img class="w-20 h-20 border-2" src="{{ asset('images/' . $coupon->image) }}" alt="">
            <div class="text-base text-center">{{ $coupon->name }}</div>
        </div>
        <div class="my-3 mx-5 bg-white ">
            {{ $coupon->description }}
        </div>
        <div class="flex mt-5">
            <div class="">Note using: {{ $coupon->note_using }}</div>
        </div>
        <button class="mt-5 w-56 mx-20  bg-pink-500 text-white rounded-lg" id="useCoupon">Use Coupon </button>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $("#useCoupon").click(function(e) {
                try {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "PUT",
                        url:" {{ route('updateStatus') }}",
                        success: function(data) {
                            alert(data);
                        }
                    })
                }catch (error) {
                console.log(error);

            }
            });
        })
    </script>
@endsection
