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
            <h2 class="text-center mb-4">Forgot Password</h2>
            <form id="forgotForm">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="forgotEmail" class="form-control" name="email">
                    <small class="text-danger" id="error-email"></small>
                </div>
                <button type="submit" class="btn btn-warning w-100 mt-3" id="forgotBtn">Send Code</button>
            </form>
        </div>
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
                    localStorage.setItem('reset_email', $('#forgotEmail').val());
                    window.location.href = "{{ route('auth.verify') }}";
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