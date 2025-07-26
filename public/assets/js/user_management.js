$(document).ready(function () {
  let deleteUserId = null;
//   let suspendUserId = null;
//   let suspendUserStatus = null;
//   let suspendAction = null;

  $(".action-buttons").on("click", "button", function () {
    const actionType = $(this).data("action");
    const userId = $(this).data("userid");
    const status = $(this).data("status");

    if (actionType === "view") {
      $.ajax({
        url: "index.php?page=admin/user_view",
        type: "POST",
        data: { user_id: userId },
        success: function (response) {
          $("#viewuserModal .modal-body").html(response);
        },
        error: function () {
          $("#viewuserModal .modal-body").html(
            '<p class="text-danger">Failed to load user details.</p>'
          );
        },
      });
    }

    // if (actionType === "suspend") {
    //   suspendUserId = userId;
    //   suspendUserStatus = status;
    //   suspendAction = suspendUserStatus === "suspended" ? "unsuspend" : "suspend";
    //   $("#suspendConfirmModal").modal("show");
    // }

    if (actionType === "delete") {
      deleteUserId = userId;
      $("#deleteConfirmModal").modal("show");
    }
  });

  $("#confirmDeleteBtn").on("click", function () {
    if (!deleteUserId) return;

    $.ajax({
      url: "index.php?page=admin/user_delete",
      type: "POST",
      data: { user_id: deleteUserId },
      success: function (response) {
        if (response.includes("alert-success")) {
          $("#deleteConfirmModal .modal-body").html(
            "<p>User deleted successfully (status set to deleted).</p>"
          );
          $("#deleteConfirmModal .modal-footer").html(
            '<button type="button" class="btn btn-secondary" id="deleteOkBtn">OK</button>'
          );

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
        }
      },
      error: function () {
        $("#deleteConfirmModal .modal-body").html(
          "<p>Something went wrong.</p>"
        );
      },
    });
  });

//   $("#confirmSuspendBtn").on("click", function () {
//     if (!suspendUserId) return;

//     $.ajax({
//       url: "index.php?page=admin/user_suspend",
//       type: "POST",
//       data: { user_id: suspendUserId, action: suspendAction },
//       success: function (response) {
//         if (response.includes("alert-success")) {
//           $("#suspendConfirmModal .modal-body").html(
//             "<p>User suspended successfully.</p>"
//           );
//           $("#suspendConfirmModal .modal-footer").html(
//             '<button type="button" class="btn btn-secondary" id="suspendOkBtn">OK</button>'
//           );

//           $("#suspendOkBtn")
//             .off("click")
//             .on("click", function () {
//               $("#suspendConfirmModal").modal("hide");
//               location.reload();
//             });
//         } else {
//           $("#suspendConfirmModal .modal-body").html(
//             "<p>Failed to suspend user. Try again.</p>"
//           );
//         }
//       },
//       error: function () {
//         $("#suspendConfirmModal .modal-body").html(
//           "<p>Something went wrong.</p>"
//         );
//       },
//     });
//   });
});
