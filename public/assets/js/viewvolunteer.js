$(document).ready(function () {
  // 1. Handle View button click — load volunteer details in modal via AJAX
  $(".view-btn").on("click", function () {
    const volunteerId = $(this).data("requestid"); // Make sure attribute is data-requestid
    console.log("Volunteer ID clicked:", volunteerId); // Debug print

    if (!volunteerId) {
      alert("Volunteer ID missing!");
      return;
    }

    $.ajax({
      url: "index.php?page=adoptioncenter/volunteer_view",
      type: "POST", // or GET if your backend expects GET
      data: { volunteer_id: volunteerId },
      success: function (response) {
         console.log("AJAX response:", response); // Debug print
        $("#viewvolunteerBody").html(response);
        
      },
       error: function () {
        $("#viewvolunteerBody").html(
          '<p class="text-danger">Failed to load volunteer details.</p>'
        );
      },
     
    });
  });
});
