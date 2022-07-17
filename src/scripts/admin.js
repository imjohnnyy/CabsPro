
const searchBooking = () => {
  var xmlhttp_request = new XMLHttpRequest();
  //Returns the value of by the respective element Id's of form data from the DOM

  var booking_reference_number = document.getElementById("bsearch").value;

  const xmlhttp_request_body =
    `bsearch=${encodeURIComponent(booking_reference_number)}`;

  xmlhttp_request.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('reference-record').innerHTML = this.responseText;

    }
  }

  xmlhttp_request.open("POST", "admin.php", true);
  xmlhttp_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttp_request.send(xmlhttp_request_body);

}



const assignBooking = () => {
  document.getElementById("update-status").innerHTML = 'assigned';
  document.getElementById("assign-status").disabled = true;   //Disables the 'assign' button 
  return true;
}


const deleteBooking = () => {
  $(document).ready(function () {
    $('.delete-btn').click(function () {

      // Confirm
      if (!confirm('Are you sure you want to delete this row?')) {
        return false;
      }

      // id need to delete
      var id = $(this).attr('data-id');


      var bsearch = document.getElementById("bsearch").value;

      console.log(id);
      // Current button 
      var obj = this;
      console.log(obj);

      // Delete by ajax request
      $.ajax({
        url: "ajax_delete.php",
        type: "POST",
        data: {
          id: id,
          bsearch: bsearch,
        },
        success: function (result) {
          result = $.trim(result);
          $(obj).parent().parent().remove();
        }
      });

    });
  });

}


const editBooking = () => {
  $(document).ready(function () {
    $('.edit-btn').click(function () {

      // Edit
      if (!confirm('Are you sure you want to edit this row?')) {
        return false;
      }

      // id need to edit
      var id = $(this).attr('edit-id');


      var bsearch = document.getElementById("bsearch").value;

      var cname = document.getElementById("cname").value;
      var phone = document.getElementById("phone").value;
      var unumber = document.getElementById("unumber").value;
      var stname = document.getElementById("stname").value;
      var snumber = document.getElementById("snumber").value;
      var sbname = document.getElementById("sbname").value;
      var dsbname = document.getElementById("dsbname").value;
      var date = document.getElementById("date").value;
      var time = document.getElementById("time").value;

      console.log(id);
      // Current button 
      var obj = this;
      console.log(obj);

      // Edit by ajax request
      $.ajax({
        url: "ajax_edit.php",
        type: "POST",
        data: {
          id: id,
          bsearch: bsearch,
          cname: cname,
          phone: phone,
          unumber: unumber,
          stname: stname,
          snumber: snumber,
          sbname: sbname,
          dsbname: dsbname,
          date: date,
          time: time,
        },
        success: function () {
          alert("Updated!");
          $('#edit-booking-modal').modal('hide');
        }
      });

    });
  });

}