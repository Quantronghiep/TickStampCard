<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Validation Form</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper mx-auto">
        @if (session('error'))
            <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif
        <!-- Main content -->
        <section class="content">
            <!-- left column -->
            <div class="col-md-4 mx-auto" style="margin-top: 100px">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Register</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="quickForm" action="{{ route('check_register_user') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="phone_number">Phone number</label>
                                <input type="text" name="phone_number" class="form-control" id="phone_number"
                                    placeholder="Enter phone number">
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="submit" type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (right) -->
    </div>
    </section>
    <!-- /.content -->
    </div>
    <!-- ./wrapper -->

</body>

<script>
    // this is the id of the form
    $(document).ready(function() {
        let form = $("#quickForm");
        var tokenInput = $("input[name=_token]");
        $("#quickForm").submit(function(e) {
            var actionUrl = form.attr('action');
            var phoneNumber = $("#phone_number").val();
            e.preventDefault(); // avoid to execute the actual submit of the form.
            // e.stopImmediatePropagation();

            try {
                $.ajax({
                    type: "POST",
                    url: actionUrl,
                    data: {
                        _token: tokenInput.val(),
                        phone_number: phoneNumber
                    }, // serializes the form's elements.
                    success: function(data) {
                        localStorage.setItem('phoneNumber', data);
                        let url = "http://127.0.0.1:8000/";
                        window.location.href = `${url}` + "web";
                        // alert('haha');

                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            } catch (error) {
                console.log(error);
            }
        });
    })
</script>

</html>
