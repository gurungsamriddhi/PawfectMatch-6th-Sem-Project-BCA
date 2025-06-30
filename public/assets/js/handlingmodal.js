$(document).ready(function () {
  // Handle view button click
  let deleteUserId = null; // Store the user ID to delete
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

    

    if (actionType === "delete") {
      deleteUserId = userId;
      $("#deleteConfirmModal").modal("show"); // Show the confirmation modal
    }
  });

  //confirm delete button handler
  $("#confirmDeleteBtn").on("click", function () {
    if (!deleteUserId) 
      return;

    $.ajax({
      url: "index.php?page=admin/delete_center_user",
      type: "POST",
      data: { user_id: deleteUserId },
      success: function (response) {
        if (response.includes("alert-success")) {
          $("#deleteConfirmModal").modal("hide"); // Close the modal
        } else {
          $("#deleteConfirmModal .modal-body").html(
            '<div class="alert alert-danger">Failed to delete user. Try again.</div>'
          );
        }
      },
      error: function () {
        $("#deleteConfirmModal .modal-body").html(
          '<div class="alert alert-danger">Something went wrong.</div>'
        );
      },
    });
  });

  // Reload after modal is fully hidden
  $("#deleteConfirmModal").on("hidden.bs.modal", function () {
    if (deleteUserId) {
      location.reload();
    }
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
