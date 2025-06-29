$(document).ready(function() {
  // Handle view button click
  $('.action-buttons').on('click', 'button', function() {
    const actionType = $(this).data('action');
    const userId = $(this).data('userid');
if (actionType==='view'){
    $.ajax({
      url: 'index.php?page=admin/fetch_center_details',
      type: 'POST',
      data: { user_id: userId },
      success: function(response) {
        $('#viewCenterModal .modal-body').html(response);
      },
      error: function() {
        $('#viewCenterModal .modal-body').html('<p class="text-danger">Failed to load details.</p>');
      }
    });
  }
  });
});
