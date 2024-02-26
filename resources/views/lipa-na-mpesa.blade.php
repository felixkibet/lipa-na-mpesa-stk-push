<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipa na M-PESA</title>
</head>
<body>
<h1>Lipa na M-PESA</h1>

<form method="POST" action="{{ route('payments.initiate-payment') }}">
    @csrf
    <label for="amount">Amount:</label><br>
    <input type="text" id="amount" name="amount" required><br><br>

    <label for="phone">Phone Number:</label><br>
    <input type="text" id="phone" name="phoneno" required><br><br>

    <button type="submit">Pay with M-PESA</button>
</form>
</body>
</html>
