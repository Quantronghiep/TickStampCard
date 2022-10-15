@extends('web.layouts')
@section('content')


    <div id="popup"></div>

    <div class="mt-10 mx-auto">
        <div id="notice"></div>

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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        var phoneNumber = localStorage.getItem('phoneNumber');

        if (!phoneNumber) {
            window.location.href = "{{ route('register_user') }}";
        } else {
            try {

                $.ajax({
                    type: "GET",
                    url: "{{ route('tickStampNext') }}",
                    data: {
                        phone_number: phoneNumber,
                    }, // serializes the form's elements.
                    success: function(data) {
                        console.log(data)
        
                        let html = ``;
                        let popup = ``;
                        let url = "{{ asset('images') }}/";
                        for (var i = 0; i < data.max_stamp; i++) {
                            if (i < data.amount_stamp) {
                                html += ` <img class="w-10 h-10 rounded-full border-2 gap-x-2"
                            src="${url + data.imageStamp[i].image_after}" alt="">`;
                            } else {
                                html += ` <img class="w-10 h-10 rounded-full border-2 gap-x-2"
                            src="${url + data.imageStamp[i].image_before}" alt="">`;
                            }
                        }
                        if (data.amount_stamp % data.number_accumulation == 0) {
                            popup += `<div class="modal">
        <div class="overlay"></div>
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <span class="close-btn">x</span>
                <h2 class="modal-content__heading">Chuc mung ban da trung thuong</h2>
            <div class="modal-content-body">
                <div class="modal-content__img">
                    <img src="${url + data.couponByAppId.image}" alt="img popup" />
                </div>
                <p>${data.couponByAppId.name}</p>
            </div>
            <div class="modal-button">
                <a class="btn btn-warning" href="/web/coupon-detail/${data.couponByAppId.id}">Detail</a>
            </div>
            </div>
        </div>
    </div>`
                        }
                        $("#notice").html(`    <h6 class="alert alert-success">${ data.success }</h6>`);
                        $("#result").html(html);
                        $("#popup").html(popup);
                    },
                    error: function(err) {
                        alert(err['responseJSON']['message']);
                    },
                });
                // loaded = true;
            } catch (error) {
                alert(err['responseJSON']['message']);

            }
        }
    </script>


@endsection
