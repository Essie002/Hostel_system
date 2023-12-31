<?php
require "connect.php";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_SESSION["username"])) {
    if (isset($_POST)) {
      $userName = $_POST["username"];
      $password = $_POST["user_password"];
      $email = $_POST["email"];

      $query = "SELECT * FROM users
        WHERE user_name ='$userName'
        AND user_password = '$password'
        AND email = '$email'";

      $result = mysqli_query($mysqli, $query);
      $row = mysqli_fetch_assoc($result);

      if (isset($row)) {
        $_SESSION["username"] = $row["full_name"];
      } else {
        header("Location: login.php?message=Invalid username, email or password");
      }
    }
  }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!isset($_SESSION["username"])) {
    header("Location: index.html");
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./assets/CSS/index.css">
  <link rel="stylesheet" href="./assets/CSS/dashboard.css"/>
  <title>Reygiv : Dashboard</title>
</head>

<body>
  <div class="top-content">
    <header>
      <nav class="navbar">
        <a href="#" class="nav-branding">Reygiv Properties</a>
        <ul class="nav-menu">
          <li class="nav-item">
            <a href="#" class="nav-link">Dashboard</a>
          </li>
          <li class="nav-item">
            <a href="properties.php" class="nav-link">Properties</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">Log out</a>
          </li>
        </ul>
        <div class="hamburger">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </nav>
    </header>
  </div>

  <h1>Dashboard</h1>
  <section class="greet_user">
    <div class="container">

      <h2 class="user">
        <span class="greet"></span>
        <span id="username">
          <?php echo $_SESSION["username"] ?>
        </span>
      </h2>
    </div>
  </section>

  <section class="bookings">
    <h2>Bookings</h2>
    <div class="booked">
      <?php
      $query = "SELECT p.property_name, b.booking_id, b.property_id, classification, time_booked, p.image_url
    FROM properties p
    JOIN bookings b
    ON p.property_id = b.property_id
    WHERE b.user_id = (SELECT user_id FROM users
        WHERE full_name = '{$_SESSION['username']}')
    ";

      $result = mysqli_query($mysqli, $query);
      $row = mysqli_fetch_assoc($result);

      if ($row) {
        echo <<<html
       <div class='booking-container' style="background-image: url({$row['image_url']}.jpg);">
       <p>{$row['property_name']}</p>
       <p>{$row['classification']}</p>
       <p>{$row['time_booked']}</p>
       <a href='delete_booking.php?booking_id={$row['booking_id']}&property_id={$row['property_id']}' class='btns'><button>Delete booking</button></a>
       </div>
      html;
      } else {
        echo "<div>You currently don't have any bookings</div>";
      }
      ?>
    </div>
    <?php
    echo "<a href='properties.php' class='btns'>
      <button>Go to properties</button>
    </a>";
    ?>
  </section>

  <section class="basket">
    <h2>Basket</h2>

    <?php
    $query = "SELECT p.property_name, b.booking_id, b.property_id, classification, time_booked, p.image_url
    FROM properties p
    JOIN basket b
    ON p.property_id = b.property_id
    WHERE b.user_id = (SELECT user_id FROM users
        WHERE full_name = '{$_SESSION['username']}')
    ";

    $result = mysqli_query($mysqli, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
      echo <<<html
       <div class='booking-container' style="background-image: url({$row['image_url']}.jpg);">
       <p>{$row['property_name']}</p>
       <p>{$row['classification']}</p>
       <p>{$row['time_booked']}</p>
       </div>
      html;
    } else {
      echo "<div>You currently don't have any bookings</div>";
    }



    ?>
    <a href="basket.php">
      <button>View more</button>
    </a>
  </section>

  <?php include "footer.html" ?>

  <script src="./assets/JS/greet.js"></script>
  <script src="./assets/JS/hamburger.js"></script>
</body>

</html>
