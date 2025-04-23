@extends('app.layout')

@section('content')
<div class="container mt-5">
    <h2>Verify Reset Code</h2>
    <form id="verifyCodeForm">
        <input type="hidden" id="email" value="{{ request('email') }}">
        <div class="form-group">
            <label>Enter the 6-digit code</label>
            <input type="text" id="code" class="form-control" name="code">
            <small class="text-danger" id="error-code"></small>
        </div>
        <button class="btn btn-primary btn-block" id="verifyBtn">Verify</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
$('#verifyCodeForm').on('submit', function(e) {
    e.preventDefault();
    $('#error-code').text('');
    $('#verifyBtn').prop('disabled', true).text('Verifying...');

    $.ajax({
        url: '/api/verify-reset-code',
        method: 'POST',
        data: {
            email: $('#email').val(),
            code: $('#code').val()
        },
        success: function(res) {
            Swal.fire('Verified', 'Code is correct. Now reset your password.', 'success').then(() => {
                window.location.href = '/set-new-password?email=' + $('#email').val() + '&code=' + $('#code').val();
            });
        },
        error: function(xhr) {
            $('#error-code').text('Invalid code.');
        },
        complete: function() {
            $('#verifyBtn').prop('disabled', false).text('Verify');
        }
    });
});
</script>
@endsection
