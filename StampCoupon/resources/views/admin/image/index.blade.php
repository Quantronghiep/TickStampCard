@extends('admin.layouts.master')
@section('title','Quản lý Image Stamp')
@section('content')
@include('admin.layouts.content_header')

@if(session('success'))
    <h6 class="alert alert-success">{{session('success')}}</h6>
@endif

<h2>Danh sách image</h2>
@if(session('error'))
    <li class="alert alert-danger">{{session('error')}}</li>
@endif
<a href="{{route('image.create')}}" class="btn btn-success">
    <i class="fa fa-plus"></i> Thêm mới Image
</a>

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
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Image before</th>
        <th></th>
        <th>Image after</th>
        <th></th>
        <th>Stamp_id</th>
        <th></th>
    </tr>
    @if (!empty($images))
        @foreach ($images as $image)
        <tbody id="test">
            <tr >
                <td class="image_id">{{ $image->id }}</td>
                <td>
                    @if(!empty($image->image_before))
                    <img height="80" src="{{ asset('images/' . $image->image_before) }}"/>
                    @endif
                </td>
                <td>
                    <input type="file" class="form-input" name="image_before" value="{{ Request::old('image_before') }}" />
                    <img src="#" id="img-preview" style="display: none" width="100" height="100" />
                </td>
                <td>
                    @if(!empty($image->image_after))
                    <img height="80" src="{{ asset('images/' . $image->image_after) }}"/>
                    @endif
                </td>
                <td>
                    <input type="file" class="form-input" name="image_after" value="{{ Request::old('image_after') }}" />
                    <img src="#" id="img-preview" style="display: none" width="100" height="100" />
                </td>
                <td class="stamp_id">{{ $image->stamp_id }}</td>
               
                <td>
                    <a href="/admin/image/{{ $image->id }}/edit">Edit</a>
                    <form action="{{url('admin/image/'.$image->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"  onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')">Delete</button>
                    </form>

                </td>
            </tr>
        </tbody>

        @endforeach

    @endif
</table>

<script>
    $(function () {
    $('#stamp_id').on('change', function(e) { 
        var stamp_id = $(this).val(); //lấy stamp_id
        // alert(stamp_id);
        $.ajax({
            type: 'get', // phương thức gửi
            url: '/admin/get-image/' + stamp_id, //tới route mà chúng ta đã định nghĩa ở trên.
            // data: stamp_id, // gửi đi stamp_id
            dataType: 'json',
        }).done(function(res) { 
            let html = ``;
            let len = res.length;
            // console.log(res)
            for(var i = 0 ; i < len ; i++){
                let url = "{{ asset('images') }}/";
                console.log(url+ res[i].image_before)
                let row = ` 
                <tr id="test">
                <td class="image_id">${res[i].id}</td>
                <td>
                    
                    <img height="80" src="${url + res[i].image_before}"/>
                   
                </td>
                <td>
                    <input type="file" class="form-input" name="image_before" value="{{ Request::old('image_before') }}" />
                    <img src="#" id="img-preview" style="display: none" width="100" height="100" />
                </td>
                <td>
                    
                    <img height="80" src="${url + res[i].image_after}"/>
                  
                </td>
                <td>
                    <input type="file" class="form-input" name="image_after" value="{{ Request::old('image_after') }}" />
                    <img src="#" id="img-preview" style="display: none" width="100" height="100" />
                </td>
                <td class="stamp_id"> ${res[i].stamp_id}</td>
               
                <td>
                    <form action="{{url('admin/image/'.$image->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"  onclick="return confirm('Bạn có chắc chắn muốn xóa bản ghi này')">Delete</button>
                    </form>

                </td>
            </tr>`
            html += row;
            }
            $("#test").html(html);
        });         
    });
});


</script>


@endsection