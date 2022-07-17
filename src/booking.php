<?php

	//Accessing the connection details within the connection.php file which are used to connect to the database confidentially.
	include_once '../db/connection.php';
	$connection = mysqli_connect($host, $username, $password, $databaseName);

	// if (!$connection) {
	// 	die("Error: Unable to connect to the ', $databaseName, ' database.<br>" . mysqli_connect_error());
	// } else {
	// 	echo "Successfully connected to the '", $databaseName, "' database!<br>";
	// }

	//When the user clicks on the 'confirmBooking' button on the Confirmation Modal in booking.html the following happens: 
	if (isset($_POST['confirmBooking']) || isset($_POST['confirmBooking']) !== "") {

		//Initializing the optional form data
		$unit_num = $_POST['unumber'];
		$suburb = $_POST['sbname'];
		$destination_suburb = $_POST['dsbname'];

		//Error Checking to see if any data is missing from the Booking Form (the form will not be posted if any mandatory data is missing).

		//Validating the Customer Name
		if (empty($_POST['cname'])) {
			echo '<br> <b>ERROR:</b> The Customer Name is missing. Please enter a Customer Name.';
		} else {
			$customer_name = $_POST['cname'];
		}

		//Validating the Phone Number
		if (empty($_POST['phone'])) {
			echo '<br> <b>ERROR:</b> The Phone Number is missing. Please enter a Phone Number.';
		} else if (strlen((int)$_POST['phone']-8) >= 10 && strlen((int)$_POST['phone']-8) <= 12) {
			$phone_num = $_POST['phone'];
		} else {
			echo '<br> <b>ERROR:</b> The Phone Number length must be between 10 and 12 digits.'; 
		}

		//Validating the Street Number
		if (empty($_POST['snumber'])) {
			echo '<br> <b>ERROR:</b> The Street Number missing. Please a Street Number.';
		} else {
			$street_num = $_POST['snumber'];
		}

		//Validating the Street Name
		if (empty($_POST['stname'])) {
			echo '<br> <b>ERROR:</b> The Street Name is missing. Please enter a Street Name.';
		} else {
			$street_name = $_POST['stname'];
		}

		//Validating the Pick-up Date
		if (empty($_POST['date'])) {
			echo '<br> <b>ERROR:</b> The Pick-up Date is missing. Please enter or select a Date.';
		} else {
			$pick_up_date = date('Y-m-d', strtotime($_POST['date']));
		}

		//Validating the Pick-up Time
		if (empty($_POST['time'])) {
			echo '<br> <b>ERROR:</b> The Pick-up Time is missing. Please enter or select a Time.';
		} else {
			$pick_up_time = $_POST['time'];
		}

		//Setting the current booking time and date, along with the default status as 'unassigned';
		$booking_date_time = date('Y-m-d H:i:s');
		$status = 'unassigned';


		//Generate the booking reference number
		$three_letters = "BRN";
		$five_rand_digits = rand(10000, 99999);
		$reference_num = $three_letters . $five_rand_digits;

		//Submits the form only if all mandatory data are not empty.
		if (isset($customer_name, $phone_num, $street_num, $street_name, $pick_up_date, $pick_up_time)) {

			echo '<div class="alert alert-success" role="alert">The booking has been successfully posted! </div>';
			$submit_insert_query = $connection->query("INSERT INTO bookings (customer_name, phone_num, unit_num, street_num, street_name, suburb, destination_suburb, pick_up_date, pick_up_time, reference_num, booking_date_time, status)
														VALUES('$customer_name', '$phone_num','$unit_num','$street_num', '$street_name',
														'$suburb', '$destination_suburb', '$pick_up_date', '$pick_up_time', '$reference_num', '$booking_date_time', '$status')");
		}


		//Booking confirmation displayed to user after successfully booking a cab
		$submit_booking_query = $connection->query("SELECT reference_num, pick_up_date, pick_up_time, customer_name FROM bookings WHERE reference_num LIKE '%$reference_num%'");


		//Iterates through the 'bookings' table, 
		//and returns data based on the form inputted by the user that are styled as Bootstrap 'cards'.
		foreach ($submit_booking_query as $results) {
		?>
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">
						Thank you <?= $results["customer_name"]; ?> for your booking at CabsOnline!
					</h5>
					<p class="card-text">
						Booking Reference Number: <?= $results["reference_num"]; ?><br>
						Pickup date: <?= $results["pick_up_date"]; ?><br>
						Pickup time: <?= $results["pick_up_time"]; ?><br>
					</p>
				</div>
			</div>
		<?php
		}
		
	}

?>
