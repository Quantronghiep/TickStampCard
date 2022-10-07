@extends('admin.layouts.master')
@section('title', 'Import Store')
@section('content')
    @include('admin.layouts.content_header')

    <h1 class="fs-5 fw-bold text-center">Import & Export CSV Store</h1>
    @if (session('success'))
        <h6 class="alert alert-success">{{ session('success') }}</h6>
    @endif
    <div class="row">
        <div class="d-flex my-2">
            <a href="" class="btn btn-primary me-1">Export Data</a>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Import Data
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">QR Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $key => $item)
                    <tr>
                        <th scope="row">{{ ++$key }}</th>
                        <td >{{ $item->name_store }}</td>
                        <td>{{ $item->address }}</td>
                        {{-- <td>{!! QrCode::size(100)->generate(env('APP_URL') . '/'. 'name_store='.$item->name_store.'&app_id='.Session::get('app_id')) !!}</td> --}}
                        <td>
                            <a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                            ->size(100)->errorCorrection('H')
                            ->generate(env('APP_URL') . '/'.'tick-card/'.'app_id='.Session::get('app_id'). '&name_store='.$item->name_store)) !!} "  download="qrcode.png">
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                    ->size(100)->errorCorrection('H')
                                    ->generate(env('APP_URL') . '/'.'tick-card/app_id/'.Session::get('app_id'). '/' . 'name_store/'.$item->name_store)) !!} ">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('store.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endsection
