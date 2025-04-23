@extends('app.layout')

@section('content')
    <style>
        body {
            background-color: #212121;
            color: #fff;
        }
        #signupForm {
            background-color: #171717;
        }
        .form-control {
            background-color: #1e1e1e;
            color: #fff;
            border: 1px solid #444;
        }

        .form-control::placeholder {
            color: #ccc;
        }

        .form-control:focus {
            background-color: #1e1e1e;
            color: #fff;
            border-color: #6c757d;
        }

        .btn {
            color: #fff;
        }
    </style>

    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-4">
            <form id="signupForm" class="p-4 bg-dark rounded shadow">
                <h2 class="text-center mb-4">Sign Up</h2>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Enter your name">
                    <small class="text-danger" id="error-name"></small>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Enter your email">
                    <small class="text-danger" id="error-email"></small>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" class="form-control" name="password"
                        placeholder="Enter your password">
                    <small class="text-danger" id="error-password"></small>
                </div>

                <button class="btn btn-primary btn-block" id="signupBtn">Register</button>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#signupForm').on('submit', function (e) {
            e.preventDefault();
            $('.text-danger').text('');
            $('#signupBtn').prop('disabled', true).text('Registering...');
            console.log({
                name: $('#name').val(),
                email: $('#email').val(),
                password: $('#password').val()
            })
            $.ajax({
                url: '/register',
                method: 'POST',
                data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                success: function (res) {
                    Swal.fire('Success', 'Account created successfully', 'success').then(function () {
                        window.location.href = '{{route('auth.login')}}';
                    });
                    $('#signupForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                },
                complete: function () {
                    $('#signupBtn').prop('disabled', false).text('Register');
                }
            });
        });
    </script>
@endsection