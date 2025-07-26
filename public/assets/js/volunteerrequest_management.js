$(document).ready(function () {
  // 1. Handle View button click — load volunteer details in modal via AJAX
  $(".view-btn").on("click", function () {
    const volunteerId = $(this).data("requestid"); // Make sure attribute is data-requestid

    $.ajax({
      url: "index.php?page=admin/volunteer_view",
      type: "POST", // or GET if your backend expects GET
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

  // 2. When clicking Approve & Assign button, set volunteer_id hidden input in modal
  $(".edit-btn").on("click", function () {
    const volunteerId = $(this).data("requestid"); // make sure it's data-requestid attribute in HTML
    $("#approveAssignVolunteerId").val(volunteerId);
  });

  // 3. Handle Approve & Assign form submit via AJAX
  $("#assignApproveForm").on("submit", function (e) {
    e.preventDefault();

    const formData = $(this).serialize();

    // Clear previous messages before sending
    // $("#assignApproveSubmitBtn").prop("disabled", true);
    $("#assignApproveMessage").html("");

    $.ajax({
      url: "index.php?page=admin/approve_and_assign_volunteer",
      method: "POST",
      data: formData,
      dataType: "json",
      success: function (response) {
        if (response.success) {
          // Show success message inside modal
          $("#assignApproveMessage").html(
            '<div class="alert alert-success" role="alert">' +
              response.message +
              "</div>"
          );

          // Optionally close modal after a short delay (e.g., 2 seconds)
          setTimeout(function () {
            $("#assignApproveModal").modal("hide");
            location.reload(); // reload or update page
          }, 2000);
        } else {
          // Show error message inside modal
          $("#assignApproveMessage").html(
            '<div class="alert alert-danger" role="alert">Error: ' +
              response.message +
              "</div>"
          );
        }
      },
      error: function () {
        $("#assignApproveMessage").html(
          '<div class="alert alert-danger" role="alert">An error occurred while assigning volunteer.</div>'
        );
      },
      // complete: function () {
      //   // Re-enable submit button after request completes (optional)
      //   $("#assignApproveSubmitBtn").prop("disabled", false);
      // },
    });
  });

  let volunteerIdToReject = null;
  const rejectModalEl = document.getElementById("rejectConfirmModal");
  const rejectModal = new bootstrap.Modal(rejectModalEl);

  // When user clicks Reject button on list
  $(".delete-btn").on("click", function () {
    volunteerIdToReject = $(this).data("requestid");
    rejectModal.show();
  });

  // When user clicks Reject inside modal to confirm
  $("#confirmRejectBtn").on("click", function () {
    if (!volunteerIdToReject) return;
    // Disable button during processing
    $(this).prop("disabled", true);

    $.ajax({
      url: "index.php?page=admin/reject_volunteer_request",
      method: "POST",
      data: { volunteer_id: volunteerIdToReject },
      dataType: "json",
      success: function (response) {
        let messageHtml = "";

        if (response.success) {
          messageHtml = `<div class="alert alert-success" role="alert">${response.message}</div>`;
          // Optionally close modal and reload after delay
          setTimeout(() => {
            rejectModal.hide();
            location.reload();
          }, 1500);
        } else {
          messageHtml = `<div class="alert alert-danger" role="alert">Error: ${response.message}</div>`;
        }

        // Replace modal body with message and hide footer buttons
        $("#rejectConfirmModal .modal-body").html(messageHtml);
        $("#rejectConfirmModal .modal-footer").hide();
      },
      error: function () {
        const errorHtml =
          '<div class="alert alert-danger" role="alert">An error occurred while rejecting the volunteer request.</div>';
        $("#rejectConfirmModal .modal-body").html(errorHtml);
        $("#rejectConfirmModal .modal-footer").hide();
      },
      complete: function () {
        // Re-enable the button after request (optional if modal closes)
        $("#confirmRejectBtn").prop("disabled", false);
      },
    });
  });

  // Optional: When modal is hidden, reset modal body and footer
  rejectModalEl.addEventListener("hidden.bs.modal", function () {
    $("#rejectConfirmModal .modal-body").text(
      "Are you sure you want to reject this volunteer request?"
    );
    $("#rejectConfirmModal .modal-footer").show();
    volunteerIdToReject = null;
  });
});
