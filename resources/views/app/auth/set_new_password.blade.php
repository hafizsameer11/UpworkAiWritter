@extends('app.layout')

@section('content')
    <style>
        body {
            background-color: #212121;
            color: #ffffff;
        }

        .center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .form-container {
            background-color: #171717;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 100%;
            max-width: 400px;
        }

        label {
            color: #ccc;
        }
    </style>

    <div class="center-wrapper">
        <div class="form-container">
            <h2 class="text-center mb-4">Set New Password</h2>
            <form id="newPasswordForm">
                <input type="hidden" id="email" value="{{ request('email') }}">
                <input type="hidden" id="code" value="{{ request('code') }}">

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" id="password" class="form-control" name="password">
                    <small class="text-danger" id="error-password"></small>
                </div>

                <div class="form-group mt-3">
                    <label>Confirm Password</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                </div>

                <button type="submit" class="btn btn-success w-100 mt-4" id="resetBtn">Reset Password</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#newPasswordForm').on('submit', function (e) {
            e.preventDefault();
            $('#error-password').text('');
            $('#resetBtn').prop('disabled', true).text('Resetting...');

            $.ajax({
                url: '/reset-password',
                method: 'POST',
                data: {
                    email: $('#email').val(),
                    code: $('#code').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                },
                success: function (res) {
                    Swal.fire('Done!', 'Your password has been reset.', 'success').then(() => {
                        window.location.href = '/';
                    });
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $('#error-password').text(xhr.responseJSON.message || 'Validation error.');
                    } else {
                        Swal.fire('Error', 'Could not reset password.', 'error');
                    }
                },
                complete: function () {
                    $('#resetBtn').prop('disabled', false).text('Reset Password');
                }
            });
        });
    </script>
@endsection