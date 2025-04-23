@extends('app.layout')

@section('content')
    <div class="container mt-5">
        <h2>Set New Password</h2>
        <form id="newPasswordForm">
            <input type="hidden" id="email" value="{{ request('email') }}">
            <input type="hidden" id="code" value="{{ request('code') }}">

            <div class="form-group">
                <label>New Password</label>
                <input type="password" id="password" class="form-control" name="password">
                <small class="text-danger" id="error-password"></small>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
            </div>

            <button class="btn btn-success btn-block" id="resetBtn">Reset Password</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $('#newPasswordForm').on('submit', function (e) {
            e.preventDefault();
            $('#error-password').text('');
            $('#resetBtn').prop('disabled', true).text('Resetting...');

            $.ajax({
                url: '/api/reset-password',
                method: 'POST',
                data: {
                    email: $('#email').val(),
                    code: $('#code').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val()
                },
                success: function (res) {
                    Swal.fire('Done!', 'Your password has been reset.', 'success').then(() => {
                        window.location.href = '/login';
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