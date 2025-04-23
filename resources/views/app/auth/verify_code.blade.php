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
            <h2 class="text-center mb-4">Verify Reset Code</h2>
            <form id="verifyCodeForm">
                <input type="hidden" id="email">
                <div class="form-group">
                    <label>Enter the 6-digit code</label>
                    <input type="text" id="code" class="form-control" name="code">
                    <small class="text-danger" id="error-code"></small>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3" id="verifyBtn">Verify</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('email').value = localStorage.getItem('reset_email');

        $('#verifyCodeForm').on('submit', function (e) {
            e.preventDefault();
            $('#error-code').text('');
            $('#verifyBtn').prop('disabled', true).text('Verifying...');

            $.ajax({
                url: '/verify-reset-code',
                method: 'POST',
                data: {
                    email: $('#email').val(),
                    code: $('#code').val()
                },
                success: function (res) {
                    Swal.fire('Verified', 'Code is correct. Now reset your password.', 'success').then(() => {
                        window.location.href = '/set-new-password?email=' + $('#email').val() + '&code=' + $('#code').val();
                    });
                },
                error: function (xhr) {
                    $('#error-code').text('Invalid code.');
                },
                complete: function () {
                    $('#verifyBtn').prop('disabled', false).text('Verify');
                }
            });
        });
    </script>
@endsection
