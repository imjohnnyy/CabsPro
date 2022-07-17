<?php
    include '../db/connection.php';

    $connection = mysqli_connect($host, $username, $password, $databaseName);

    $reference_num = $_POST["bsearch"];
    $submit_delete_query = $connection->query("DELETE FROM bookings WHERE reference_num = '$reference_num'");
    
    echo $reference_num;

    mysqli_close($connection);
?>

