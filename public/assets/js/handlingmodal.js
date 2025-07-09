$(document).ready(function () {
  // Handle view button click
  let deleteUserId = null; // Store the user ID to delete
  let resetUserId = null;
  $(".action-buttons").on("click", "button", function () {
    const actionType = $(this).data("action");
    const userId = $(this).data("userid");

    if (actionType === "view") {
      $.ajax({
        url: "index.php?page=admin/fetch_center_details",
        type: "POST",
        data: { user_id: userId },
        success: function (response) {
          $("#viewCenterModal .modal-body").html(response);
        },
        error: function () {
          $("#viewCenterModal .modal-body").html(
            '<p class="text-danger">Failed to load details.</p>'
          );
        },
      });
    }
    if (actionType === "edit") {
      $.ajax({
        url: "index.php?page=admin/fetch_edit_form",
        type: "POST",
        data: { user_id: userId },
        success: function (response) {
          $("#editCenterModal .modal-body").html(response);
        },
        error: function () {
          $("#editCenterModal .modal-body").html(
            '<p class="text-danger">Failed to load edit form.</p>'
          );
        },
      });
    }
    if (actionType === "reset") {
      resetUserId = userId;
      $("#resetConfirmModal").modal("show");
    }

    //deltebutton action start from here
    if (actionType === "delete") {
      deleteUserId = userId;
      $("#deleteConfirmModal").modal("show"); // Show the confirmation modal
    }
  });

  //resetpassword buttonhandler
  $("#confirmResetBtn").on("click", function () {
    if (!resetUserId) return;

    $.ajax({
      url: "index.php?page=admin/reset_password",
      type: "POST",
      data: { user_id: resetUserId },
      success: function (response) {
        if (response.includes("alert-success")) {
          $("#resetConfirmModal .modal-body").html(
            "<p>Password reset successfully and email sent to the adoptioncenter.</p>"
          );
          $("#resetConfirmModal .modal-footer").html(
            '<button type="button" class="btn btn-secondary" id="resetOkBtn">OK</button>'
          );

          $("#resetOkBtn")
            .off("click")
            .on("click", function () {
              $("#resetConfirmModal").modal("hide");
              location.reload();
            });
        } else {
          // Show error inside modal body
          $("#resetConfirmModal .modal-body").html(
            "<p>Failed to reset password. Try again.</p>"
          );
          $("#resetConfirmModal .modal-footer").html(
            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>'
          );
        }
      },
      error: function () {
        $("#resetConfirmModal .modal-body").html(
          "<p>Something went wrong.</p>"
        );
      },
    });
  });

  //confirm delete button handler
  $("#confirmDeleteBtn").on("click", function () {
    if (!deleteUserId) return;

    $.ajax({
      url: "index.php?page=admin/delete_center_user",
      type: "POST",
      data: { user_id: deleteUserId },
      success: function (response) {
        if (response.includes("alert-success")) {
          // Show success message
          $("#deleteConfirmModal .modal-body").html(
            "<p>User deleted successfully.</p>"
          );
          // Replace footer with only OK button
          $("#deleteConfirmModal .modal-footer").html(
            '<button type="button" class="btn btn-secondary" id="deleteOkBtn">OK</button>'
          );

          // Attach click event to OK button
          $("#deleteOkBtn")
            .off("click")
            .on("click", function () {
              $("#deleteConfirmModal").modal("hide");
              location.reload();
            });
        } else {
          $("#deleteConfirmModal .modal-body").html(
            "<p>Failed to delete user. Try again.</p>"
          );
          $("#deleteConfirmModal .modal-footer").html(
            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>'
          );
        }
      },
      error: function () {
        $("#deleteConfirmModal .modal-body").html(
          "<p>Something went wrong.</p>"
        );
      },
    });
  });

  // Submit handler for the edit form
  $("#editCenterModal").on("submit", "#editCenterForm", function (e) {
    e.preventDefault(); // prevent normal form submission

    $.ajax({
      url: "index.php?page=admin/update_center_user",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        if (response.includes("alert-success")) {
          $("#editCenterModal").modal("hide");
          $("#editCenterModal").on("hidden.bs.modal", function () {
            location.reload();
          });
        } else {
          $("#edit-error-msg").html(response);
        }
      },
      error: function () {
        $("#edit-error-msg").html(
          '<div class="alert alert-danger">Something went wrong. Please try again.</div>'
        );
      },
    });
  });
});
