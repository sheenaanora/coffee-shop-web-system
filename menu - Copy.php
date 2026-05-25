<?php


session_start();

// Check if dark mode preference is set in session
$darkMode = isset($_SESSION['dark_mode']) ? $_SESSION['dark_mode'] : false;
require('datacon.php');
if(isset($_SESSION['name'])){}
	else{
		header("location:login.php");
		
	}

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
   
    <title>Coffee Shop Menu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">


  
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

      <script>
        function addToCart() {
            // Get all quantity inputs
            var quantityInputs = document.querySelectorAll("[id^='quantity_']");
            var cartItems = [];

            // Iterate through each quantity input and add to cartItems array
            quantityInputs.forEach(function(input) {
                var itemId = input.id.split('_')[1]; // Extract item ID
                var quantity = input.value;
                if (quantity > 0) {
                    cartItems.push(itemId + ":" + quantity);
                }
            });

            // Append cartItems to a hidden input field
            var cartItemsInput = document.createElement("input");
            cartItemsInput.type = "hidden";
            cartItemsInput.name = "cart_items";
            cartItemsInput.value = cartItems.join(",");
            document.getElementById("orderForm").appendChild(cartItemsInput);

            // Update cart counter
            updateCartCounter(cartItems.length);

            // Alert user
            alert("Added items to your cart.");
        }

        function updateCartCounter(count) {
            var cartCounter = document.getElementById("cartCounter");
            cartCounter.textContent = count;
        }
    </script>
</head>
<body >
     <!-- Navbar & Hero Start -->
 <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Coffee Shop</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0 pe-4">
                        <a href="index.php" class="nav-item nav-link ">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="service.php" class="nav-item nav-link  ">Service</a>
                        <a href="menu.php" class="nav-item nav-link active">Menu</a>
                        
                        
                    </div>
                    <div class="nav-item flex-shrink-0 dropdown ">

                        <a href="#" class="nav-item nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img src="./img/person-circle.svg" alt="mdo" width="32" height="32" class="rounded-circle"> -->
                            <?php if (isset($_SESSION['name'])) {
                                echo " " . $_SESSION['name'] . "";
                            } else {
                                echo "Guest";
                            } ?>
                        </a>

                        <ul class="dropdown-menu text-small shadow">
                        <li class="dropdown-item">Hy!  <?php if (isset($_SESSION['name'])) {
                                echo " " . $_SESSION['name'] . "";
                            } else {
                                echo "Guest";
                            } ?></li>
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li><a class="dropdown-item" href="#"><?php
                                                                    if (isset($_SESSION['name'])) {
                                                                        echo '<a href="logout.php" class="dropdown-item ">Logout</a>';
                                                                    } else {
                                                                        echo '<a href="login.php" class="dropdown-item ">Login Now</a>';
                                                                    }
                                                                    ?></a></li>
                            
                        </ul>
                                                                    
                    </div>
                    
            </nav>
            <!-- Navbar end -->
            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Food Menu</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                           
                            <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
  </div>
<!-- Navbar & Hero End -->


<div class="container">
        <h1 class="my-4">Coffee Shop Menu</h1>
        <form action="addToCart.php" method="post" id="orderForm">
            <div class="row ">
                <?php
                include("datacon.php"); // Include database connection file

                // Query to fetch menu items from the database
                $sql = "SELECT * FROM menu";
                $result = mysqli_query($conn, $sql);

                // Check if there are any menu items
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each row of data
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="col-xl-3 mb-5">
                            <div class="card h-100">
                                <img class="card-img-top" src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['item_name']; ?>">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $row['item_name']; ?></h4>
                                    <h5 class="card-title">₹<?php echo $row['price']; ?></h5>
                                    <p class="card-text mb-4"><?php echo $row['description']; ?></p>
                                    <!-- Quantity input -->
                                    
                                <label for="quantity_<?php echo $row['item_id']; ?>">Quantity:</label>
                                <div class="input-group ">
                                   
                                    <input type="number" name="quantity_<?php echo $row['item_id']; ?>" id="quantity_<?php echo $row['item_id']; ?>" class="form-control quantity-input-field" value="0" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    echo "No menu items available.";
                }

                // Close database connection
                mysqli_close($conn);
                ?>
                <div class="col-md-4 mb-5">
                <button type="button" class="btn btn-primary btn-block" onclick="addToCart()">Add to Cart</button>
              <!-- Button trigger modal -->
              
            </div>
           
            </div>
            
        </form>
    </div>
 

<!-- Bootstrap JS (optional) -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
<script>
    
   // Add event listener to each plus button
// plusButtons.forEach(button => {
//     button.addEventListener('click', (event) => {
//         event.stopPropagation(); // Prevent event propagation
//         const itemId = button.getAttribute('data-item-id');
//         const quantityInput = document.getElementById(`quantity_${itemId}`);
//         let quantity = parseInt(quantityInput.value);
//         quantity++;
//         quantityInput.value = quantity;
//     });
// });

// // Add event listener to each minus button
// minusButtons.forEach(button => {
//     button.addEventListener('click', (event) => {
//         event.stopPropagation(); // Prevent event propagation
//         const itemId = button.getAttribute('data-item-id');
//         const quantityInput = document.getElementById(`quantity_${itemId}`);
//         let quantity = parseInt(quantityInput.value);
//         if (quantity > 0) {
//             quantity--;
//             quantityInput.value = quantity;
//         }
//     });
// });

    function addToCart() {
    // Get all quantity inputs
    var quantityInputs = document.querySelectorAll("[id^='quantity_']");
    var cartItems = [];

    // Iterate through each quantity input and add to cartItems array
    quantityInputs.forEach(function(input) {
        var itemId = input.id.split('_')[1]; // Extract item ID
        var quantity = input.value;
        if (quantity > 0) {
            cartItems.push(itemId + ":" + quantity);
        }
    });

    // Append cartItems to a hidden input field
    var cartItemsInput = document.createElement("input");
    cartItemsInput.type = "hidden";
    cartItemsInput.name = "cart_items";
    cartItemsInput.value = cartItems.join(",");
    document.getElementById("orderForm").appendChild(cartItemsInput);

    // Submit the form
    document.getElementById("orderForm").submit();
}

    
</script>
</body>
</html>
