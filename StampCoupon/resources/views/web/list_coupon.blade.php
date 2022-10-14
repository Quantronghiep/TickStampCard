@extends('web.layouts')
@section('content')
    <div class="text-xl text-center">List Coupon</div>
    <div class="border-2 bg-black my-2"></div>
    @if (!empty($listCouponReceive))
        @foreach ($listCouponReceive as $coupon)
            <div class="mt-4">
                <div class="flex border-2 border-pink-300 ">
                    <a href="{{ route('web.detail') }}">
                        <img class="w-20 h-20 border-r-2 border-pink-300" src="{{ asset('images/' . $coupon->image) }}"
                            alt="">
                    </a>
                    <div>
                        <div class="text-base text-center">{{ $coupon->name }}</div>
                    </div>
                    @if ($coupon->status == 0)
                        <button class="mt-5 my-4 ml-24 bg-pink-500 text-white rounded-lg useCoupon"
                            data-value="{{ $coupon->id }}" id="coupon-{{ $coupon->id }}">Use Coupon
                        </button>
                        <button class="mt-5 my-4 ml-24 bg-black text-white rounded-lg hidden" id="usedCoupon-{{ $coupon->id }}">Coupon da su dung
                        </button>
                    @else
                        <button class="mt-5 my-4 ml-24 bg-black text-white rounded-lg" id="usedCoupon-{{ $coupon->id }}">Coupon da su dung
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $(".useCoupon").click(function(e) {

                let id = $(this).data("value");

                try {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "PUT",
                        url: " {{ route('updateStatusUseCoupon') }}",
                        data: {
                            'user_coupon_id': id
                        },
                        success: function(data) {
                            alert(data);
                            $(`#coupon-${id}`).hide();
                            $(`#usedCoupon-${id}`).removeClass('hidden');
                        }
                    })
                } catch (error) {
                    console.log(error);

                }
            });
        })
    </script>
@endsection
