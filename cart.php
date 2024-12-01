<?php

// Database connection details
$host = "localhost"; // Replace with your database host
$username = "americar_reside"; // Replace with your database username
$password = "LPcLYu2hVFAcWHU834gr"; // Replace with your database password
$dbname = "americar_reside"; // Replace with your database name
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
    // Prepare and execute the SQL query
    $query = "SELECT * FROM $table WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the data
    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Resido - Real Estate HTML Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .green{
    color: rgb(15, 207, 143);
    font-weight: 680;
}
/* .icon-container {
    display: flex;
    gap: 20px;
} */

.icon {
    /* font-size: 50px; */
    cursor: pointer;
    color: gray; /* Default color */
    transition: color 0.3s;
}

.icon.selected {
    color: blue; /* Selected color */
}

@media(max-width:567px){
    .mobile{
        padding-top: 40px;
    }
}
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <!-- <span class="sr-only">Loading...</span> -->
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="index.php" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <img class="img-fluid" src="img/icon-deal.png" alt="Icon" style="width: 30px; height: 30px;">
                    </div>
                    <!-- <h1 class="m-0 text-primary">Resido</h1> -->
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="property-list.php" class="nav-item nav-link">Property List</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Application</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="testimonial.php" class="dropdown-item">Renewal</a>
                                <a href="404.html" class="dropdown-item">Make payment</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                        
                    </div>
                    <!-- <a href="" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a> -->
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

