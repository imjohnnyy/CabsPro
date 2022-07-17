<?php
    include '../db/connection.php';

    $connection = mysqli_connect($host, $username, $password, $databaseName);

    $reference_num = $_POST["bsearch"];
    $customer_name = $_POST["cname"];
    $phone_num = $_POST["phone"];
    $unit_num = $_POST["unumber"];
    $street_name = $_POST["stname"];
    $street_num = $_POST["snumber"];
    $suburb = $_POST["sbname"];
    $destination_suburb = $_POST["dsbname"];
    $pick_up_date = $_POST["date"];
    $pick_up_time = $_POST["time"];
    $status = 'unassigned';

    $submit_edit_query = $connection->query("UPDATE bookings SET customer_name='$customer_name', phone_num='$phone_num', 
                                                unit_num='$unit_num', street_num='$street_num', street_name='$street_name', suburb='$suburb',
                                                destination_suburb='$destination_suburb', pick_up_date='$pick_up_date', pick_up_time='$pick_up_time', status='$status'
                                                WHERE reference_num='$reference_num'");
    

    mysqli_close($connection);
?>

