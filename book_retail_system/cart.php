<?php

if(session_id() == '' || !isset($_SESSION)){session_start();}
include 'config.php';
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping Cart || Book Retail Store</title>
    <link rel="stylesheet" href="css/foundation.css" />
    <script src="js/vendor/modernizr.js"></script>
    <style>
      footer {
        position: fixed;
        width:70%;
        bottom:0;
      }
    </style>
  </head>
  <body>
    <nav class="top-bar" data-topbar role="navigation">
      <ul class="title-area">
        <li class="name">
          <h1><a href="index.php">Book Retail System</a></h1>
        </li>
        <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
      </ul>
      <section class="top-bar-section">
        <ul class="right">
          <li><a href="about.php">About</a></li>
          <li><a href="products.php">Products</a></li>
          <li class="active"><a href="cart.php">View Cart</a></li>
          <li><a href="orders.php">My Orders</a></li>
          <?php
          if(isset($_SESSION['username'])){
            echo '<li><a href="account.php">My Account</a></li>';
            echo '<li><a href="admin.php">ADD Products</a></li>';
            echo '<li><a href="logout.php">Log Out</a></li>';
          }
          else{
            echo '<li><a href="login.php">Log In</a></li>';
            echo '<li><a href="register.php">Register</a></li>';
          }
          ?>
        </ul>
      </section>
    </nav>
    <div class="row" style="margin-top:10px;">
      <div class="large-12">
        <?php
          echo '<p><h3>Your Shopping Cart</h3></p>';
          if(isset($_SESSION['id'])){
          $result1 = $mysqli->query("SELECT * FROM cart WHERE customer_id=".$_SESSION["id"]);
          if($result1) {

            $total = 0;
            echo '<table>';
            echo '<tr>';
            echo '<th>Code</th>';
            echo '<th>Name</th>';
            echo '<th>Quantity</th>';
            echo '<th>Cost</th>';
            echo '</tr>';
            while($cart=$result1->fetch_object()) {
            
            $result = $mysqli->query("SELECT id, product_name, product_desc, qty, price FROM products WHERE id = ".$cart->product_id);
            $quantity=$cart->quantity;
            if($result){
              while($obj = $result->fetch_object()) {
                $cost = $obj->price * $quantity; 
                $total = $total + $cost; 
                echo '<tr>';
                echo '<td>'.$obj->id.'</td>';
                echo '<td>'.$obj->product_name.'</td>';
                echo '<td>'.$quantity.'&nbsp;<a class="button [secondary success alert]" style="padding:5px;" href="update-cart.php?action=update&id='.$cart->product_id.'">+</a>&nbsp;<a class="button alert" style="padding:5px;" href="update-cart.php?action=remove&id='.$cart->product_id.'">-</a></td>';
                echo '<td>'.$cost.'</td>';
                echo '</tr>';
              }
            }

          }
          echo '<tr>';
          echo '<td colspan="3" align="right">Total</td>';
          echo '<td>'.$total.'</td>';
          echo '</tr>';
          echo '<tr>';
          echo '<td colspan="4" align="right"><a href="update-cart.php?action=empty&id=0" class="button alert">Empty Cart</a>&nbsp;<a href="products.php" class="button [secondary success alert]">Continue Shopping</a>';
          if(isset($_SESSION['username'])) {
            echo '<a href="orders-update.php"><button style="float:right;">COD</button></a>';
          }
          else {
            echo '<a href="login.php"><button style="float:right;">Login</button></a>';
          }
          echo '</td>';
          echo '</tr>';
          echo '</table>';
        }
        else {
          echo "You have no items in your shopping cart.";
        }
      }
      else {
        echo "<h1>You have not logged in.<h1/>";
      }
          echo '</div>';
          echo '</div>';
          ?>
          <div class="row" style="margin-top:10px;">
      <div class="small-12">
        <footer style="margin-top:10px;">
           <p style="text-align:center; font-size:0.8em;clear:both;">&copy; 2022 copyright: Book Retail Store.; </p>
        </footer>
      </div>
    </div>
   <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>
