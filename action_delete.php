<?php
require "connect.php";
$query = "DELETE FROM bookings WHERE 
booking_id = {$_POST["booking_id"]}";

$result = mysqli_query($mysqli, $query);
if ($result) {
    echo "Successfully deleted! <br>";
    $query = "UPDATE properties
    SET available_rooms = available_rooms + 1
    WHERE property_id = {$_POST['property_id']}";

    $result = mysqli_query($mysqli, $query);

    if ($result) {
        echo "<p>Successfully increased the number of rooms.</p>";
    }
} else {
    echo "Unable to delete.<br>";
}

echo "<a href='dashboard.php'>Back to the dashboard</a>";

?>