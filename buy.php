<?php
include_once "Controller/Controller.class.php";

// Database connection details
$host = "localhost"; // Replace with your database host
$username = "americar_reside"; // Replace with your database username
$password = "LPcLYu2hVFAcWHU834gr"; // Replace with your database password
$dbname = "americar_reside"; // Replace with your database name

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Day 002 - Credit Card Checkout</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // JavaScript Validation: Luhn Algorithm for credit card validation
        function isValidCardNumber(cardNumber) {
            let sum = 0;
            let shouldDouble = false;
            for (let i = cardNumber.length - 1; i >= 0; i--) {
                let digit = parseInt(cardNumber[i]);

                if (shouldDouble) {
                    digit *= 2;
                    if (digit > 9) {
                        digit -= 9;
                    }
                }

                sum += digit;
                shouldDouble = !shouldDouble;
            }
            return sum % 10 === 0;
        }

        function validateCardInput() {
            const cardNumberInput = document.getElementById("credit-card-num");
            const cardNumber = cardNumberInput.value.replace(/\s+/g, ""); // Remove spaces
            const errorDiv = document.getElementById("card-error");

            if (!isValidCardNumber(cardNumber)) {
                errorDiv.textContent = "Invalid card number. Please check and try again.";
                return false;
            }
            errorDiv.textContent = ""; // Clear error
            return true;
        }

        document.addEventListener("DOMContentLoaded", () => {
            const cardForm = document.getElementById("card-form");
            cardForm.addEventListener("submit", (event) => {
                if (!validateCardInput()) {
                    event.preventDefault(); // Stop form submission
                }
            });
        });
    </script>
</head>
<body>
    <div class="payment-info">
        <h3 class="payment-heading">Payment Information</h3>
        <form id="card-form" action="process_payment.php" method="POST">
            <label for="credit-card-num">Card Number
                <input type="text" id="credit-card-num" name="credit-card-num" maxlength="19" placeholder="1234 5678 9012 3456" required>
            </label>
            <div id="card-error" style="color: red;"></div>

            <label for="expiration-date">Expiration Date
                <input type="text" id="expiration-date" name="expiration-date" placeholder="MM/YY" required>
            </label>

            <label for="cvv">CVV
                <input type="text" id="cvv" name="cvv" maxlength="3" placeholder="123" required>
            </label>

            <button type="submit">Submit Payment</button>
        </form>
    </div>
</body>
</html>

<?php
// PHP Validation: Luhn Algorithm for server-side validation
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function isValidCardNumber($cardNumber) {
        $cardNumber = preg_replace('/\D/', '', $cardNumber); // Remove non-digits
        $sum = 0;
        $shouldDouble = false;

        for ($i = strlen($cardNumber) - 1; $i >= 0; $i--) {
            $digit = (int)$cardNumber[$i];

            if ($shouldDouble) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
            $shouldDouble = !$shouldDouble;
        }

        return $sum % 10 === 0;
    }

    $cardNumber = $_POST['credit-card-num'] ?? '';
    if (!isValidCardNumber($cardNumber)) {
        die("Invalid card number. Payment rejected.");
    }

    // Further processing for valid card numbers...
}
?>