<!-- Category Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3"></h1>
        </div>
        <div class="row g-5">
            <!-- <div class="col-lg-6 col-sm-6 wow fadeInUp" data-wow-delay="0.1s"> -->
                <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="property-item rounded overflow-hidden">
                        <div class="position-relative overflow-hidden">
                            <a href=""><img class="img-fluid" src="<?= $data['image']?>" alt=""></a>
                            <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"><?= $data['transaction_type']?></div>
                            <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"><?= $data['prop_type']?></div>
                        </div>
                        <div class="p-4 pb-0">
                            <h5 class="text-primary mb-3"><?= $data['asking_price']?></h5>
                            <a class="d-block h5 mb-2" href=""><?= $data['name']?></a>
                            <p><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $data['prop_location']?></p>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i><?= $data['asking_price']." Sqft"?></small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i><?= $data['asking_price']." Bed"?></small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i><?= $data['asking_price']." Bath"?></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 wow fadeInUp">
                    <!-- <div class="col-md-6"> -->
                        
                        <!-- <h5 class="mb-3">Installmental</h5> -->
                        <div class="about">
                            <!-- <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row mt-1">
                                    <h6>Custom Payment Plan</h6>
                                    
                                </div>
                                <div class="d-flex flex-row align-items-center com-color"> <i class="fa fa-plus-circle"></i> <span class="ml-1">Add Insurer card</span> </div>
                            </div> -->
                            <p>
                                <!-- Elegant 2-bedroom, 2-bath apartment in The Heights, Unit 305, downtown Springfield. 
                                This 1,200 sq. ft. gem features an open-concept living area with hardwood floors 
                                and large windows showcasing stunning city views. The modern kitchen is equipped 
                                with stainless steel appliances, quartz countertops, and ample storage. 
                                The master suite includes a walk-in closet and a luxurious en-suite bathroom 
                                with dual sinks and a soaking tub. A private balcony extends your living space outdoors. 
                                Enjoy top-notch amenities such as a fitness center, rooftop garden, and secure parking. 
                                Located within walking distance to vibrant shops, restaurants, and public transit, 
                                this apartment offers both comfort and convenience in a prime urban setting. -->
                                <?= $data['description']?>
                            </p>
                            <!-- <div class="p-2 d-flex justify-content-between bg-pay align-items-center"> <span>Aetna - Open Access</span> <span>OAP</span> </div> -->
                            <hr>
                            <!-- <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row mt-1">
                                    <h6>Installmental Payment Plan</h6>
                                    
                                </div>
                                <div class="d-flex flex-row align-items-center com-color"> <i class="fa fa-plus-circle"></i> <span class="ml-1">Add Insurer card</span> </div>
                            </div>
                            <p>Insurance claim and all neccessary dependencies will be submitted to your insurer for the covered portion of this order.</p>
                            <div class="p-2 d-flex justify-content-between bg-pay align-items-center"> <span>Aetna - Open Access</span> <span>OAP</span> </div>
                            <hr> -->
                            <!-- <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row mt-1">
                                    <h6>Lump Sum Payment Plan</h6>
                                    
                                </div>
                                <div class="d-flex flex-row align-items-center com-color"> <i class="fa fa-plus-circle"></i> <span class="ml-1">Add Insurer card</span> </div>
                            </div>
                            <p>Insurance claim and all neccessary dependencies will be submitted to your insurer for the covered portion of this order.</p>
                            <div class="p-2 d-flex justify-content-between bg-pay align-items-center"> <span>Aetna - Open Access</span> <span>OAP</span> </div>
                            <hr> -->
                            <!-- <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row mt-1">
                                    <h6>Lump Sum Payment Plan</h6>
                                </div>
                                <div class="d-flex flex-row align-items-center com-color"> <i class="fa fa-plus-circle"></i> <span class="ml-1">Add Payment card</span> </div>
                            </div>
                            <p>Insurance claim and all neccessary dependencies will be submitted to your insurer for the covered portion of this order.</p>
                            <div class="p-2 d-flex justify-content-between bg-pay align-items-center"> <span>Aetna - Open Access</span> <span>OAP</span> </div>
                            <hr> -->
                            <!-- <div class="d-flex flex-column"> <label class="radio"> <input type="radio" name="gender" value="MALE" checked>
                                    <div class="d-flex justify-content-between"> <span>VISA</span> <span>**** 5645</span> </div>
                                </label> <label class="radio"> <input type="radio" name="gender" value="FEMALE">
                                    <div class="d-flex justify-content-between"> <span>MASTER CARD</span> <span>**** 5069</span> </div>
                                </label> </div>
                            <div class="buttons"> <button class="btn btn-success btn-block">Proceed to payment</button> </div> -->
                            <!-- <div class="buttons"> <button class="btn btn-success btn-block">Proceed</button> </div> -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-row my-4">
                                    <h6> Available Payment Plans</h6>
                                </div>
                            </div>
                            <input type="hidden" name="plan" id="plan">
                            <div class="d-flex flex-column"> 
                                <label class="radio"> 
                                    <div class="d-flex justify-content-between"> 
                                        <span>Custom Payment Plan</span>
                                        
                                        <i class="fa fa-plus-circle icon" data-toggle="modal" data-target="#paymentModal" id="icon1"></i>
                                    </div>
                                </label>
                                <br> 
                                <!-- <label class="radio">
                                    <div class="d-flex justify-content-between">
                                        <span>Installmental Payment Plan</span> 
                                        <span><i class="fa fa-plus-circle icon" id="icon1"></i></span> 
                                    </div>
                                </label> -->
                                <br>
                                <label class="radio"> 
                                    <div class="d-flex justify-content-between"> 
                                        <span>Lump Sum Payment Plan</span> 
                                        <span><i class="fa fa-plus-circle icon" id="icon2"></i></span> 
                                    </div>
                                </label>  
                            </div>
                            <div class="buttons my-4"> 
                                <button class="btn btn-success btn-block" id="proceed" disabled>Proceed</button> 
                            </div>


                            
                        </div>
                    <!-- </div> -->
                </div>
            <!-- </div> -->
            <!-- <div class="col-lg-4 col-sm-6 wow fadeInUp" data-wow-delay="0.3s"> -->
                
            
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="mb-0 text-success">$85.00</h5>
                    <h5 class="mb-3">Diabetes Pump & Supplies</h5>
                    <div class="about">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-row mt-1">
                                <h6>Insurance Responsibility</h6>
                                <h6 class="text-success font-weight-bold ml-1">$71.76</h6>
                            </div>
                            <div class="d-flex flex-row align-items-center com-color">
                                <i class="fa fa-plus-circle"></i> <span class="ml-1">Add Insurer card</span> 
                            </div>
                        </div>
                        <p>Insurance claim and all necessary dependencies will be submitted to your insurer for the covered portion of this order.</p>
                        <div class="p-2 d-flex justify-content-between bg-pay align-items-center"> 
                            <span>Aetna - Open Access</span> <span>OAP</span> 
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row mt-1">
                                <h6>Patient Balance</h6>
                                <h6 class="text-success font-weight-bold ml-1">$13.24</h6>
                            </div>
                            <div class="d-flex flex-row align-items-center com-color"> 
                                <i class="fa fa-plus-circle"></i> <span class="ml-1">Add Payment card</span> 
                            </div>
                        </div>
                        <p>Insurance claim and all necessary dependencies will be submitted to your insurer for the covered portion of this order.</p>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">.00</span>
                        </div>
                        <div class="buttons">
                            <a href="cc/index.html" class="btn btn-success btn-block">Proceed to payment</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- You can add another button here if needed -->
                </div>
            </div>
        </div>
    </div>
<!-- Category End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Photo Gallery</h5>
                        <div class="row g-2 pt-2">
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-1.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-2.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-3.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-4.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-5.jpg" alt="">
                            </div>
                            <div class="col-4">
                                <img class="img-fluid rounded bg-light p-1" src="img/property-6.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Home</a>
                                <a href="">Cookies</a>
                                <a href="">Help</a>
                                <a href="">FQAs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        const icons = document.querySelectorAll('.icon');

icons.forEach(icon => {
    icon.addEventListener('click', () => {
        // Remove 'selected' class from all icons
        icons.forEach((i) => {
            i.classList.remove('selected')
            // console.log(i);
            
        });
        
        // Add 'selected' class to the clicked icon
        icon.classList.add('selected');
        if(icon.id == "icon1"){
            $("#plan").val("custom")
            // console.log($("#plan").val());
        }
        if(icon.id == "icon2"){
            $("#plan").val("full")
        }
        $("#proceed").prop("disabled", false)
    
    });

});

    $("#proceed").click(() => {
        if($("#plan").val() == "custom"){
            window.location.href = "checkout.php?id=<?=$id?>"
        }

        if($("#plan").val() == "full"){
            var params = {
                id: '<?=$id?>',
                amount: <?=$data['final_price']?>
            };

            let uri = 'buy.php?' + $.param(params);
            window.location.href = uri
        }
    })
    </script>
</body>

</html>