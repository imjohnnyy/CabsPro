<?php

//Accessing the connection details within the connection.php file which are used to connect to the database confidentially.
include_once '../db/connection.php';
$connection = mysqli_connect($host, $username, $password, $databaseName);

// if (!$connection) {
//     die("Error: Unable to connect to the ', $databaseName, ' database.<br>" . mysqli_connect_error());
// } else {
//     echo "Successfully connected to the '", $databaseName, "' database!<br>";
// }


//When the user clicks on the 'Search Requests' button in the Admin page the following happens: 
if (isset($_POST['sbutton']) || isset($_POST['sbutton']) !== "") {

    $input = $_POST['bsearch'];
    //If the user input is empty then:
    if (empty($input)) {
        //Display a list of bookings with the 'unassigned' status and that are within 2 hours from the current date and time

        $submit_two_hours_pick_up_query = $connection->query("SELECT * FROM bookings WHERE status = 'unassigned' AND (pick_up_time <= ADDTIME(CURRENT_TIME(), '02:00:00') AND pick_up_date >= CURRENT_DATE())");

        if ($submit_two_hours_pick_up_query->num_rows > 0) {
?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="table-primary" scope="col">Booking Reference Number</th>
                            <th class="table-primary" scope="col">Customer Name</th>
                            <th class="table-primary" scope="col">Phone</th>
                            <th class="table-primary" scope="col">Pickup Suburb</th>
                            <th class="table-primary" scope="col">Destination Suburb</th>
                            <th class="table-primary" scope="col">Pickup Date</th>
                            <th class="table-primary" scope="col">Pickup Time</th>
                            <th class="table-primary" scope="col">Status</th>
                            <th class="table-primary" scope="col">Assign</th>
                            <th class="table-primary" scope="col">Remove</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <?php
            //Iterates through the 'bookings' table and returns table headers, along with the respective data into each table cell
            foreach ($submit_two_hours_pick_up_query as $results) {
                $id = $results['customer_id'];
            ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                            <td><?= $results['reference_num']; ?></td>
                            <td><?= $results['customer_name']; ?></td>
                            <td><?= $results['phone_num']; ?></td>
                            <td><?= $results['suburb']; ?></td>
                            <td><?= $results['destination_suburb']; ?></td>
                            <td><?= $results['pick_up_date']; ?></td>
                            <td><?= $results['pick_up_time']; ?></td>
                            <td id="update-status"><?= $results['status']; ?></td>

                            <!-- The 'assign' button that is used to changed the status from 'unassigned' to 'assigned'  -->
                            <td><button type="button" name="assign-status" id="assign-status" class="btn btn-info" onClick="assignBooking()">Assign</button></td>
                            <td><button type="button" name="delete-btn" class="btn btn-danger delete-btn" data-id=<?php echo $results["customer_id"]; ?> onClick="deleteBooking()">Remove</button></td>


                            <?php
                            //Generate the booking reference number
                            $three_letters = "BRN";
                            $five_rand_digits = rand(10000, 99999);
                            $reference_num = $three_letters . $five_rand_digits;
                            $submit_update_status_query = $connection->query("UPDATE bookings SET status='assigned' WHERE reference_num = '$reference_num'");
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            }
        } else { //If there are no bookings with the 'unassigned' status that are within 2 hours from the current date and time, returns the following message:
            echo '<br> <b>The search is currently empty </b>';
        }
    } else {

        $reference_num = $_POST['bsearch'];

        $submit_search_query = $connection->query("SELECT * FROM bookings WHERE reference_num = '$reference_num'");

        //Checking if the Reference number already exists in the 'bookings' table or not.
        if ($submit_search_query->num_rows > 0) {

            //Iterates through the 'bookings' table and returns table headers, along with the respective data into each table cell
            foreach ($submit_search_query as $results) {
                $id = $results['customer_id'];
            ?>
                <div class="table-responsive-lg">
                    <table class="table table-hover">
                        <thead>
                            <th class="table-primary" scope="col">Booking Reference Number</th>
                            <th class="table-primary" scope="col">Customer Name</th>
                            <th class="table-primary" scope="col">Phone Number</th>
                            <th class="table-primary" scope="col">Pickup Date&nbsp&nbsp&nbsp&nbsp</th>
                            <th class="table-primary" scope="col">Pickup Time</th>
                            <th class="table-primary" scope="col">Pickup Suburb</th>
                            <th class="table-primary" scope="col">Destination Suburb</th>
                            <th class="table-primary" scope="col">Status</th>
                            <th class="table-primary" scope="col"></th>
                            <th class="table-primary" scope="col">Actions</th>
                            <th class="table-primary" scope="col"></th>
                        </thead>
                        <tbody>
                            <td><?= $results['reference_num']; ?></td>
                            <td><?= $results['customer_name']; ?></td>
                            <td><?= $results['phone_num']; ?></td>
                            <td class="table-data"><?= $results['pick_up_date']; ?></td>
                            <td class="table-data"><?= $results['pick_up_time']; ?></td>
                            <td class="table-data"><?= $results['suburb']; ?></td>
                            <td class="table-data"><?= $results['destination_suburb']; ?></td>
                            <td id="update-status"><?= $results['status']; ?></td>

                            <!-- The 'assign' button that is used to changed the status from 'unassigned' to 'assigned'  -->
                            <td><button type="button" name="assign-status" id="assign-status" class="btn btn-primary" onClick="assignBooking()">Assign</button></td>
                            <td><button type="button" name="delete-btn" class="btn btn-danger delete-btn" data-id=<?php echo $results["customer_id"]; ?> onClick="deleteBooking()">Remove</button></td>
                            <td><button type="button" name="edit-modal-btn" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#edit-booking-modal">Edit</button></td>


                            <!-- The Edit Booking Modal -->
                            <div class="modal" id="edit-booking-modal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Booking</h4>
                                            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <form action="" method="POST" id="edit-form">
                                                <input class="form-control" type="hidden" name="id">
                                                <div class="form-group">
                                                    <label>Customer Name</label>
                                                    <input type="text" class="form-control" id="cname" name="cname" value="<?php echo $results['customer_name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $results['phone_num']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Unit Number (Optional)</label>
                                                    <input type="text" class="form-control" id="unumber" name="unumber" value="<?php echo $results['unit_num']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Street Number</label>
                                                    <input type="text" class="form-control" id="snumber" name="snumber" value="<?php echo $results['street_num']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Street Name</label>
                                                    <input type="text" class="form-control" id="stname" name="stname" value="<?php echo $results['street_name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Suburb (Optional)</label>
                                                    <input type="text" class="form-control" id="sbname" name="sbname" value="<?php echo $results['suburb']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Destination Suburb (Optional)</label>
                                                    <input type="text" class="form-control" id="dsbname" name="dsbname" value="<?php echo $results['destination_suburb']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Pick-up Date</label>
                                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $results['pick_up_date']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label>Pick-up Time</label>
                                                    <input type="time" class="form-control" id="time" name="time" value="<?php echo $results['pick_up_time']; ?>">
                                                </div>
                                                <button type="button" class="btn btn-primary edit-btn" name="edit-btn" edit-id=<?php echo $results["customer_id"]; ?> onClick="editBooking()">Confirm Update</button>
                                                <button type="button" name="cancel" id="cancel" class="btn btn-danger float-right" data-bs-dismiss="modal">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!--  Updating the status to 'assigned' in the database  -->
                            <?php
                            $submit_update_status_query = $connection->query("UPDATE bookings SET status='assigned' WHERE reference_num = '$reference_num'");
                            ?>
                            <br><br><br>
                        </tbody>

                    </table>
                </div>

<?php
            }
        } else if (!preg_match('/^BRN\d{5}$/', $reference_num)) {   //Checking if the user inputted Reference Number matches the correct format.

            echo '<div class="alert alert-danger" role="alert"> <b>ERROR:</b> The reference number must be in the format of e.g. "BRN12345" - Starts with BRN then followed by 5 digits. </div>';
        } else {    //Prompts an error message when the reference number inserted does not exist in the database.
            echo '<div class="alert alert-danger" role="alert">This reference number <b>', $reference_num, '</b> does not exist! Please enter an existing one! </div>';
        }
    }
}

?>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" src="admin.js"></script>