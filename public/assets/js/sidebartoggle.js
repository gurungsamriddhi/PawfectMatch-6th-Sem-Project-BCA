
    // Sidebar submenu toggle logic
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.sidebar-link.has-arrow').forEach(function(link) {
        link.addEventListener('click', function(e) {
          // Only toggle if the arrow itself is clicked
          e.preventDefault();
          var parent = link.closest('.sidebar-item');
          parent.classList.toggle('open');
        });
      });
      // Prevent closing submenus when clicking submenu items
      document.querySelectorAll('.first-level .sidebar-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
          // Do nothing: keep submenu open
          var parent = link.closest('.sidebar-item');
          parent.classList.add('open');
        });
      });
    });
    
    