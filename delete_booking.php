<?php
require "connect.php";
$query = "SELECT property_name FROM properties 
WHERE property_id = {$_GET["property_id"]}";

$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reygiv | Delete Booking</title>
</head>

<body>
  <div class="container">
    <h2>Are you sure you want to delete
      <?php echo $row["property_name"] ?> from your bookings?
    </h2>
    <form method="POST" action="action_delete.php">
      <input type="hidden" name="property_id" value="<?php echo $_GET["property_id"] ?>" />
      <input type="hidden" name="booking_id" value="<?php echo $_GET["booking_id"] ?>" />
      <button>Delete</button>
    </form>
    <a href="dashboard.php">No, go back.</a>
  </div>
</body>

</html>