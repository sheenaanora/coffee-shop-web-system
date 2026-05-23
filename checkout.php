<?php
session_start();
require('datacon.php');

// Check if user is logged in
if (!isset($_SESSION['name'])) {
  header("location:login.php");
  exit(); // Stop further execution
}
// Initialize variables
$cartItems = []; // Initialize as an empty array
$totalPrice = 0; // Initialize total price
$totalQuantity = 0; // Initialize total quantity
$item_name_quantity = "";
// Check if cart items are stored in session
if (isset($_SESSION['cart_items']) && is_array($_SESSION['cart_items'])) {
  $cartItems = $_SESSION['cart_items'];

  // Output cart items in the modal and calculate total price
  foreach ($cartItems as $item) {
    list($itemId, $quantity) = explode(':', $item);
    $query = "SELECT item_name, price FROM menu WHERE item_id = $itemId";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $itemName = $row['item_name'];
    $price = $row['price'];
    $totalPrice += $price * $quantity;
    $totalQuantity += $quantity; // Sum up quantities
    $item_name_quantity = $item_name_quantity . $itemName . " x " . $quantity . ", ";
    $_SESSION['item_name_quantity']=$item_name_quantity;
    $_SESSION['totalPrice']=$totalPrice;
    $_SESSION['totalQuantity']=$totalQuantity;

  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cart Summary</title>


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
</head>

<body>
 <!-- Navbar & Hero Start -->
 <div class=" container-xxl position-relative p-0 ">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0 ">
                <a href=" " class="navbar-brand p-0 ">
                    <h1 class="text-primary m-0 "><i class="fa fa-utensils me-3 "></i>Coffee Shop</h1>
                    <!-- <img src="img/logo.png " alt="Logo "> -->
                </a>
                <button class="navbar-toggler " type="button " data-bs-toggle="collapse " data-bs-target="#navbarCollapse ">
            <span class="fa fa-bars "></span>
        </button>
                <div class="collapse navbar-collapse " id="navbarCollapse ">
                    <div class="navbar-nav ms-auto py-0 pe-4 ">
                    <a href="index.php " class="nav-item nav-link ">Home</a>
                        <a href="about.php" class="nav-item nav-link ">About</a>
                        <a href="service.php" class="nav-item nav-link  ">Service</a>
                        <a href="menu.php " class="nav-item nav-link  ">Menu</a>
                    </div>
                    <?php
                        if (isset($_SESSION['name'])) {
                            echo '<a href="logout.php" class="btn btn-primary py-2 px-4">Logout</a>';
                        } else {
                            echo '<a href="login.php" class="btn btn-primary py-2 px-4">Login Now</a>';
                        }
                        ?>
                </div>
            </nav>
            <div class="container-xxl py-5 bg-dark hero-header mb-5 ">
                <div class="container text-center my-5 pt-5 pb-4 ">
                    <h1 class="display-3 text-white mb-3 animated slideInDown ">About</h1>
                    <nav aria-label="breadcrumb ">
                        <ol class="breadcrumb justify-content-center text-uppercase ">
                            <li class="breadcrumb-item "><a href="index.php">Home</a></li>

                            <li class="breadcrumb-item text-white active " aria-current="page ">Cart</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        </div>
        <!-- Navbar & Hero End -->

<div class="container-xxl ">
     
      <div class="container min-vh-100 d-flex justify-content-center align-items-center ">
    <div class="row g-5">
 
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary ">Your cart</span>
          <span class="badge bg-primary rounded-pill px-3 py-2">
            <?php echo $totalQuantity; ?>
          </span>
        </h4>
       <table class="table table-bordered bg-white">
          <thead class="table-dark">
            <tr>
              <th scope="col">Item Name</th>
              <th scope="col">Price</th>
              <th scope="col">Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php
            require('datacon.php');
            // Output cart items
            foreach ($cartItems as $item) {
              list($itemId, $quantity) = explode(':', $item);
              $query = "SELECT item_name, price FROM menu WHERE item_id = $itemId";
              $result = mysqli_query($conn, $query);
              $row = mysqli_fetch_assoc($result);
              $itemName = $row['item_name'];
              $price = $row['price'];
          echo "
            <tr>
              <td>$itemName</td>
              <td>₱" . number_format((float)$price, 2) . "</td>
              <td>$quantity</td>
            </tr>
            ";
            }
            ?>
          </tbody>
          <tfoot >
            <tr>
              <th class="fw-bold">Total</th>
              <td class="fw-bold text-success">₱<?php echo number_format($totalPrice, 2); ?></td>
              <td class="fw-bold"><?php echo $totalQuantity; ?></td> <!-- Display quantity -->
            </tr>
          </tfoot>
          
        </table>
        <div class="container ">
        <form action="insert_order.php" method="POST" >
        
            <form id="buyForm" action="insert_order.php" method="POST" class="card p-2">
              <div class="input-group  ">
                <button type="submit" class="btn btn-primary px-5  " id="buyButton" onclick="buyOrder()">Buy</button>
                <a type="button" class="btn btn-primary mx-5 px-5"  onclick=window.history.back()>Back</a>
              </div>
            </form>
            <div class="d-flex justify-content-center gap-3 mt-4">
           

          </div>
          

        </form>
        </div>
       

      </div>

    </div>
  </div>


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

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>