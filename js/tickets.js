$(document).ready(function () {
  // $.fn.dataTable.ext.classes.sPageButton = 'pagination';
  $(document).on("submit", "#ticketReply", function (event) {
    event.preventDefault();
    $("#reply").attr("disabled", "disabled");
    var formData = $(this).serialize();
    $.ajax({
      url: "ticket_action.php",
      method: "POST",
      data: formData,
      success: function (data) {
        console.log(data);
        $("#ticketReply")[0].reset();
        $("#reply").attr("disabled", false);
        location.reload();
      },
    });
  });

  $("#createTicket").click(function () {
    $("#ticketModal").modal("show");
    $("#ticketForm")[0].reset();
    $(".modal-title").html("<i class='fa fa-plus'></i> Create Ticket");
    $("#action").val("createTicket"); //sets the value in add_ticket_model.php
    $("#save").val("Save Ticket");
  });
  if ($("#listTickets").length) {
    var ticketData = $("#listTickets").DataTable({
      dom: "Bfrtip", // Specify the DOM elements to be displayed
      buttons: [
        "excel",
        "pdf",
        "print", // Enable the desired buttons
      ],
      pagingType: "full_numbers",
      lengthChange: false,
      processing: true,
      serverSide: true,
      order: [],
      ajax: {
        url: "ticket_action.php",
        type: "POST",
        data: { action: "listTicket" },
        dataType: "json",
        // success: (d) => {
        //   console.log(d);
        // },
      },
      columnDefs: [
        {
          targets: [0, 6, 7, 8, 9],
          // targets: 4,
          orderable: false,
        },
      ],
      pageLength: 10,
    });

    $(document).on("submit", "#ticketForm", function (event) {
      event.preventDefault();
      $(".loader_bg").css("display", "flex");
      $(".loader_bg").fadeIn();
      $(".loader").css("display", "inline-block");
      $(".loader").show();

      $("#save").attr("disabled", "disabled");
      var formData = $(this).serialize();
      console.log("form Data");
      console.log(formData);

      $.ajax({
        url: "ticket_action.php",
        method: "POST",
        data: formData,

        success: function (data) {
          console.log(data);
          $("#ticketForm")[0].reset();
          $("#ticketModal").modal("hide");
          $("#save").attr("disabled", false);
          ticketData.ajax.reload();

          // alert(data);

          // Send an email
          $.ajax({
            url: "email.php",
            method: "POST",
            data: formData,
            success: function (emailResponse) {
              // Email sending succeeded
              console.log(emailResponse);
              console.log(ticketData.page.info());
              console.log(formData.length);
              // ticketData.ajax.reload();

              alert("Ticket added successfully and email sent!");
            },
            error: function (emailError) {
              console.log(formData);
              // Email sending failed
              console.error(emailError);
              alert("Ticket added successfully, but email sending failed!");
            },
            complete: function () {
              $(".loader").hide();
              $(".loader_bg").fadeOut();
            },
          });

          // error: function(jqXHR, textStatus, errorThrown) {
          // 	// AJAX request failed
          // 	console.error(textStatus, errorThrown);

          // 	// Enable the submit button
          // 	$('#save').attr('disabled', false);

          // 	// Display an error message
          // 	alert("Failed to add ticket. Please try again.");
          //   }

          // },
        },
      });
    });
    $(document).on("click", ".update", function () {
      var ticketId = $(this).attr("id");
      var action = "getTicketDetails";
      $.ajax({
        url: "ticket_action.php",
        method: "POST",
        data: { ticketId: ticketId, action: action },
        dataType: "json",
        success: function (data) {
          console.log(data);
          $("#ticketModal").modal("show");
          $("#ticketId").val(data.id);
          $("#subject").val(data.title);
          $("#message").val(data.init_msg);
          $("#solution").val(data.solution);
          if (data.resolved == "0") {
            $("#open").prop("checked", true);
          } else if (data.resolved == "1") {
            $("#close").prop("checked", true);
          }
          $(".modal-title").html("<i class='fa fa-plus'></i> Edit Ticket");
          $("#action").val("updateTicket");
          $("#save").val("Save Ticket");
        },
      });
    });
    $(document).on("click", ".delete", function () {
      var ticketId = $(this).attr("id");
      var action = "closeTicket";
      if (confirm("Are you sure you want to close this ticket?")) {
        $.ajax({
          url: "ticket_action.php",
          method: "POST",
          data: { ticketId: ticketId, action: action },
          success: function (data) {
            ticketData.ajax.reload();
          },
        });
      } else {
        return false;
      }
    });
  }
});
