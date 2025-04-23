@extends('app.layout')

@section('content')
    <div class="container mt-5">
        <h2>Forgot Password</h2>
        <form id="forgotForm">
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="forgotEmail" class="form-control" name="email">
                <small class="text-danger" id="error-email"></small>
            </div>
            <button class="btn btn-warning btn-block" id="forgotBtn">Send Code</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $('#forgotForm').on('submit', function (e) {
            e.preventDefault();
            $('#error-email').text('');
            $('#forgotBtn').prop('disabled', true).text('Sending...');

            $.ajax({
                url: '/forgot-password',
                method: 'POST',
                data: { email: $('#forgotEmail').val() },
                success: function (res) {
                    Swal.fire('Email Sent', 'Check your inbox for the reset code.', 'success');
                    $('#forgotForm')[0].reset();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $('#error-email').text(xhr.responseJSON.errors.email[0]);
                    } else {
                        Swal.fire('Error', 'Unable to send reset email.', 'error');
                    }
                },
                complete: function () {
                    $('#forgotBtn').prop('disabled', false).text('Send Code');
                }
            });
        });
    </script>
@endsection