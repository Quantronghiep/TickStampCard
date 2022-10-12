@extends('web.layouts')
@section('content')

    <div class="mt-10 mx-auto">


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

                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]'.attr('content'))
                //     }
                // });
                // var loaded = false;
                // jQuery("#loader").show();
                // if (loaded) return;

                $.ajax({
                    type: "GET",
                    url: "{{ route('tickStampNext') }}",
                    data: {
                        phone_number: phoneNumber,
                    }, // serializes the form's elements.
                    success: function(data) {
                        console.log()
                        let html = ``;
                        let url = "{{ asset('images') }}/";
                        for(var i = 0 ; i < data.max_stamp ; i++){
                            if(i < data.amount_stamp){
                                html += ` <img class="w-10 h-10 rounded-full border-2 gap-x-2"
                            src="${url + data.imageStamp[i].image_after}" alt="">`;
                            }
                            else{
                                html += ` <img class="w-10 h-10 rounded-full border-2 gap-x-2"
                            src="${url + data.imageStamp[i].image_before}" alt="">`;
                            }
                        }
                        $("#result").html(html);
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
