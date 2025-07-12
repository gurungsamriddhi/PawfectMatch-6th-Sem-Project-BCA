$(document).ready(function () {
  

  const replyModalEl = document.getElementById("replyModal");
  let replyModal = null;

  if (replyModalEl) {
    replyModal = new bootstrap.Modal(replyModalEl);

    replyModalEl.addEventListener("hidden.bs.modal", function () {
      location.reload();
    });
  }

  $(".action-buttons").on("click", "button", function () {
    const actionType = $(this).data("action");
    //reply for contact message in admin dashboard
    if (actionType === "reply") {
      const name = $(this).data("name");
      const email = $(this).data("email");
      const message = $(this).data("message");
      const isVerified = $(this).data("is-verified");

      // Fill the modal
      $("#replyMessageId").val($(this).data("message-id"));
      $("#receiverEmail").val(email);
      $("#replyEmail").val(email);
      $("#replyName").val(name);
      $("#replyVerified").val(isVerified);
      $("#originalMessage").val(message);
      $("#replyBody").val("");
      $("#replyStatus").html("");

      if (replyModal) {
        replyModal.show();
      }
    }

  
  });

 //handle replying to the email
  $("#replyForm").on("submit", function (e) {
    e.preventDefault();

    const $submitBtn = $("#replyForm button[type='submit']");
    $submitBtn.prop("disabled", true).text("Sending...");

    $.ajax({
      url: "index.php?page=admin/send_contact_reply",
      type: "POST",
      data: $(this).serialize(),
      success: function (response) {
        if (response.includes("alert-success")) {
          $("#replyStatus").html(
            "<p class='text-success'>Reply sent successfully.</p>"
          );
          $("#replyForm .modal-footer").html(
            '<button type="button" class="btn btn-secondary" id="replyOkBtn">Close</button>'
          );

          $("#replyOkBtn").on("click", function () {
            replyModal.hide();
          });
        } else {
          $("#replyStatus").html(response);
        }

        $submitBtn.prop("disabled", false).text("Send");
      },
      error: function () {
        $("#replyStatus").html(
          '<div class="alert alert-danger">Something went wrong.</div>'
        );
        $submitBtn.prop("disabled", false).text("Send");
      },
    });
  });
});
