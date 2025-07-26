$(document).ready(function () {
  $(".view-btn").on("click", function () {
    const volunteerId = $(this).data("requestid"); // camelCase

    $.ajax({
      url: "index.php?page=admin/volunteer_view",
      type: "POST", // keep POST if you want
      data: { volunteer_id: volunteerId },
      success: function (response) {
        $("#viewRequestBody").html(response);
      },
      error: function () {
        $("#viewRequestBody").html(
          '<p class="text-danger">Failed to load volunteer details.</p>'
        );
      },
    });
  });

  // When clicking Approve & Assign button, set volunteer_id hidden input in modal
  $(".edit-btn").on("click", function () {
    const volunteerId = $(this).data("requestid");
    $("#approveAssignVolunteerId").val(volunteerId);
  });

  // Handle form submit for Approve & Assign
  $("#assignApproveForm").on("submit", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();

    $.ajax({
      url: "index.php?page=admin/approve_and_assign_volunteer", // your controller endpoint
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          alert(response.message);
          // close modal
          $("#assignApproveModal").modal("hide");
          // optionally refresh the page or update the row status dynamically
          location.reload();
        } else {
          alert("Error: " + response.message);
        }
      },
      error: function () {
        alert("An error occurred while assigning volunteer.");
      },
    });
  });
});
