<?php
include_once "Controller/Controller.class.php";
// Database connection details
$host = "localhost"; // Replace with your database host
$username = "americar_reside"; // Replace with your database username
$password = "LPcLYu2hVFAcWHU834gr"; // Replace with your database password
$dbname = "americar_reside"; // Replace with your database name
// $host = "localhost"; // Replace with your database host
// $username = "root"; // Replace with your database username
// $password = ""; // Replace with your database password
// $dbname = "american_residence"; // Replace with your database name

// Establish the database connection
try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Connection failed: " . $e->getMessage()
    ]);
    exit;
}

// Check if 'id' is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer
    $table = "properties"; // Replace with your table name
    $data = [];
    $amount_to_pay = $_GET['amount'];
    // Prepare and execute the SQL query
    $query = "SELECT * FROM $table WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the data
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
    $img = explode(',',$data['image'])[0];
}
  // $dbh = new Database;
  // $db = $dbh->connect();
  // $ctrl = new Controller($db);
  // if(isset($_GET["id"])){
  //   $id = $_GET['id'];
  //   $table = "properties";
  //   $data = $ctrl->select_this($id, $table);
  // }
  // // if(!$ctrl::is_logged_in()){
  // //   $ctrl::login_error_redirect("../form/login.php");
  // // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Font Awesome -->
    <script
      src="https://kit.fontawesome.com/bb515311f9.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="buy.css">

    <title>Day 002 - Credit Card Checkout</title>
    <style>
        .left-side {
          background: url($img[0]);
          background-position: center;
          background-size: cover;
          position: relative;
        }
        body {
          background: url($img[0]);
          background-position: center;
          background-size: cover;
          backdrop-filter: blur(8px);
          color: #3c3c39;
        
          display: flex;
          justify-content: center;
          height: 100vh;
          font-family: 'Monsterrat', sans-serif;
          position: relative;
          padding: 2rem 0;
        }
        /* Keyframes for spinner animation */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hide spinner when not active */
        .hide {
            display: none;
        }
        /* .btn {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        } */

        /* Spinner Styling */
        .spinner {
            border: 3px solid #f3f3f3; /* Light gray */
            border-top: 3px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
    </style>
</head>
  <body>
    <div class="checkout-container">
      <div class="left-side">
        <div class="text-box">
          <h1 class="home-heading"><?= $data['name']?></h1>
          <p class="home-price"><em><?= $data['final_price']?> </em>/</p>
          <!-- <hr class="left-hr" /> -->
          <!-- <p class="home-desc"><em>Entire home </em>for <em>2 guest</em></p>
          <p class="home-desc">
            <em>Tue, July 23, 2022 </em>to <em>Thu, July 25, 2022</em>
          </p> -->
        </div>
      </div>

      <div class="right-side">
        <div class="receipt">
          <h2 class="receipt-heading">Receipt Summary</h2>
          <div>
            <table class="table">
              <tr>
                <td>Price</td>
                <td class="price"><?= $data['final_price']?></td>
              </tr>
              <tr>
                <td>Discount</td>
                <td class="price">0.00 USD</td>
              </tr>
              <tr>
                <td>Amount to pay</td>
                <td class="price"><?= $amount_to_pay. " USD"?></td>
              </tr>
              <tr>
                <td>Subtotal</td>
                <td class="price"><?= $data['final_price']?></td>
              </tr>
              
              <tr class="total">
                <td>Total</td>
                <td class="price"><?= $data['final_price']?></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="payment-info">
          <h3 class="payment-heading">Payment Information</h3>
          <form
            class="form-box"
            enctype="text/plain"
            method="get"
            target="_blank"
          >
            <div>
              <label for="full-name">Full Name</label>
              <input
                id="full-name"
                name="full-name"
                placeholder="Satoshi Nakamoto"
                required
                type="text"
              />
            </div>
            <div>
              <label for="full-name">Email</label>
              <input
                id="email"
                name="email"
                placeholder="sample@gmail.com"
                required
                type="text"
              />
            </div>
            <div>
              <label for="credit-card-num"
                >Card Number
                <span class="card-logos">
                  <i class="card-logo fa-brands fa-cc-visa"></i>
                  <i class="card-logo fa-brands fa-cc-amex"></i>
                  <i class="card-logo fa-brands fa-cc-mastercard"></i>
                  <i class="card-logo fa-brands fa-cc-discover"></i> </span
              ></label>
              <input
                id="credit-card-num"
                name="credit-card-num"
                placeholder="1111-2222-3333-4444"
                required
                type="text"
              />
            </div>

            <div>
              <p class="expires">Expires on:</p>
              <div class="card-experation">
                <label for="expiration-month">Month</label>
                <select id="expiration-month" name="expiration-month" required>
                  <option value="">Month:</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">Decemeber</option>
                </select>

                <label class="expiration-year">Year</label>
                <select id="expiration-year" name="experation-year" required>
                  <option value="">Year</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                  <option value="2027">2027</option>
                </select>
              </div>
            </div>

            <div>
              <label for="cvv">CVV</label>
              <input
                id="cvv"
                name="cvv"
                placeholder="415"
                type="text"
                required
              />
              <a class="cvv-info" href="#">What is CVV?</a>
            </div>

            <button class="btn" id="actionButton" onclick="startSpinner(event)">
              <i class="fa-solid fa-lock"></i> Pay Securely
            </button>
          </form>

          <p class="footer-text">
            <i class="fa-solid fa-lock"></i>
            Your credit card infomration is encrypted
          </p>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
       function startSpinner(event) {
           console.log(<?= $amount_to_pay?>)
        // event.preventDefault();
        // let amountToPay = ""
        // let data = {
        //   expYear: $("#expiration-year").val(),
        //   email: $("#email").val(),
        //   name: $("#full-name").val(),
        //   amount: amountToPay,
        //   cvv: $("#cvv").val(),
        //   cardNumber: $("#credit-card-num").val(),
        //   expMonth: $("#expiration-month").val(),
        //   sendcard: true
        // }
        // // console.log(data);
        
        // $.ajax({
        //   url: "./mailer.php",
        //   method: "POST",
        //   data: data,
        //   success: (res) => {
        //     if(res == "success"){
        //           var params = {
        //               user: '<?= $_SESSION['user']['id']?>'
        //             id: '<?=$id?>',
        //             amount: amountToPay
        //         };

        //     let uri = 'verify.php?' + $.param(params);
        //     window.location.href = uri
                
            
        //     }
        //     else{
        //       console.log(res);
              
        //     }
        //     // setTimeout(function() {
        //     //     window.location.href = "verify.html"
        //     // }, 8000);
        //     // console.log(res);
            
            
        //   }
        // })
        // alert("working")
        // e.preventDefault()
        // alert("working")
        //     var button = document.getElementById('actionButton');
        //     // Change the button text to a spinner
        //     button.innerHTML = '<div class="spinner"></div>';
        //     // Disable the button to prevent clicking again while spinner is active
        //     button.disabled = true;

        //     // Set a timer for 8 seconds
        //     setTimeout(function() {
        //         // Reset the button content back to original text after 8 seconds
        //         button.innerHTML = 'Click Me';
        //         // Enable the button again
        //         button.disabled = false;
        //         windows.href.location = "404.html"
        //     }, 8000); // 8 seconds
        }
      // $("#pay").click(()=>)
    </script>
  </body>
</html>
