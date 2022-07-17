const bookingProcess = () => {

  var xmlhttp_request = new XMLHttpRequest();
  //Returns the value of by the respective element Id's of form data from the DOM

  var form_customer_name = document.getElementById("cname").value;
  var form_phone_number = document.getElementById("phone").value;
  var form_unit_number = document.getElementById("unumber").value;
  var form_street_number = document.getElementById("snumber").value;
  var form_street_name = document.getElementById("stname").value;
  var form_suburb = document.getElementById("sbname").value;
  var form_destination_suburb = document.getElementById("dsbname").value;
  var form_pick_up_date = document.getElementById("date").value;
  var form_pick_up_time = document.getElementById("time").value;


  const xmlhttp_request_body =
    `cname=${encodeURIComponent(form_customer_name)}
      &phone=${encodeURIComponent(form_phone_number)}
      &unumber=${encodeURIComponent(form_unit_number)}
      &snumber=${encodeURIComponent(form_street_number)}
      &stname=${encodeURIComponent(form_street_name)}
      &sbname=${encodeURIComponent(form_suburb)}
      &dsbname=${encodeURIComponent(form_destination_suburb)}
      &date=${encodeURIComponent(form_pick_up_date)}
      &time=${encodeURIComponent(form_pick_up_time)}`;



  xmlhttp_request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('reference').innerHTML = this.responseText;
      //Disables the confirm booking button after first submission
      document.getElementById('confirmBooking').disabled = true;

    }
  }

  xmlhttp_request.open("POST", "booking.php", true);
  xmlhttp_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp_request.send(xmlhttp_request_body);

}


const makeAnotherBooking = () => {
  //Resets the reference element when 'Make another booking' button is clicked
  document.getElementById("reference").innerHTML = "";
  document.getElementById("confirmBooking").disabled = false;   //Enables the 'Book a cab' button again

  var removeCancelButton = document.getElementById('cancel');
  removeCancelButton.parentNode.removeChild(removeCancelButton);
  return false;

}