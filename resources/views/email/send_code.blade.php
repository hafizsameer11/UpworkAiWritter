<!-- filepath: resources/views/email/send_code.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Your Verification Code</title>
</head>
<body>
    <h1>Your Verification Code</h1>
    <p>Your verification code is: <strong>{{ $verification_code }}</strong></p>
    <p>Please use this code to complete your verification process.</p>
</body>
</html>