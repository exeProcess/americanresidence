<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success | Real Estate</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        /* General Page Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        /* Container for the success message */
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            font-size: 2.5rem;
            color: #28a745;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .details {
            text-align: left;
            background-color: #f1f1f1;
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 5px solid #28a745;
        }

        .details p {
            margin: 10px 0;
            font-size: 1rem;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .icon {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <h1>Payment Successful!</h1>
        <p>Thank you for your payment. Your transaction has been processed successfully.</p>

        <div class="details">
            <p><strong>Transaction ID:</strong> #TX123456789</p>
            <p><strong>Property:</strong> 3 Bedroom Apartment, Downtown</p>
            <p><strong>Amount Paid:</strong> $350,000</p>
            <p><strong>Payment Method:</strong> Credit Card</p>
            <p><strong>Date:</strong> November 10, 2024</p>
        </div>

        <p>What happens next?</p>
        <p>Our team will process your purchase and contact you within the next 24 hours with further instructions. Thank you for choosing us for your new property!</p>

        <a href="index.php" class="btn">Return to Homepage</a>
    </div>

</body>
</html>
