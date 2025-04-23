@extends('app.layout')

@section('content')
    <style>
        body {
            background-color: #212121;
            color: #fff;
        }

        #loginForm {
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
            <form id="loginForm" class="p-4 rounded shadow">
                <h2 class="text-center mb-4">Login</h2>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="loginEmail" class="form-control" name="email" placeholder="Enter your email">
                    <small class="text-danger" id="error-email"></small>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="loginPassword" class="form-control" name="password"
                        placeholder="Enter your password">
                    <small class="text-danger" id="error-password"></small>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('auth.forgot') }}" class="text-light">Forgot Password?</a>
                </div>

                <button class="btn btn-primary btn-block" id="loginBtn">Login</button>
                <a href="{{route('auth.signup')}}" class="btn btn-dark btn-block" id="loginBtn">Sign up</a>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $('#loginForm').on('submit', function (e) {
            e.preventDefault();
            $('.text-danger').text('');
            $('#loginBtn').prop('disabled', true).text('Logging in...');

            $.ajax({
                url: '/login',
                method: 'POST',
                data: {
                    email: $('#loginEmail').val(),
                    password: $('#loginPassword').val()
                },
                success: function (res) {
                    console.log(res);
                    Swal.fire('Welcome!', 'You are now logged in.', 'success').then(() => {
                        if (res.user.role == 'admin') {
                            window.location.href = '{{route('niches.index')}}';
                        } else {
                            window.location.href = '{{route('webiste.bots')}}';
                        }
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, val) {
                            $('#error-' + key).text(val[0]);
                        });
                    } else {
                        Swal.fire('Login Failed', 'Incorrect credentials.', 'error');
                    }
                },
                complete: function () {
                    $('#loginBtn').prop('disabled', false).text('Login');
                }
            });
        });
    </script>
@endsection